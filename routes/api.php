<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiControllers\UsersController;
use App\Http\Controllers\ApiControllers\CompanyController;
use App\Http\Controllers\ApiControllers\NurseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('Register',[UsersController::class,'Register']);
Route::post('login',[UsersController::class,'login']);
Route::post('ForgotPassword',[UsersController::class,'forgot_password']);
Route::post('Otpverification',[UsersController::class,'otp_verification']);
Route::post('ResetPassword',[UsersController::class,'reset_password']);

Route::group(['middleware'=>'auth:api'],function(){

    Route::post('AddJobByCompanys',[CompanyController::class,'AddJobByCompanys']);
    Route::post('GetCompanyJobs',[CompanyController::class,'GetCompanyJobs']);
    Route::post('GetCompanyJobDescription',[CompanyController::class,'GetCompanyJobDescription']);
    Route::post('NurseAssignByCompany',[CompanyController::class,'NurseAssignByCompany']);
    Route::post('GetNursesAppliedOnJob',[CompanyController::class,'GetNursesAppliedOnJob']);
    Route::post('UpdatePassword',[UsersController::class,'update_password']);

    Route::get('GetAllJob',[NurseController::class,'GetAllJob']);
    Route::post('ApplyOnJob',[NurseController::class,'ApplyOnJob']);

    Route::post('AddNursePosts',[NurseController::class,'AddNursePosts']);
    Route::post('EditNursePost',[NurseController::class,'EditNursePost']);
    Route::post('DeleteNursePost',[NurseController::class,'DeleteNursePost']);
    Route::post('GetAllNursePost',[NurseController::class,'GetAllNursePost']);
});

