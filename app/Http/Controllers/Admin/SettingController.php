<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function attendance()
    {
        $settings = Setting::where('group', 'attendance')->pluck('value', 'key')->all();

        // Ensure defaults if not seeded
        $settings['attendance_start_time'] = $settings['attendance_start_time'] ?? '07:00';
        $settings['attendance_end_time'] = $settings['attendance_end_time'] ?? '17:00';
        $settings['check_in_limit'] = $settings['check_in_limit'] ?? '08:00';
        $settings['working_days'] = isset($settings['working_days']) ? json_decode($settings['working_days'], true) : [1, 2, 3, 4, 5, 6, 7];

        return view('admin.settings.attendance', compact('settings'));
    }

    public function updateAttendance(Request $request)
    {
        $request->validate([
            'attendance_start_time' => 'required|date_format:H:i',
            'attendance_end_time' => 'required|date_format:H:i|after:attendance_start_time',
            'check_in_limit' => 'required|date_format:H:i|after:attendance_start_time|before:attendance_end_time',
            'working_days' => 'required|array|min:1',
            'working_days.*' => 'integer|between:1,7',
        ], [
            'attendance_start_time.required' => 'Waktu mulai absensi harus diisi.',
            'attendance_end_time.required' => 'Waktu selesai absensi harus diisi.',
            'attendance_end_time.after' => 'Waktu selesai harus setelah waktu mulai.',
            'check_in_limit.required' => 'Batas waktu check-in harus diisi.',
            'check_in_limit.after' => 'Batas check-in harus setelah waktu mulai.',
            'check_in_limit.before' => 'Batas check-in harus sebelum waktu selesai.',
            'working_days.required' => 'Hari kerja minimal dipilih 1 hari.',
        ]);

        Setting::setValue('attendance_start_time', $request->attendance_start_time, 'attendance');
        Setting::setValue('attendance_end_time', $request->attendance_end_time, 'attendance');
        Setting::setValue('check_in_limit', $request->check_in_limit, 'attendance');
        Setting::setValue('working_days', json_encode($request->working_days), 'attendance');

        return back()->with('success', 'Pengaturan jadwal berhasil diperbarui.');
    }
}
