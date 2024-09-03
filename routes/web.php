<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\RulesController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/transactions', [TransactionsController::class, 'index'])->name('transactions.index');

    Route::get("/rules", [RulesController::class, 'index'])->name('rules.index');
    Route::get("/rules/create", [RulesController::class, 'create'])->name('rules.create');

    Route::get("/files", [FilesController::class, 'index'])->name('files.index');
});
