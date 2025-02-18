<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Request;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Layout;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\Print2Controller;

//route resource
Route::resource('/pelanggans', \App\Http\Controllers\PelangganController::class);
Route::resource('/penjualans', \App\Http\Controllers\PenjualanController::class);
Route::resource('/detailpenjualans', \App\Http\Controllers\DetailpenjualanController::class);
Route::resource('/produks', \App\Http\Controllers\ProdukController::class);

//Route::get('/',[\App\Http\Controllers\Layout::class,'home']);
Route::get('/home',[\App\Http\Controllers\AuthController::class,'home']);
Route::controller(Layout::class)->group(function(){
//Route::get('/layout/home','home');
Route::get('/layout/menu','menu');
Route::get('/layout/index','index');
});

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class,'login'])->name('login');
Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/login', function () {
    return view('auth.login');

    
});


Route::get('/', function () {return view('welcome');});
//Route::get('/generate-pdf', [PdfController::class, 'generatePdf'])->name('generate-pdf');
Route::get('/print/pdf', [PrintController::class, 'generatePDF'])->name('generate-PDF');
Route::prefix('admin')->group(function() {
    Route::get('/print/second-pdf', [PrintController::class, 'generateSecondPDF'])->name('generate-Second-PDF');
});



Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');Route::post('logout', [AuthController::class, 'logout'])->name('logout');