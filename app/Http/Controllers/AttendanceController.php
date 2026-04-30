<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Setting;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('outlet')
            ->where('user_id', auth()->id())
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc');

        if ($request->from_date) {
            $query->whereDate('date', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('date', '<=', $request->to_date);
        }

        $attendances = $query->paginate(10);

        return view('attendance.index', compact('attendances'));
    }

    public function create()
    {
        $user = auth()->user();
        $outlets = $user->outlets;

        $workingDays = json_decode(Setting::getValue('working_days', '[1,2,3,4,5,6,7]'), true);
        $currentDay = now('Asia/Jakarta')->dayOfWeekIso;

        if (!in_array($currentDay, $workingDays)) {
            return redirect()->route('attendance.index')->with('error', "Mohon maaf, absensi tidak tersedia. Hari ini bukan hari kerja.");
        }

        if ($user->hasApprovedDayOffToday()) {
            return redirect()->route('attendance.index')->with('success', "Hari ini adalah hari libur (Day-Off) Anda yang telah disetujui. Anda tidak perlu melakukan absensi hari ini.");
        }

        if ($user->hasFinishedAttendanceToday()) {
            $startTime = Setting::getValue('attendance_start_time', '07:00');
            return redirect()->route('attendance.index')->with('success', "Terima kasih, Anda telah menyelesaikan absensi hari ini. Menu absensi akan kembali tersedia besok pagi mulai pukul $startTime WIB.");
        }

        $lastAttendance = Attendance::where('user_id', $user->id)
            ->where('date', now('Asia/Jakarta')->toDateString())
            ->orderBy('time', 'desc')
            ->first();

        $nextType = ($lastAttendance && $lastAttendance->type === 'check-in') ? 'check-out' : 'check-in';

        $durationStatus = 'allowed';
        $remainingMinutes = 0;
        $minHours = (int) Setting::getValue('minimum_work_hours', 8);

        if ($nextType === 'check-out') {
            $checkIn = $user->getTodayCheckIn();
            if ($checkIn) {
                $checkInTime = \Carbon\Carbon::parse($checkIn->date . ' ' . $checkIn->time, 'Asia/Jakarta');
                $durationInMinutes = now('Asia/Jakarta')->diffInMinutes($checkInTime);
                
                $minHours = (int) Setting::getValue('minimum_work_hours', 8);
                $minMinutes = $minHours * 60;

                if ($durationInMinutes < $minMinutes) { // Dynamic limit
                    $durationStatus = 'blocked';
                    $remainingMinutes = $minMinutes - $durationInMinutes;
                }
            }
        }

        return view('attendance.create', compact('outlets', 'nextType', 'lastAttendance', 'durationStatus', 'remainingMinutes', 'minHours'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'outlet_id' => 'nullable|exists:outlets,id',
            'type' => 'required|in:check-in,check-out',
            'latitude' => 'required',
            'longitude' => 'required',
            'photo' => 'required', // base64 photo
        ]);

        $currentTime = now('Asia/Jakarta');
        $currentHour = $currentTime->format('H:i');

        $workingDays = json_decode(Setting::getValue('working_days', '[1,2,3,4,5,6,7]'), true);
        $currentDay = $currentTime->dayOfWeekIso;

        if (!in_array($currentDay, $workingDays)) {
            return back()->with('error', "Mohon maaf, absensi saat ini tidak dapat dilakukan. Hari ini bukan hari kerja.");
        }

        $startTime = Setting::getValue('attendance_start_time', '07:00');
        $endTime = Setting::getValue('attendance_end_time', '17:00');

        if (auth()->user()->hasApprovedDayOffToday()) {
            return back()->with('error', "Mohon maaf, Anda tidak dapat melakukan absensi pada hari libur (Day-Off) yang telah disetujui.");
        }

        // Shift validation
        if ($currentHour < $startTime || $currentHour > $endTime) {
            return back()->with('error', "Mohon maaf, absensi saat ini tidak dapat dilakukan. Sesuai ketentuan, absensi hanya tersedia antara pukul $startTime hingga $endTime WIB. (Waktu saat ini: $currentHour)");
        }

        if ($request->type === 'check-out') {
            $checkIn = auth()->user()->getTodayCheckIn();
            if ($checkIn) {
                $checkInTime = \Carbon\Carbon::parse($checkIn->date . ' ' . $checkIn->time, 'Asia/Jakarta');
                $durationInMinutes = now('Asia/Jakarta')->diffInMinutes($checkInTime);
                
                $minHours = (int) Setting::getValue('minimum_work_hours', 8);
                $minMinutes = $minHours * 60;

                if ($durationInMinutes < $minMinutes) {
                    $remainingHours = floor(( $minMinutes - $durationInMinutes) / 60);
                    $remainingMins = ( $minMinutes - $durationInMinutes) % 60;
                    return back()->with('error', "Anda belum mencapai batas minimal waktu kerja {$minHours} jam. Sisa waktu: {$remainingHours} jam {$remainingMins} menit.");
                }
            } else {
                 return back()->with('error', "Data check-in hari ini tidak ditemukan.");
            }
        }

        // Prevent duplicate check-in or multiple check-outs for the same day
        $alreadyDone = Attendance::where('user_id', auth()->id())
            ->where('date', $currentTime->toDateString())
            ->where('type', $request->type)
            ->exists();

        if ($alreadyDone) {
            $typeLabel = $request->type === 'check-in' ? 'Masuk' : 'Pulang';
            return redirect()->route('attendance.index')->with('error', "Sistem mencatat Anda sudah melakukan absensi $typeLabel hari ini. Silakan kembali esok hari.");
        }

        // Handle photo upload
        $photoData = $request->input('photo');
        $photoData = str_replace('data:image/jpeg;base64,', '', $photoData);
        $photoData = str_replace(' ', '+', $photoData);
        $imageName = 'attendance/' . auth()->id() . '_' . time() . '.jpg';
        \Storage::disk('public')->put($imageName, base64_decode($photoData));

        Attendance::create([
            'user_id' => auth()->id(),
            'outlet_id' => $request->outlet_id ?: null,
            'type' => $request->type,
            'late_minutes' => 0,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'photo_path' => $imageName,
            'date' => $currentTime->toDateString(),
            'time' => $currentTime->toTimeString(),
            'status' => 'present',
        ]);

        if ($request->type === 'check-in') {
            $message = "Check-in berhasil tercatat. Selamat bekerja dan semoga harimu menyenangkan!";
        } else {
            $message = "Check-out berhasil tercatat. Terima kasih atas kerja keras Anda hari ini!";
        }

        return redirect()->route('attendance.index')->with('success', $message);
    }

    public function show(Attendance $attendance)
    {
        if (auth()->id() !== $attendance->user_id) {
            abort(403, 'Unauthorized access.');
        }

        $attendance->load(['user', 'outlet']);
        return view('attendance.show', compact('attendance'));
    }

    public function adminIndex(Request $request)
    {
        $query = Attendance::with(['user', 'outlet'])->orderBy('date', 'desc')->orderBy('time', 'desc');

        if ($request->from_date) {
            $query->whereDate('date', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('date', '<=', $request->to_date);
        }

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        $attendances = $query->paginate(8);
        $users = \App\Models\User::where('role', 'ba')->get();

        return view('admin.attendance.index', compact('attendances', 'users'));
    }

    public function adminExport(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $userId = $request->input('user_id');

        $fileName = 'Log_Absensi_BA';
        if ($fromDate && $toDate) {
            $fileName .= '_' . $fromDate . '_sd_' . $toDate;
        } else {
            $fileName .= '_' . date('Y_m_d');
        }
        $fileName .= '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\AttendanceExport($fromDate, $toDate, $userId),
            $fileName
        );
    }
    public function adminShow(Attendance $attendance)
    {
        $attendance->load(['user', 'outlet']);
        return view('admin.attendance.show', compact('attendance'));
    }
}
