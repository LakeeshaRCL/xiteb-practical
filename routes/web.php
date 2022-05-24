<?php

use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

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

// user auth controller routes
Route::get('/user/logout',[UserAuthController::class,'logout'])->name('userAuth.logout');

// user controller routes
Route::post('/user/save',[UserController::class,'save'])->name('user.save');
Route::post('/user/validateUser',[UserController::class,'validateUser'])->name('user.validateUser');

// prescription controller routes
Route::get('/prescription/create/{userID}',[PrescriptionController::class,'create'])->name('prescription.create');
Route::post('/prescription/save',[PrescriptionController::class,'save'])->name('prescription.save');

// Protected routes -- users
Route::group(['middleware'=>['AuthCheckUser']],function(){

    // user auth controller routes
    Route::get('/userAuth/login',[UserAuthController::class,'login'])->name('userAuth.login');
    Route::get('/userAuth/register',[UserAuthController::class,'register'])->name('userAuth.register');

    // user controller routes
    Route::get('/user/dashboard',[UserController::class,'viewUserDashboard']);
     
});
