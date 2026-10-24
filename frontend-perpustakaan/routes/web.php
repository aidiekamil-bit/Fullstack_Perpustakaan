<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [FrontendController::class, 'showLogin'])->name('login');
Route::post('/login', [FrontendController::class, 'login']);

Route::get('/register', [FrontendController::class, 'showRegister'])->name('register');
Route::post('/register', [FrontendController::class, 'register']);

Route::post('/logout', [FrontendController::class, 'logout'])->name('logout');

// Halaman Perpustakaan yang dilindungi token session
// BENAR (menggunakan index)
Route::get('/books', [FrontendController::class, 'index'])->name('books.index');
Route::post('/transactions', [FrontendController::class, 'storeTransaction'])->name('transactions.store');
Route::get('/transactions', [FrontendController::class, 'indexTransactions'])->name('transactions.index');
Route::post('/books', [FrontendController::class, 'storeBook'])->name('books.store');
Route::delete('/books/{id}', [FrontendController::class, 'destroyBook'])->name('books.destroy');