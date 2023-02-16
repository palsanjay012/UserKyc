<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);
// ************************ Start Custome Registration **********************  
// Route::get('login', [AuthController::class, 'index'])->name('login');
// Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');

Route::get('registration', [AuthController::class, 'registration'])->name('register.mobile');
Route::post('registration', [AuthController::class, 'postRegistration'])->name('register.mobile');

Route::get('registration/otpverification', [AuthController::class, 'otpverification'])->name('register.otpverification');
Route::post('registration/otpverification', [AuthController::class, 'postOtpverification'])->name('register.otpverification');




// Route::get('dashboard', [AuthController::class, 'dashboard']); 
// Route::get('logout', [AuthController::class, 'logout'])->name('logout');
// ************************ End Custome Login/Registration **********************

// Users Routes


Route::get('/email/update', [EmailVerificationController::class, 'update'])->name('verification.update');
Route::post('/email/update', [EmailVerificationController::class, 'postupdate'])->name('verification.update');
Route::get('/email/verify', [EmailVerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    
   $output = $request->fulfill();
    return redirect('/dashboard');
})->name('verification.verify')->middleware(['signed']);
Route::post('/email/resend', [EmailVerificationController::class, 'resend'])->name('verification.resend');

Route::middleware(['auth', 'user-access:0'])->group(function () {


    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
});

// Manager Routes

Route::middleware(['auth', 'user-access:2'])->group(function () {
  
    Route::get('/manager/dashboard', [HomeController::class, 'managerDashboard'])->name('manager.dashboard');
});  

// Super Admin Routes

Route::middleware(['auth', 'user-access:1'])->group(function () {
    Route::get('/super-admin/dashboard', [HomeController::class, 'superAdminDashboard'])->name('super.admin.dashboard');
});


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
