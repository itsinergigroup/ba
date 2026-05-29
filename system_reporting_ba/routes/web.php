<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Shared Dashboard or BA Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // BA & Viewer Specific Routes
    Route::middleware(['role:admin,ba,rbs,kam,view user only'])->group(function () {
        Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export', [\App\Http\Controllers\ReportController::class, 'export'])->name('reports.export');
        
        Route::middleware(['role:ba'])->group(function () {
            Route::get('/reports/create', [\App\Http\Controllers\ReportController::class, 'create'])->name('reports.create');
            Route::post('/reports', [\App\Http\Controllers\ReportController::class, 'store'])->name('reports.store');
            Route::get('/reports/{report}/edit', [\App\Http\Controllers\ReportController::class, 'edit'])->name('reports.edit');
            Route::patch('/reports/{report}', [\App\Http\Controllers\ReportController::class, 'update'])->name('reports.update');
            Route::delete('/reports/{report}', [\App\Http\Controllers\ReportController::class, 'destroy'])->name('reports.destroy');
        });

        // Check-in & Check-out hanya untuk role BA
        Route::middleware(['role:ba'])->group(function () {
            Route::get('/attendance/create', [\App\Http\Controllers\AttendanceController::class, 'create'])->name('attendance.create');
            Route::post('/attendance', [\App\Http\Controllers\AttendanceController::class, 'store'])->name('attendance.store');
        });

        // Attendance Routes
        Route::get('/attendance', [\App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/attendance/{attendance}', [\App\Http\Controllers\AttendanceController::class, 'show'])->name('attendance.show');

        // Attendance Request Routes
        Route::get('/attendance-request', [\App\Http\Controllers\AttendanceRequestController::class, 'index'])->name('attendance.request.index');
        Route::get('/attendance-request/create', [\App\Http\Controllers\AttendanceRequestController::class, 'create'])->name('attendance.request.create');
        Route::post('/attendance-request', [\App\Http\Controllers\AttendanceRequestController::class, 'store'])->name('attendance.request.store');
    });

    Route::get('/reports/{report}', [\App\Http\Controllers\ReportController::class, 'show'])->name('reports.show');

    // API helpers for dropdowns (Shared for BA and Admin)
    Route::get('/api/provinces', function () {
        return \App\Models\Province::orderBy('name')->get();
    });

    Route::get('/api/cities/{province}', function (\App\Models\Province $province) {
        return $province->cities()->orderBy('name')->get();
    });

    Route::get('/api/users/{user}/data', function (\App\Models\User $user) {
        return [
            'outlets' => $user->outlets()->orderBy('name')->get(),
            'distributor' => $user->distributor
        ];
    });

    Route::get('/api/distributors/{distributor}/bas', function (\App\Models\Distributor $distributor) {
        return \App\Models\User::where('role', 'ba')->where('distributor_id', $distributor->id)->orderBy('name')->get();
    });

    Route::get('/api/bas/all', function () {
        return \App\Models\User::where('role', 'ba')->orderBy('name')->get();
    });

    Route::get('/api/products/{brand}', function (\App\Models\Brand $brand) {
        return $brand->products()->orderBy('name')->get();
    });

    // Admin, RBS, KAM Specific Routes
    Route::middleware(['role:admin,rbs,kam'])->prefix('admin')->name('admin.')->group(function () {
        // Attendance Logs
        Route::get('/attendance', [\App\Http\Controllers\AttendanceController::class, 'adminIndex'])->name('attendance.index');
        Route::get('/attendance/export', [\App\Http\Controllers\AttendanceController::class, 'adminExport'])->name('attendance.export');
        Route::get('/attendance/{attendance}', [\App\Http\Controllers\AttendanceController::class, 'adminShow'])->name('attendance.show');
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
        Route::resource('regions', \App\Http\Controllers\Master\RegionController::class);
        Route::resource('areas', \App\Http\Controllers\Master\AreaController::class);
        Route::resource('outlets', \App\Http\Controllers\Master\OutletController::class);
        // User Management
        Route::patch('users/{user}/toggle', [\App\Http\Controllers\Admin\UserController::class, 'toggle'])->name('users.toggle');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

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
