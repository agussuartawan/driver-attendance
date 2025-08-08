<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ScheduleController;
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
            Route::get('/', [ReceiptController::class, 'index'])->name('receipt');
        });
    });

    // Report routes
    Route::group(['prefix' => 'report', 'middleware' => ['role:admin|manager']], function () {
        // Dashboard routes
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/attendance', [AttendanceController::class, 'report'])->name('report.attendance');
        Route::get('/attendance/export', [AttendanceController::class, 'export'])->name('report.attendance.export');
    });

    // Mobile routes
    Route::group(['prefix' => 'mobile', 'middleware' => ['role:driver']], function () {
        Route::group(['prefix' => 'attendance'], function () {
            Route::get('/', function () {
                return view('mobile.attendance.index');
            })->name('mobile.attendance');

            Route::get('/schedules', [ScheduleController::class, 'getDriverSchedules'])->name('mobile.attendance.schedule');
            Route::get('/{type}/{schedule}', [AttendanceController::class, 'form'])->name('mobile.attendance.form');
            Route::post('/{type}/{schedule}', [AttendanceController::class, 'create'])->name('mobile.attendance.create');

            Route::get('/history', [AttendanceController::class, 'getDriverAttendance'])->name('mobile.attendance.history');
        });

        Route::group(['prefix' => 'receipt'], function () {
            Route::get('/', function () {
                return view('mobile.receipt.index');
            })->name('mobile.receipt');

            Route::get('/add', function () {
                return view('mobile.receipt.add');
            })->name('mobile.receipt.add');

            Route::get('/history', function () {
                return view('mobile.receipt.history');
            })->name('mobile.receipt.history');
        });

        Route::get('/report', function () {
            return view('mobile.report');
        })->name('mobile.report');

        Route::get('/profile', function () {
            return view('mobile.profile.index');
        })->name('mobile.profile');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
