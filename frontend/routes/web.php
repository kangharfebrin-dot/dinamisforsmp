<?php

use Illuminate\Support\Facades\Route;

// Public Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\ContactController;

// Admin Controllers
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\AgendaController as AdminAgendaController;
use App\Http\Controllers\Admin\TeacherController as AdminTeacherController;
use App\Http\Controllers\Admin\AchievementController as AdminAchievementController;
use App\Http\Controllers\Admin\ExtracurricularController as AdminExtracurricularController;
use App\Http\Controllers\Admin\FacilityController as AdminFacilityController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\DocumentController as AdminDocumentController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\AccountController as AdminAccountController;

/*
|--------------------------------------------------------------------------
| Public Routes (Portal Informasi Resmi SMP Negeri 2 Juwangi)
|--------------------------------------------------------------------------
*/
Route::get('/', HomeController::class)->name('home');

Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/', [ProfilController::class, 'index'])->name('index');
    Route::get('/visi-misi', [ProfilController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/sambutan-kepala-sekolah', [ProfilController::class, 'sambutan'])->name('sambutan');
    Route::get('/sambutan', [ProfilController::class, 'sambutan']);
});

Route::get('/berita', [NewsController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('berita.show');

Route::get('/pengumuman', [AnnouncementController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/{id}', [AnnouncementController::class, 'show'])->name('pengumuman.show');

Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
Route::get('/agenda/{id}', [AgendaController::class, 'show'])->name('agenda.show');

Route::get('/guru-staf', [TeacherController::class, 'index'])->name('guru.index');
Route::get('/prestasi', [AchievementController::class, 'index'])->name('prestasi.index');
Route::get('/fasilitas', [FacilityController::class, 'index'])->name('fasilitas.index');
Route::get('/galeri', [GalleryController::class, 'index'])->name('galeri.index');

Route::get('/unduhan', [DocumentController::class, 'index'])->name('unduhan.index');
Route::get('/unduhan/{id}/download', [DocumentController::class, 'download'])->name('unduhan.download');

Route::get('/ppdb', [PpdbController::class, 'index'])->name('ppdb');

Route::get('/kontak', [ContactController::class, 'index'])->name('kontak');
Route::post('/kontak', [ContactController::class, 'submit'])->name('kontak.submit');

/*
|--------------------------------------------------------------------------
| Admin Panel Routes (Single Role: Admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // 1. Berita & Artikel
        Route::prefix('berita')->name('berita.')->group(function () {
            Route::get('/', [AdminNewsController::class, 'index'])->name('index');
            Route::get('/tambah', [AdminNewsController::class, 'create'])->name('create');
            Route::post('/', [AdminNewsController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminNewsController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminNewsController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminNewsController::class, 'destroy'])->name('destroy');
        });

        // 2. Kategori Berita
        Route::prefix('kategori')->name('kategori.')->group(function () {
            Route::get('/', [AdminCategoryController::class, 'index'])->name('index');
            Route::post('/', [AdminCategoryController::class, 'store'])->name('store');
            Route::put('/{id}', [AdminCategoryController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminCategoryController::class, 'destroy'])->name('destroy');
        });

        // 3. Pengumuman
        Route::prefix('pengumuman')->name('pengumuman.')->group(function () {
            Route::get('/', [AdminAnnouncementController::class, 'index'])->name('index');
            Route::get('/tambah', [AdminAnnouncementController::class, 'create'])->name('create');
            Route::post('/', [AdminAnnouncementController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminAnnouncementController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminAnnouncementController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminAnnouncementController::class, 'destroy'])->name('destroy');
        });

        // 4. Agenda
        Route::prefix('agenda')->name('agenda.')->group(function () {
            Route::get('/', [AdminAgendaController::class, 'index'])->name('index');
            Route::get('/tambah', [AdminAgendaController::class, 'create'])->name('create');
            Route::post('/', [AdminAgendaController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminAgendaController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminAgendaController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminAgendaController::class, 'destroy'])->name('destroy');
        });

        // 5. Guru & Tenaga Kependidikan
        Route::prefix('guru')->name('guru.')->group(function () {
            Route::get('/', [AdminTeacherController::class, 'index'])->name('index');
            Route::get('/tambah', [AdminTeacherController::class, 'create'])->name('create');
            Route::post('/', [AdminTeacherController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminTeacherController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminTeacherController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminTeacherController::class, 'destroy'])->name('destroy');
        });

        // 6. Prestasi
        Route::prefix('prestasi')->name('prestasi.')->group(function () {
            Route::get('/', [AdminAchievementController::class, 'index'])->name('index');
            Route::get('/tambah', [AdminAchievementController::class, 'create'])->name('create');
            Route::post('/', [AdminAchievementController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminAchievementController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminAchievementController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminAchievementController::class, 'destroy'])->name('destroy');
        });

        // 7. Ekstrakurikuler
        Route::prefix('ekstrakurikuler')->name('ekstrakurikuler.')->group(function () {
            Route::get('/', [AdminExtracurricularController::class, 'index'])->name('index');
            Route::get('/tambah', [AdminExtracurricularController::class, 'create'])->name('create');
            Route::post('/', [AdminExtracurricularController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminExtracurricularController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminExtracurricularController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminExtracurricularController::class, 'destroy'])->name('destroy');
        });

        // 8. Fasilitas
        Route::prefix('fasilitas')->name('fasilitas.')->group(function () {
            Route::get('/', [AdminFacilityController::class, 'index'])->name('index');
            Route::get('/tambah', [AdminFacilityController::class, 'create'])->name('create');
            Route::post('/', [AdminFacilityController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminFacilityController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminFacilityController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminFacilityController::class, 'destroy'])->name('destroy');
        });

        // 9. Album & Galeri Foto
        Route::prefix('galeri')->name('galeri.')->group(function () {
            Route::get('/', [AdminGalleryController::class, 'index'])->name('index');
            Route::post('/album', [AdminGalleryController::class, 'storeAlbum'])->name('album.store');
            Route::put('/album/{id}', [AdminGalleryController::class, 'updateAlbum'])->name('album.update');
            Route::delete('/album/{id}', [AdminGalleryController::class, 'destroyAlbum'])->name('album.destroy');
            Route::post('/foto', [AdminGalleryController::class, 'storePhoto'])->name('photo.store');
            Route::delete('/foto/{id}', [AdminGalleryController::class, 'destroyPhoto'])->name('photo.destroy');
        });

        // 10. Dokumen Unduhan
        Route::prefix('dokumen')->name('dokumen.')->group(function () {
            Route::get('/', [AdminDocumentController::class, 'index'])->name('index');
            Route::post('/', [AdminDocumentController::class, 'store'])->name('store');
            Route::delete('/{id}', [AdminDocumentController::class, 'destroy'])->name('destroy');
        });
        // Alias untuk 'unduhan'
        Route::get('/unduhan', fn() => redirect()->route('admin.dokumen.index'))->name('unduhan.index');

        // 11. Halaman Dinamis & PPDB
        Route::prefix('halaman')->name('halaman.')->group(function () {
            Route::get('/', [AdminPageController::class, 'index'])->name('index');
            Route::get('/tambah', [AdminPageController::class, 'create'])->name('create');
            Route::post('/', [AdminPageController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminPageController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminPageController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminPageController::class, 'destroy'])->name('destroy');
        });

        // 12. Identitas & Profil Sekolah
        Route::prefix('profil')->name('profil.')->group(function () {
            Route::get('/', [AdminProfileController::class, 'edit'])->name('edit');
            Route::put('/', [AdminProfileController::class, 'update'])->name('update');
        });

        // 13. Akun Pengelola Admin
        Route::prefix('akun')->name('akun.')->group(function () {
            Route::get('/', [AdminAccountController::class, 'index'])->name('index');
            Route::put('/profil', [AdminAccountController::class, 'updateProfile'])->name('profile.update');
            Route::put('/sandi', [AdminAccountController::class, 'changePassword'])->name('password.update');
        });
    });
});
