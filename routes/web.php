<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduanController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $stats = [
        'total' => \App\Models\Pengaduan::count(),
        'selesai' => \App\Models\Pengaduan::where('status', 'selesai')->count(),
        'diproses' => \App\Models\Pengaduan::where('status', 'diproses')->count(),
    ];
    $pengaduans = \App\Models\Pengaduan::whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->select('judul', 'latitude', 'longitude', 'status')
        ->latest()
        ->limit(100)
        ->get();
    return view('welcome', compact('stats', 'pengaduans'));
});

// Dashboard - redirect berdasarkan role
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('pengaduan.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes untuk masyarakat (auth and verified required)
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class , 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class , 'destroy'])->name('profile.destroy');

    // Pengaduan CRUD
    Route::resource('pengaduan', PengaduanController::class);
});

use App\Http\Middleware\RoleMiddleware;

// Routes untuk admin
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class , 'index'])->name('dashboard');
    Route::get('/dashboard/export-pdf', [DashboardController::class , 'exportPdf'])->name('dashboard.exportPdf');
    Route::get('/pengaduan', [AdminPengaduanController::class , 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/{pengaduan}', [AdminPengaduanController::class , 'show'])->name('pengaduan.show');
    Route::patch('/pengaduan/{pengaduan}/status', [AdminPengaduanController::class , 'updateStatus'])->name('pengaduan.updateStatus');
    Route::resource('kategori', KategoriController::class)->except(['show']);
});

require __DIR__ . '/auth.php';
