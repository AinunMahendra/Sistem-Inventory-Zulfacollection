<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ReceivingController;
use App\Http\Controllers\DispatchingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArchiveController;


// Route Login
Route::get('/', function () {return redirect('sign-in');})->middleware('guest');
Route::get('/', function () {return redirect('dashboard');})->middleware('auth');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('sign-up', [RegisterController::class, 'store'])->middleware('guest');
Route::get('sign-in', [SessionsController::class, 'create'])->middleware('guest')->name('login');
Route::post('sign-in', [SessionsController::class, 'store'])->middleware('guest');
Route::post('verify', [SessionsController::class, 'show'])->middleware('guest');
Route::post('reset-password', [SessionsController::class, 'update'])->middleware('guest')->name('password.update');
Route::get('verify', function () {
	return view('sessions.password.verify');
})->middleware('guest')->name('verify');
Route::get('/reset-password/{token}', function ($token) {
	return view('sessions.password.reset', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('profile', [ProfileController::class, 'create'])->middleware('auth')->name('profile');
Route::post('user-profile', [ProfileController::class, 'update'])->middleware('auth');


//Route Akun / Management User
Route::get('user-management', [UserController::class, 'index'])->middleware('admin')->name('user-management');
Route::get('new-user', [UserController::class, 'create'])->middleware('auth')->name('new-user');
Route::post('new-user', [UserController::class, 'store'])->middleware('auth');
Route::get('edit-user/{id}', [UserController::class, 'edit'])->middleware('auth')->name('edit-user');
Route::put('user/{id}', [UserController::class, 'update'])->middleware('auth')->name('edit.user');
Route::delete('user/{user:id}/hapus', [UserController::class, 'destroy'])->middleware('auth')->name('delete-user');


// Route Barang
Route::controller(ItemController::class)->group(function () {
	Route::get('barang', 'index')->middleware('auth')->name('barang');
	Route::post('barang', 'store')->middleware('auth');
    Route::get('/search/items', 'search')->name('search.items');
	Route::put('barang/{item:id}', 'archive')->middleware('auth')->name('archive.item');
    Route::get('barang/lot4lot/{item:nama}', 'lotforlot')->middleware('auth')->name('l4l');
    Route::post('barang/lot4lot', 'lotforlotStore')->middleware('auth')->name('l4l.input');
    Route::post('barang/forecasting', 'forecasting')->middleware('auth')->name('forecasting');
});

// Route Bahan Baku/ Material
Route::controller(MaterialController::class)->group(function () {
	Route::get('material', 'index')->middleware('auth')->name('material');
    Route::get('/search/material', 'search')->name('search.material');
	Route::post('material', 'store')->middleware('auth');
    Route::put('material/{item:id}', 'archive')->middleware('auth')->name('archive.material');
});

// Route Barang Masuk
Route::controller(ReceivingController::class)->group(function () {
	Route::get('receiving', 'index')->middleware('auth')->name('receiving');
	Route::get('receiving/new-receiving', 'create')->middleware('auth')->name('new-receiving');
    Route::get('pilih-barang', 'pilihbarang')->middleware('auth')->name('pilih.barang');
    Route::get('pilih-sku', 'pilihsku')->middleware('auth')->name('pilih.sku');
    Route::post('receiving', 'store')->middleware('auth')->name('input.receiving');
    Route::get('receiving/edit-receiving/{id}', 'edit')->middleware('auth')->name('edit.receiving');
    Route::put('receiving/{id}', 'update')->middleware('auth')->name('update.receiving');
	Route::delete('receiving/{receiving:id}/hapus', 'destroy')->middleware('auth')->name('delete.receiving');
});

// Route Barang Keluar
Route::controller(DispatchingController::class)->group(function () {
	Route::get('dispatching', 'index')->middleware('auth')->name('dispatching');
	Route::get('dispatching/new-dispatching', 'create')->middleware('auth')->name('new-dispatching');
    Route::post('dispatching', 'store')->middleware('auth')->name('input.dispatching');
    Route::get('dispatching/edit-dispatching/{id}', 'edit')->middleware('auth')->name('edit.dispatching');
    Route::put('dispatching/{id}', 'update')->middleware('auth')->name('update.dispatching');
	Route::delete('dispatching/{dispatching:id}/hapus', 'destroy')->middleware('auth')->name('delete.dispatching');
});

Route::controller(ArchiveController::class)->group(function () {
	Route::get('archive', 'index')->middleware('auth')->name('archive');
	Route::put('unarchive/{item:id}', 'unarchive')->middleware('auth')->name('unarchive.item');
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('billing', function () {
		return view('pages.billing');
	})->name('billing');
	Route::get('rtl', function () {
		return view('pages.rtl');
	})->name('rtl');
	Route::get('virtual-reality', function () {
		return view('pages.virtual-reality');
	})->name('virtual-reality');
	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');
	Route::get('static-sign-in', function () {
		return view('pages.static-sign-in');
	})->name('static-sign-in');
	Route::get('static-sign-up', function () {
		return view('pages.static-sign-up');
	})->name('static-sign-up');
	// Route::get('user-management', function () {
	// 	return view('pages.laravel-examples.user-management');
	// })->name('user-management');
	Route::get('user-profile', function () {
		return view('pages.laravel-examples.user-profile');
	})->name('user-profile');
});
