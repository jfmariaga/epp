<?php

use App\Http\Controllers\firmaEpp;
use App\Http\Controllers\SignaturePadController;
use Illuminate\Support\Facades\Auth;
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
    return view('auth.login');
});

// --------------------------errores de paginas------------------------
Route::get('error', function(){
    abort('404');
})->name('page_404');

Route::get('error', function(){
    abort('403');
})->name('page_403');

Route::get('error', function(){
    abort('500');
})->name('page_500');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::view('Empleado', 'colaborador.index')->name('empleado');
    Route::view('Inventario', 'inventario.index')->name('inventario');
    Route::view('Entrega', 'entrega.index')->name('entrega');
    Route::view('Reporte', 'reporte.index')->name('reportes');

    Route::get('signature-pad/{id}', [SignaturePadController::class, 'index'])->name('signpad.index');
    Route::put('signature-pad/{id}', [SignaturePadController::class, 'update'])->name('signpad.update');
    Route::get('firma/{id}', [firmaEpp::class, 'index'])->name('firma.index');
    Route::put('firma/{id}', [firmaEpp::class, 'update'])->name('firma.update');
    Route::get('/generatePDF/{id}', [SignaturePadController::class, 'Addtopdf'])->name('signpad.Addtopdf');
    Route::get('/generateFS32/{id}', [SignaturePadController::class, 'foso32'])->name('signpad.so-32');

    Route::middleware('admin')->group(function () {
        Route::view('Usuario', 'usuario.index')->name('usuario');
    });
});