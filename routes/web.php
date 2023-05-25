<?php

use App\Http\Controllers\Admin\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/admin', [DashboardController::class,'overview']);
