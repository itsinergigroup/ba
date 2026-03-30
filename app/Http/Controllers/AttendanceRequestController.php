<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRequest;
use App\Models\Attendance;
use App\Models\Outlet;
use App\Models\User;
use App\Notifications\AttendanceRequestSubmitted;
use App\Notifications\AttendanceRequestProcessed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class AttendanceRequestController extends Controller
{
    /**
     * Display a listing of attendance requests for the BA.
     */
    public function index()
    {
        $requests = AttendanceRequest::with('outlet')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('attendance.request.index', compact('requests'));
    }

    /**
     * Show the form for creating a new attendance request.
     */
    public function create()
    {
        $outlets = auth()->user()->outlets;
        return view('attendance.request.create', compact('outlets'));
    }

    /**
     * Store a newly created attendance request in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'outlet_id' => 'nullable|exists:outlets,id',
            'type' => 'required|in:check-in,check-out',
            'date' => 'required|date|before_or_equal:today',
            'time' => 'required',
            'reason' => 'required|string|min:10',
        ]);

        $attendanceRequest = AttendanceRequest::create([
            'user_id' => auth()->id(),
            'outlet_id' => $request->outlet_id,
            'type' => $request->type,
            'date' => $request->date,
            'time' => $request->time,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        // Kirim notifikasi ke Admin
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new AttendanceRequestSubmitted($attendanceRequest));

        return redirect()->route('attendance.request.index')->with('success', 'Pengajuan absen ulang berhasil dikirim. Mohon tunggu persetujuan admin.');
    }

    /**
     * Display a listing of all attendance requests for Admin.
     */
    public function adminIndex(Request $request)
    {
        $query = AttendanceRequest::with(['user', 'outlet'])->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $requests = $query->paginate(10);

        return view('admin.attendance.request.index', compact('requests'));
    }

    /**
     * Update the status of the attendance request (Approve/Reject).
     */
    public function adminUpdate(Request $request, AttendanceRequest $attendanceRequest)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_note' => 'nullable|string',
        ]);

        if ($attendanceRequest->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $attendanceRequest->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note,
        ]);

        if ($request->status === 'approved') {
            // Create the real attendance record
            Attendance::create([
                'user_id' => $attendanceRequest->user_id,
                'outlet_id' => $attendanceRequest->outlet_id,
                'type' => $attendanceRequest->type,
                'latitude' => 0, // Manual insertion doesn't have GPS
                'longitude' => 0,
                'photo_path' => 'manual_insertion.jpg', // Placeholder
                'status' => 'present',
                'date' => $attendanceRequest->date,
                'time' => $attendanceRequest->time,
                'attendance_request_id' => $attendanceRequest->id,
            ]);
        }

        // Kirim notifikasi ke BA
        $attendanceRequest->user->notify(new AttendanceRequestProcessed($attendanceRequest));

        return redirect()->route('admin.attendance-requests.index')->with('success', 'Status pengajuan berhasil diperbarui.');
    }
}
