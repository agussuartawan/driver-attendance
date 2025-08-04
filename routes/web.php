<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function () {
    // Handle login logic here
    return redirect('/dashboard');
})->name('login.post');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['prefix' => 'employee'], function () {
    Route::get('/', function () {
        return view('employee');
    })->name('employee');

    Route::get('/create', function () {
        return view('employee.create');
    })->name('employee.create');
});

// Mobile routes
Route::group(['prefix' => 'mobile'], function () {
    Route::get('/attendance', function () {
        return view('mobile.attendance');
    })->name('mobile.attendance');

    Route::get('/attendance-start', function () {
        return view('mobile.attendance-start');
    })->name('mobile.attendance-start');

    Route::get('/attendance-end', function () {
        return view('mobile.attendance-end');
    })->name('mobile.attendance-end');

    Route::get('/receipt', function () {
        return view('mobile.receipt');
    })->name('mobile.receipt');

    Route::get('/report', function () {
        return view('mobile.report');
    })->name('mobile.report');

    Route::get('/setting', function () {
        return view('mobile.setting');
    })->name('mobile.setting');
});
