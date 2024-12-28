<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookController::class, 'index'])->name('index');
Route::get('/create', [BookController::class, 'create'])->name('create');
Route::post('/store', [BookController::class, 'store'])->name('store');
Route::get('/edit/{id}', [BookController::class, 'edit'])->name('edit');
Route::put('/update/{id}', [BookController::class, 'update'])->name('update');
Route::delete('/delete/{id}', [BookController::class, 'destroy'])->name('destroy');
