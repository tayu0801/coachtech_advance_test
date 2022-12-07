<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
Route::post('/confirm', [ContactController::class, 'confirm'])->name('confirm');
Route::post('/thanks', [ContactController::class, 'send'])->name('send');
Route::get('/manage', [ContactController::class, 'manage'])->name('manage');
Route::get('/manage/search', [ContactController::class, 'search'])->name(
  'search'
);
Route::post('/{id}/delete', [ContactController::class, 'delete'])->name(
  'delete'
);
