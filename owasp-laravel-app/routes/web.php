<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CryptographicFailuresTestController;
use App\Http\Controllers\VulnerableComponentsController;
use App\Http\Controllers\AuthFailuresController;
use App\Http\Controllers\SoftwareIntegrityController;
use App\Http\Controllers\LoggingController;
use App\Http\Controllers\SSRFController;

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


Route::middleware(['auth'])->group(function () {
    // ... existing routes ...

    // A06:2021 - Vulnerable and Outdated Components
    Route::get('/vulnerable-components', [VulnerableComponentsController::class, 'showOutdatedDependencies']);
    Route::post('/vulnerable-components/parse-xml', [VulnerableComponentsController::class, 'exploitVulnerability']);
    Route::get('/vulnerable-components/check-updates', [VulnerableComponentsController::class, 'checkUpdates']);
});


// A07:2021 - Identification and Authentication Failures
Route::get('/a07-auth-failures', function () {
    return view('auth_failures');
})->name('a07.auth_failures');

Route::post('/a07-vulnerable-login', [AuthFailuresController::class, 'vulnerableLogin'])
    ->name('a07.vulnerable_login');

Route::post('/a07-secure-auth-login', [AuthFailuresController::class, 'secureLogin'])
    ->name('a07.secure_auth_login');

Route::post('/a07-weak-password-register', [AuthFailuresController::class, 'weakPasswordRegister'])
    ->name('a07.weak_password_register');

Route::post('/a07-secure-password-register', [AuthFailuresController::class, 'securePasswordRegister'])
    ->name('a07.secure_password_register');

// A08: Software and Data Integrity Failures
Route::prefix('software-integrity')->group(function () {
    Route::post('/insecure-update', [\App\Http\Controllers\SoftwareIntegrityController::class, 'insecureUpdate']);
    Route::post('/secure-update', [\App\Http\Controllers\SoftwareIntegrityController::class, 'secureUpdate']);
    Route::post('/process-serialized', [\App\Http\Controllers\SoftwareIntegrityController::class, 'processSerializedData']);
    Route::post('/process-json', [\App\Http\Controllers\SoftwareIntegrityController::class, 'processJsonData']);
});

Route::get('/software-integrity', function () {
    return view('software_integrity_demo');
});

// A09: Security Logging and Monitoring Failures
Route::middleware(['auth'])->group(function () {
    Route::get('/logging-demo', function () {
        return view('logging_demo');
    });

    Route::post('/insecure-login', [LoggingController::class, 'insecureLogin']);
    Route::post('/secure-login', [LoggingController::class, 'secureLogin']);
    Route::post('/insecure-admin-action', [LoggingController::class, 'insecureAdminAction']);
    Route::post('/secure-admin-action', [LoggingController::class, 'secureAdminAction']);
    Route::post('/log-injection', [LoggingController::class, 'logInjection']);
    Route::post('/safe-logging', [LoggingController::class, 'safeLogging']);
});

// A10:2021 – Server-Side Request Forgery (SSRF)
Route::middleware(['auth'])->group(function () {
    // SSRF Demo
    Route::get('/ssrf-demo', [SsrfController::class, 'demo'])->name('ssrf.demo');
    Route::post('/ssrf/fetch', [SsrfController::class, 'fetchUrl']);
    Route::post('/ssrf/fetch-secure', [SsrfController::class, 'fetchUrlSecure']);
});

require __DIR__.'/auth.php';
