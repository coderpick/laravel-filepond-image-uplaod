<?php

use App\Http\Controllers\PostController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [PostController::class, 'index']);
Route::post('post/store', [PostController::class, 'store'])->name('post.store');

Route::post('/temp-upload', [PostController::class, 'tempUplaod']);
Route::delete('/temp-delete', [PostController::class, 'tempDelete']);
