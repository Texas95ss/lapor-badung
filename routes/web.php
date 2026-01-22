<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('welcome');
});

// Arahkan dashboard ke ReportController function index
Route::get('/dashboard', [ReportController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/', [FrontController::class, 'index'])->name('home');
// Halaman Detail Laporan (Bisa diakses publik)
Route::get('/laporan/{report}', [FrontController::class, 'show'])->name('reports.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Kirim Komentar25
    Route::post('/komentar', [CommentController::class, 'store'])->name('comments.store');
});

// Grouping: Hanya user yang SUDAH LOGIN yang bisa akses jalur ini
Route::middleware(['auth'])->group(function () {
    // Menampilkan Form
    Route::get('/lapor/buat', [ReportController::class, 'create'])->name('reports.create');
    
    // Mengirim Data (Tombol Submit)
    Route::post('/lapor/simpan', [ReportController::class, 'store'])->name('reports.store');
});

// Group Route khusus Admin
Route::middleware(['auth'])->group(function () {
    // Halaman Utama Admin
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Proses Update Status
    Route::patch('/admin/laporan/{report}', [AdminController::class, 'update'])->name('admin.update');
});

require __DIR__.'/auth.php';
