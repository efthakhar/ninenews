<?php

use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Frontend\TagController as FrontendTagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| FORNTEND ROUTES
|--------------------------------------------------------------------------
*/

// Frontend Routes without any language prefix
frontendroutes();
// Frontend Routes with language prefix // don't include default locale in lang array
Route::group([ 'prefix' => '/{lang}', 'where' => ['lang' => 'bn|ar|hn|au'] ],function (){ frontendroutes(); });



function frontendroutes(){

	// Home Route
	Route::get('/', function () {
			 return redirect('/admin'); 
	} );
	// Fornt End Post Route:
	Route::get('/news/{post_id}/{post_slug}', function ($post_id) {  });
	// Fornt End Post-Category Route:
	Route::get('/category/{category_slug}', function ($category_slug) {  });
	// Fornt End Post-Tag Route:
	Route::get('/tag/{tag_slug}', function ($tag_slug) {  });
	Route::get('/tags', [FrontendTagController::class,'index']);

}


// Authentication Routes
Route::get('/register', [AuthController::class, 'showUserRegistrationPage'])->name('showUserRegistrationPage');
Route::post('/register', [AuthController::class, 'registerUser'])->name('registerUser');
Route::get('/login', [AuthController::class, 'showloginPage'])->name('showloginPage');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout',[AuthController::class ,'logout'])->name('logout'); 


// Admin Routes:
Route::middleware(['auth','checkAndSetLanguage'])->group(function(){


	// Language switcher route
	Route::get('/admin/setlanguage/{ln}', function ($ln) {
		if (in_array($ln, config('app.locales'))) {	session(['locale' => $ln]);	}
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

	// Media
	Route::get('/admin/media', [MediaController::class, 'index'])->name('admin.media.index');
	// Route::get('/admin/media/create', [MediaController::class, 'create'])->name('admin.media.create');
	// Route::get('/admin/media/{id}', [MediaController::class, 'show'])->name('admin.media.single');
	Route::post('/admin/media', [MediaController::class, 'store'])->name('admin.media.store');
	// Route::get('/admin/media/{id}/edit', [MediaController::class, 'edit'])->name('admin.media.edit');
	// Route::put('/admin/media/{id}', [MediaController::class, 'update'])->name('admin.media.update');
	Route::delete('/admin/media/{id}', [MediaController::class, 'delete'])->name('admin.media.delete');

});



