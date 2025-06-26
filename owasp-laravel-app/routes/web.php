<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CryptographicFailuresTestController;

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// A01 - Broken Access Control
Route::get('/admin', function () {
    return view('admin.dashboard');})
    ->middleware(['auth', 'admin'])
    ->name('admin.dashboard');

// A02 - Cryptographic Failures
Route::get('/crypto-demo', [CryptographicFailuresTestController::class, 'showStoredPasswords']);
Route::post('/store-passwords', [CryptographicFailuresTestController::class, 'storePassword']);

// A03 - SQL Injection
Route::get('/search', [HomeController::class, 'searchUsers']);


// A04 - Insecure Design
Route::middleware(['auth'])->group(function () {
    Route::get('/insecure-design', function () {
        return view('insecure-design-demo');
    });

    Route::post('/update-any-profile/{id}', [ProfileController::class, 'insecureUpdate']);
});

// A05:2021-Security Misconfiguration
Route::get('/trigger-error', function () {
    throw new \Exception("🔥 Simulated application failure for A05: Security Misconfiguration demo.");
});
Route::get('/leak-env', function () {
    return [
        'app_env' => config('app.env'),
        'app_debug' => config('app.debug'),
        'db_host' => env('DB_HOST'),
        'db_password' => env('DB_PASSWORD'),
    ];
});
Route::get('/security-misconfig', function () {
    return view('security_misconfig_demo');
});


require __DIR__.'/auth.php';
