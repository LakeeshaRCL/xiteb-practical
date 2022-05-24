<?php

use App\Http\Controllers\PhamacyUserController;
use App\Http\Controllers\PharmacyUserAuthController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\QuotationController;
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


// pharmacy user auth controller routes
Route::get('/pharmacyUserAuth/logout',[PharmacyUserAuthController::class,'logout'])->name('pharmacyUserAuth.logout');

// pharmacy user controller routes
Route::post('/pharmacyUser/validateUser',[PhamacyUserController::class,'validateUser'])->name('pharmacyUser.validate');



// Protected routes -- pharmacy users ==============================================================================
Route::group(['middleware'=>['AuthCheckPharmacyUser']],function(){
    // pharmacy user auth controller routes
    Route::get('/pharmacyUserAuth/login',[PharmacyUserAuthController::class,'login'])->name('pharmacyUserAuth.login');

    // pharmacy user controller routes
    Route::get('/pharmacyUser/userDashboard',[PhamacyUserController::class,'viewDashboard'])->name('pharmacyUser.userDashboard');

    // quotation controller routes
    Route::get('/quotations/getAll',[QuotationController::class,'getAll'])->name('quotations.getAll');
    Route::get('/quotation/create/{presID}',[QuotationController::class,'create'])->name('quotations.create');
    Route::post('/quotations/save',[QuotationController::class,'save'])->name('quotations.save');

    // prescription controller routes
    Route::get('/prescription/getAll',[PrescriptionController::class,'getAll'])->name('prescription.getAll');
    Route::get('/prescription/show/{id}',[PrescriptionController::class,'show'])->name('prescription.show');
});


// Protected routes -- users =====================================================================================
Route::group(['middleware'=>['AuthCheckUser']],function(){

    // user auth controller routes
    Route::get('/userAuth/login',[UserAuthController::class,'login'])->name('userAuth.login');
    Route::get('/userAuth/register',[UserAuthController::class,'register'])->name('userAuth.register');

    // user controller routes
    Route::get('/user/dashboard',[UserController::class,'viewUserDashboard'])->name('user.dashboard');

    // quotation controller routes
    Route::get('/quotations/{userID}',[QuotationController::class,'showQuotations'])->name('quotations.showQuotations');
    Route::put('/quotations/updateFeedback/{quoID}',[QuotationController::class,'updateFeedback'])->name('quotations.updateFeedback');

    // prescription controller routes
    Route::get('/prescription/create/{userID}',[PrescriptionController::class,'create'])->name('prescription.create');
    Route::post('/prescription/save',[PrescriptionController::class,'save'])->name('prescription.save');
});
