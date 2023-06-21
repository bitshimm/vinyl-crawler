<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\VinylmarktController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
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

Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/products', [ProductsController::class, 'show'])->name('products.show');

Route::get('/vinylmarkt', [VinylmarktController::class, 'form'])->name('vinylmarkt-form');

Route::get('/get-available', [MainController::class, 'getAvailable'])->name('get-available');
Route::post('/get-available-upload', [MainController::class, 'getAvailableUpload'])->name('get-available-upload');

Route::get('/vinylmarkt/export', [VinylmarktController::class, 'export'])->name('vinylmarkt.export');
Route::get('/vinylmarkt/fillLinks', [VinylmarktController::class, 'fillLinks'])->name('vinylmarkt.fillLinks');
Route::get('/vinylmarkt/updateProducts', [VinylmarktController::class, 'updateProducts'])->name('vinylmarkt.updateProducts');
Route::get('/read', function () {
    
});
