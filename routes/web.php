<?php

use Illuminate\Support\Facades\Route;

// Redirect to the filament dashboard
Route::get('/', function () {
    return redirect()->to('/admin/login');
});
