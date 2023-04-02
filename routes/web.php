<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ShoppingsiteController;

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
Route::get('/cc', function() {
    Artisan::call('optimize');

    return "Cache is cleared";
});

Route::get('/', [ProductController::class, 'allProduct'])->name('webpage'); //for main page 

// Route::get('storage//{foldername}//{filename}', [FileController::class, 'getFile'])->where('filename', '^[^/]+$');
require __DIR__.'/admin.php';
require __DIR__.'/user.php';