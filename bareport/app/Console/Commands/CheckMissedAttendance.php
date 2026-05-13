<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Attendance;
use App\Models\AttendanceRequest;
use App\Models\Setting;
use App\Notifications\MissedAttendanceNotification;

class CheckMissedAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-missed-attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek BA yang tidak absensi sama sekali (Alpha) atau hanya absensi masuk tanpa check-out';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Karena dijalankan di 00:00, kita mengecek absensi untuk hari kemarin
        $targetDate = now('Asia/Jakarta')->subDay();
        $targetDayIso = $targetDate->dayOfWeekIso;

        $workingDays = json_decode(Setting::getValue('working_days', '[1,2,3,4,5,6,7]'), true);
        if (!is_array($workingDays)) {
            $workingDays = [];
        }

        // Jika hari kemarin bukan hari kerja, maka eksekusi dibatalkan
        if (!in_array($targetDayIso, $workingDays)) {
            $this->info("Pengecekan diabaikan karena {$targetDate->toDateString()} bukan hari kerja.");
            return;
        }

        $dateStr = $targetDate->toDateString();
        $bas = User::where('role', 'ba')->get();

        foreach ($bas as $ba) {
            $checkIn = Attendance::where('user_id', $ba->id)
                ->where('date', $dateStr)
                ->where('type', 'check-in')
                ->first();

            $checkOut = Attendance::where('user_id', $ba->id)
                ->where('date', $dateStr)
                ->where('type', 'check-out')
                ->first();

            // Skenario 1: Tidak ada check-in sama sekali (Alpha)
            if (!$checkIn) {
                $this->createRequestAndNotify($ba, 'check-in', 'Alpha', "Sistem otomatis merekam Anda Alpha pada {$dateStr}.");
            }
            // Skenario 2: Ada check-in tapi tidak ada check-out
            elseif ($checkIn && !$checkOut) {
                // Jangan ditimpa kalau sudah ada request check-out auto sebelumnya
                $this->createRequestAndNotify($ba, 'check-out', 'Tidak Check-out', "Sistem merekam Anda lupa check-out pada {$dateStr}.");
            }
        }

        $this->info("Pengecekan absensi lupa/alpha untuk BA selesai.");
    }

    /**
     * Fungsi Helper untuk mendaftarkan AttendanceRequest otomatis
     */
    private function createRequestAndNotify($ba, string $type, string $reason, string $notes)
    {
        $dateStr = now('Asia/Jakarta')->subDay()->toDateString();

        // Cek dulu biar tidak duplicate request otomatisnya kalau command ke-run berkali-kali
        $exists = AttendanceRequest::where('user_id', $ba->id)
            ->where('date', $dateStr)
            ->where('reason', $reason)
            ->exists();

        if ($exists) {
            return;
        }

        // Tembak waktu default saja jika Alpha (misal: 00:00). Tapi kalau tidak check-out, disesuaikan ke jam pulang absen.
        $timeStr = $type === 'check-out' ? Setting::getValue('attendance_end_time', '17:00') : '07:00';

        $outletId = null;
        if ($type === 'check-out') {
            // Coba ambil outlet dari check-in nya kalau ada
            $checkInRec = Attendance::where('user_id', $ba->id)->where('date', $dateStr)->where('type', 'check-in')->first();
            if ($checkInRec) {
                $outletId = $checkInRec->outlet_id;
            }
        }

        if (!$outletId) {
            $outletId = $ba->outlets()->first()->id ?? null;
        }

        $attRequest = AttendanceRequest::create([
            'user_id' => $ba->id,
            'outlet_id' => $outletId,
            'type' => $type,
            'date' => $dateStr,
            'time' => $timeStr,
            'reason' => $reason,
            'status' => 'pending',
        ]);

        $ba->notify(new \App\Notifications\MissedAttendanceNotification($attRequest, $reason));
    }
}
