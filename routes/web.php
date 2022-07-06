<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CropImageController;
use App\Http\Controllers\CropImageController2;

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
    return view('crop-image-upload');
});

Route::get('crop-image-upload', [CropImageController::class, 'index']);
Route::post('crop-image-upload', [CropImageController::class, 'uploadCropImage']);

Route::get('crop-image-upload2', [CropImageController2::class, 'index']);
Route::post('crop-image-upload2', [CropImageController2::class, 'uploadCropImage']);
Route::get('crop-image-upload2/getdata', [CropImageController2::class, 'getdata']);
