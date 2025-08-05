<?php

use App\Http\Controllers\ProfileController;
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
            Route::get('/', [UserController::class, 'getEmployee'])->name('employee');
            Route::get('/form', [UserController::class, 'employeeForm'])->name('employee.form.add');
            Route::get('/form/{employee}', [UserController::class, 'employeeForm'])->name('employee.form.edit');
            Route::post('/form', [UserController::class, 'storeEmployee'])->name('employee.form.add');
            Route::patch('/form/{employee}', [UserController::class, 'updateEmployee'])->name('employee.form.edit');
            Route::patch('/status/{employee}', [UserController::class, 'employeeStatusToggle'])->name('employee.status.toggle');
        });

        // Schedule routes
        Route::group(['prefix' => 'schedule'], function () {
            Route::get('/', function () {
                return view('dashboard.schedule.index');
            })->name('schedule');

            Route::get('/form', function () {
                return view('dashboard.schedule.form');
            })->name('schedule.form.add');

            Route::get('/form/{id}', function ($id) {
                return view('dashboard.schedule.form', ['id' => $id]);
            })->name('schedule.form.edit');
        });

        // Receipt routes
        Route::group(['prefix' => 'receipt'], function () {
            Route::get('/', function () {
                return view('dashboard.receipt.index');
            })->name('receipt');
        });
    });

    // Report routes
    Route::group(['prefix' => 'report', 'middleware' => ['role:admin|manager']], function () {
        // Dashboard routes
        Route::get('/dashboard', function () {
            return view('dashboard.index');
        })->name('dashboard');

        Route::get('/attendance', function () {
            return view('dashboard.report.attendance');
        })->name('report.attendance');

        Route::get('/attendance/export', function () {
            return view('dashboard.report.attendance.export');
        })->name('report.attendance.export');
    });

    // Mobile routes
    Route::group(['prefix' => 'mobile', 'middleware' => ['role:driver']], function () {
        Route::group(['prefix' => 'attendance'], function () {
            Route::get('/', function () {
                return view('mobile.attendance.index');
            })->name('mobile.attendance');

            Route::get('/start', function () {
                return view('mobile.attendance.start');
            })->name('mobile.attendance.start');

            Route::get('/end', function () {
                return view('mobile.attendance.end');
            })->name('mobile.attendance.end');

            Route::get('/history', function () {
                return view('mobile.attendance.history');
            })->name('mobile.attendance.history');
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
