<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Shared Dashboard or BA Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // BA Specific Routes
    Route::middleware(['role:ba'])->group(function () {
        Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/create', [\App\Http\Controllers\ReportController::class, 'create'])->name('reports.create');
        Route::post('/reports', [\App\Http\Controllers\ReportController::class, 'store'])->name('reports.store');
        Route::get('/reports/{report}/edit', [\App\Http\Controllers\ReportController::class, 'edit'])->name('reports.edit');
        Route::patch('/reports/{report}', [\App\Http\Controllers\ReportController::class, 'update'])->name('reports.update');
        Route::delete('/reports/{report}', [\App\Http\Controllers\ReportController::class, 'destroy'])->name('reports.destroy');

        // Attendance Routes
        Route::get('/attendance', [\App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/attendance/create', [\App\Http\Controllers\AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('/attendance', [\App\Http\Controllers\AttendanceController::class, 'store'])->name('attendance.store');
        Route::get('/attendance/{attendance}', [\App\Http\Controllers\AttendanceController::class, 'show'])->name('attendance.show');

        // Attendance Request Routes
        Route::get('/attendance-request', [\App\Http\Controllers\AttendanceRequestController::class, 'index'])->name('attendance.request.index');
        Route::get('/attendance-request/create', [\App\Http\Controllers\AttendanceRequestController::class, 'create'])->name('attendance.request.create');
        Route::post('/attendance-request', [\App\Http\Controllers\AttendanceRequestController::class, 'store'])->name('attendance.request.store');
    });

    Route::get('/reports/{report}', [\App\Http\Controllers\ReportController::class, 'show'])->name('reports.show');

    // API helpers for dropdowns (Shared for BA and Admin)
    Route::get('/api/provinces/{distributor}', function (\App\Models\Distributor $distributor) {
        return \App\Models\Province::whereHas('cities.outlets.users', function ($q) use ($distributor) {
            $q->where('distributor_id', $distributor->id)->where('role', 'ba');
        })->orderBy('name')->get();
    });
    Route::get('/api/cities/{province}', function (\App\Models\Province $province) {
        $user = auth()->user();
        if ($user->role === 'ba') {
            return $user->outlets()
                ->whereHas('city', fn($q) => $q->where('province_id', $province->id))
                ->get()
                ->pluck('city')
                ->unique('id')
                ->sortBy('name')
                ->values();
        }
        return $province->cities()->orderBy('name')->get();
    });
    Route::get('/api/products/{brand}', function (\App\Models\Brand $brand) {
        return $brand->products()->orderBy('name')->get();
    });
    Route::get('/api/outlets/{city}', function (\App\Models\City $city) {
        $user = auth()->user();
        if ($user->role === 'ba') {
            return $user->outlets()->where('city_id', $city->id)->orderBy('name')->get();
        }
        return $city->outlets()->orderBy('name')->get();
    });

    // Admin Specific Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/export/reports', [\App\Http\Controllers\Admin\ExportController::class, 'reports'])->name('export.reports');

        // Master Data
        Route::resource('brands', \App\Http\Controllers\Master\BrandController::class);
        Route::resource('products', \App\Http\Controllers\Master\ProductController::class);
        Route::resource('distributors', \App\Http\Controllers\Master\DistributorController::class);
        Route::resource('provinces', \App\Http\Controllers\Master\ProvinceController::class);
        Route::resource('cities', \App\Http\Controllers\Master\CityController::class);
        Route::resource('outlets', \App\Http\Controllers\Master\OutletController::class);
        // User Management
        Route::patch('users/{user}/toggle', [\App\Http\Controllers\Admin\UserController::class, 'toggle'])->name('users.toggle');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

        // Attendance Logs
        Route::get('/attendance', [\App\Http\Controllers\AttendanceController::class, 'adminIndex'])->name('attendance.index');
        Route::get('/attendance/export', [\App\Http\Controllers\AttendanceController::class, 'adminExport'])->name('attendance.export');
        Route::get('/attendance/{attendance}', [\App\Http\Controllers\AttendanceController::class, 'adminShow'])->name('attendance.show');

        // Attendance Request Management
        Route::get('/attendance-requests', [\App\Http\Controllers\AttendanceRequestController::class, 'adminIndex'])->name('attendance-requests.index');
        Route::patch('/attendance-requests/{attendance_request}', [\App\Http\Controllers\AttendanceRequestController::class, 'adminUpdate'])->name('attendance-requests.update');

        // Settings
        Route::get('/settings/attendance', [\App\Http\Controllers\Admin\SettingController::class, 'attendance'])->name('settings.attendance');
        Route::post('/settings/attendance', [\App\Http\Controllers\Admin\SettingController::class, 'updateAttendance'])->name('settings.attendance.update');
    });

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications
    Route::post('/notifications/mark-as-read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});

require __DIR__ . '/auth.php';
