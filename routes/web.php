<?php

use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return redirect('/admin');
} );

Route::get('/setlanguage/{ln}', function ($ln) {
    
	if (in_array($ln, config('app.locales'))) {
		session(['locale' => $ln]);
	}

	return redirect()->back();
});

// Dashboard
Route::get('/admin', [DashboardController::class, 'overview']);

// Tag
Route::get('/admin/tags', [TagController::class, 'index'])->name('admin.tag.index');
Route::get('/admin/tags/create', [TagController::class, 'create'])->name('admin.tag.create');
Route::get('/admin/tags/{id}', [TagController::class, 'show'])->name('admin.tag.single');
Route::post('/admin/tags', [TagController::class, 'store'])->name('admin.tag.store');
Route::get('/admin/tags/{id}/edit', [TagController::class, 'edit'])->name('admin.tag.edit');
Route::put('/admin/tags/{id}', [TagController::class, 'update'])->name('admin.tag.update');
Route::delete('/admin/tags/{id}', [TagController::class, 'delete'])->name('admin.tag.delete');
