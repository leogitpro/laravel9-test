<?php

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

Route::prefix('oauth')->name('oauth')->group(function(){
    Route::get('github', [App\Http\Controllers\OAuthController::class, 'github'])->name('.github');
    Route::get('ukr', [App\Http\Controllers\OAuthController::class, 'ukr'])->name('.ukr');
    Route::get('oauth', [App\Http\Controllers\OAuthController::class, 'oauth'])->name('.oauth');
});
