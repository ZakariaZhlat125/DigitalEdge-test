<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\ProdcutUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();



Route::group(['middleware' => ['auth', 'admin']], function () {


    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


    Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
    Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
    Route::resource('products' ,ProductController::class);

    Route::get('/products-user', [ProdcutUserController::class, 'index'])->name('productsUser.index');
    Route::get('/products-user/assign', [ProdcutUserController::class, 'assign'])->name('productsUser.assign');
    Route::post('/products-user/assign-product-to-user', [ProdcutUserController::class, 'assignProductToUser'])->name('productsUser.assignProductToUser');
    Route::post('/productsUser/unassign', [ProdcutUserController::class,'unassignProductFromUser'])->name('productsUser.unassignProductFromUser');

    Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
});



// Route::controller(VerificationController::class)->group(function () {
//     Route::get('/email/verify', 'notice')->name('verification.notice');
//     Route::get('/email/verify/{id}/{hash}', 'verify')->name('verification.verify');
//     Route::post('/email/resend', 'resend')->name('verification.resend');
// });
