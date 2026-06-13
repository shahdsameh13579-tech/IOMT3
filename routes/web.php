<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogUploadController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes (Analyst & Admin)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/upload', [LogUploadController::class, 'upload'])->name('log.upload');
    
    Route::get('/analysis/{analysis}', [AnalysisController::class, 'show'])->name('analysis.show');
    Route::get('/analysis/{analysis}/pdf', [ReportController::class, 'download'])->name('analysis.pdf');
    
    // Admin Protected Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
        Route::patch('/admin/users/{user}', [AdminController::class, 'updateRole'])->name('admin.users.update');
    });
});
