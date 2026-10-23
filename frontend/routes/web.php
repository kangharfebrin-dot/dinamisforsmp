<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

// Public Website Routes
Route::get('/', HomeController::class)->name('home');

Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/', [ProfilController::class, 'index'])->name('index');
    Route::get('/visi-misi', [ProfilController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/sambutan-kepala-sekolah', [ProfilController::class, 'sambutan'])->name('sambutan');
});

Route::get('/berita', [NewsController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('berita.show');

Route::get('/guru-staf', [TeacherController::class, 'index'])->name('guru.index');
Route::get('/ppdb', [PpdbController::class, 'index'])->name('ppdb');

Route::get('/kontak', [ContactController::class, 'index'])->name('kontak');
Route::post('/kontak', [ContactController::class, 'submit'])->name('kontak.submit');

// Admin Panel Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    });
});
