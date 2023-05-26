<?php

use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\TagController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/setlanguage/{ln}', function ($ln) {

    if (in_array($ln, config('app.locales'))) {
        session(['locale' => $ln]);
    }
    return redirect()->back();

});


Route::get('/admin', [DashboardController::class,'overview']);

Route::get('/admin/tags', [TagController::class,'index']);
Route::get('/admin/tags/create', [TagController::class,'create']);
