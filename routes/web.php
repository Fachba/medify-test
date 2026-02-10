<?php

use App\Http\Controllers\MasterItemsController;
use App\Http\Controllers\MasterKategoriItemsController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/master-items', [App\Http\Controllers\MasterItemsController::class, 'index']);
Route::get('/master-items/search', [App\Http\Controllers\MasterItemsController::class, 'search']);
Route::get('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formView']);
Route::post('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formSubmit']);

Route::get('/master-items/view/{kode}', [App\Http\Controllers\MasterItemsController::class, 'singleView']);
Route::get('/master-items/delete/{id}', [App\Http\Controllers\MasterItemsController::class, 'delete']);

Route::get(
    'master-item/export-excel',
    [MasterItemsController::class, 'exportExcel']
);


Route::get('/master-items/update-random-data', [App\Http\Controllers\MasterItemsController::class, 'updateRandomData']);

Route::get('/master-kategori-items', [App\Http\Controllers\MasterKategoriItemsController::class, 'index']);
Route::get('/master-kategori-items/search', [App\Http\Controllers\MasterKategoriItemsController::class, 'search']);
Route::get('/master-kategori-items/form/{method}/{id?}', [App\Http\Controllers\MasterKategoriItemsController::class, 'formView']);
Route::post('/master-kategori-items/form/{method}/{id?}', [App\Http\Controllers\MasterKategoriItemsController::class, 'formSubmit']);

Route::get('/master-kategori-items/view/{kode}', [App\Http\Controllers\MasterKategoriItemsController::class, 'singleView']);
Route::get('/master-kategori-items/delete/{id}', [App\Http\Controllers\MasterKategoriItemsController::class, 'delete']);

Route::get(
    'master-kategori-items/cetak-pdf/{id}',
    [MasterKategoriItemsController::class, 'cetakPdf']
);



Route::get('/master-kategori-items/update-random-data', [App\Http\Controllers\MasterKategoriItemsController::class, 'updateRandomData']);
