<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Login routes
Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function () {

    Route::middleware(['role:admin'])->group(function () {
        // Employee routes
        Route::group(['prefix' => 'employee'], function () {
            Route::get('/', [EmployeeController::class, 'index'])->name('employee');
            Route::get('/form', [EmployeeController::class, 'form'])->name('employee.form.add');
            Route::get('/form/{employee}', [EmployeeController::class, 'form'])->name('employee.form.edit');
            Route::post('/form', [EmployeeController::class, 'store'])->name('employee.form.add');
            Route::patch('/form/{employee}', [EmployeeController::class, 'update'])->name('employee.form.edit');
            Route::patch('/status/{employee}', [EmployeeController::class, 'statusToggle'])->name('employee.status.toggle');
            Route::get('/{employee}', [EmployeeController::class, 'show'])->name('employee.detail');
        });

        // Schedule routes
        Route::group(['prefix' => 'schedule'], function () {
            Route::get('/', [ScheduleController::class, 'index'])->name('schedule');
            Route::post('/', [ScheduleController::class, 'store'])->name('schedule.store');
            Route::get('/form', [ScheduleController::class, 'form'])->name('schedule.form.add');
            Route::get('/form/{schedule}', [ScheduleController::class, 'form'])->name('schedule.form.edit');
            Route::patch('/{schedule}', [ScheduleController::class, 'update'])->name('schedule.update');
            Route::delete('/{schedule}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');
            Route::get('/{schedule}', [ScheduleController::class, 'detail'])->name('schedule.detail');
        });

        // Receipt routes
        Route::group(['prefix' => 'receipt'], function () {
            Route::get('/', [ReceiptController::class, 'dashboard'])->name('receipt');
            Route::get('/add', [ReceiptController::class, 'add'])->name('receipt.add');
            Route::post('/store', [ReceiptController::class, 'store'])->name('receipt.store');
            Route::get('/history', [ReceiptController::class, 'history'])->name('receipt.history');
            Route::get('/{receipt}', [ReceiptController::class, 'showDashboard'])->name('receipt.show');
            Route::delete('/{receipt}', [ReceiptController::class, 'destroy'])->name('receipt.destroy');
        });
    });

    // Report routes
    Route::middleware(['role:admin|manager'])->group(function () {
        // Dashboard routes
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::group(['prefix' => 'report'], function () {
            Route::get('/attendance', [AttendanceController::class, 'report'])->name('report.attendance');
            Route::get('/attendance/export', [AttendanceController::class, 'export'])->name('report.attendance.export');
        });
    });

    // Search routes
    Route::middleware(['role:admin|manager'])->group(function () {
        Route::get('/search', [SearchController::class, 'search'])->name('search');
    });

    // Notification routes
    Route::middleware(['role:admin|manager'])->group(function () {
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
        Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    });

    // Mobile routes
    Route::group(['prefix' => 'mobile', 'middleware' => ['role:driver']], function () {
        Route::group(['prefix' => 'attendance'], function () {
            Route::get('/', [AttendanceController::class, 'driverHome'])->name('mobile.attendance');
            Route::get('/schedules', [ScheduleController::class, 'getDriverSchedules'])->name('mobile.attendance.schedule');
            Route::get('/{type}/{schedule}', [AttendanceController::class, 'form'])->name('mobile.attendance.form');
            Route::post('/{type}/{schedule}', [AttendanceController::class, 'store'])->name('mobile.attendance.store');
            Route::get('/history', [AttendanceController::class, 'getDriverAttendance'])->name('mobile.attendance.history');
        });

        Route::group(['prefix' => 'receipt'], function () {
            Route::get('/', [ReceiptController::class, 'index'])->name('mobile.receipt');
            Route::get('/add', [ReceiptController::class, 'add'])->name('mobile.receipt.add');
            Route::post('/store', [ReceiptController::class, 'store'])->name('mobile.receipt.store');
            Route::get('/history', [ReceiptController::class, 'history'])->name('mobile.receipt.history');
            Route::get('/{receipt}', [ReceiptController::class, 'show'])->name('mobile.receipt.show');
            Route::delete('/{receipt}', [ReceiptController::class, 'destroy'])->name('mobile.receipt.destroy');
        });

        Route::get('/profile', function () {
            return view('mobile.profile.index');
        })->name('mobile.profile');

        Route::get('/profile/edit', function () {
            return view('mobile.profile.edit');
        })->name('mobile.profile.edit');

        Route::get('/profile/edit-password', function () {
            return view('mobile.profile.edit-password');
        })->name('mobile.profile.edit-password');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/dashboard/profile', [ProfileController::class, 'dashboard'])->name('dashboard.profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
