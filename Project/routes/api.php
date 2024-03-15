<?php

use App\Http\Controllers\Api\Auth\AuthContoller;
use App\Http\Controllers\api\Auth\ResetPasswordController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\ProdcutUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register', [AuthContoller::class, 'register']);
Route::post('login', [AuthContoller::class, 'login']);
Route::post('verifiy-account', [AuthContoller::class, 'verifyCode']);
Route::post('forgot-password', [ResetPasswordController::class, 'forgotPassword']);
Route::post('reset-password/{token}', [ResetPasswordController::class, 'resetPassword']);


// Route::group([
//     'middleware' => ['auth:api']
// ], function () {
//     Route::get('users', [UserController::class, 'showInfo']);
//     Route::put('users', [UserController::class, 'update']);
// });


Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('users', [UserController::class, 'showInfo']);
    Route::post('users', [UserController::class, 'updateInfo']);
    Route::post('change-password', [UserController::class, 'changePassword']);
    Route::post('/users/products/get', [ProdcutUserController::class, 'getUserProducts']);
    Route::apiResource('products', ProductController::class)->except(['store', 'update', 'destroy']);
});


Route::group(['middleware' => ['jwt.auth', 'admin']], function () {
    Route::post('/users/products/assign', [ProdcutUserController::class, 'assignProductToUser']);
    Route::apiResource('products', ProductController::class);

});
