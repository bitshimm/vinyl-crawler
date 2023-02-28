<?php

use App\Http\Controllers\VinylmarktController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [WebsiteController::class, 'index'])->name('index');
Route::get('/show', [WebsiteController::class, 'show'])->name('show');
// Route::get('/vinylmarkt/show', [VinylmarktController::class, 'show'])->name('vinylmarkt.show');
// Route::get('/vinylmarkt/export', [VinylmarktController::class, 'export'])->name('vinylmarkt.export');
Route::get('/vinylmarkt/fillLinks', [VinylmarktController::class, 'fillLinks'])->name('vinylmarkt.fillLinks');
Route::get('/vinylmarkt/updateProducts', [VinylmarktController::class, 'updateProducts'])->name('vinylmarkt.updateProducts');
