<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Routes administrateur
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/export', [AdminController::class, 'export'])->name('admin.export');
Route::post('/admin/clean', [AdminController::class, 'cleanInvalidResponses'])->name('admin.clean');

// Routes quiz
Route::get('/quiz', [QuizController::class, 'show'])->name('quiz.show');
Route::post('/quiz/submit', [QuizController::class, 'submit'])->name('quiz.submit');
Route::get('/quiz/thank-you', [QuizController::class, 'thankYou'])->name('quiz.thank-you');
