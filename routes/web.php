<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\Admin\StatisticsController;

// Routes d'authentification
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Routes protégées pour l'administration
Route::middleware(['auth'])->group(function () {
    // Redirection de /admin vers le tableau de bord
    Route::redirect('/admin', '/admin/dashboard');
    
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/export', [AdminController::class, 'export'])->name('admin.export');
    Route::post('/admin/clean', [AdminController::class, 'cleanInvalidResponses'])->name('admin.clean');
    Route::get('/admin/responses/{tableId}/history', [AdminController::class, 'history'])->name('admin.responses.history');

    // Routes pour la gestion des questions
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
        Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
        Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
        Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
        Route::put('/questions/{question}/order', [QuestionController::class, 'updateOrder'])->name('questions.updateOrder');
        Route::put('/questions/{question}/move', [QuestionController::class, 'move'])->name('questions.move');
        
        // Nouvelles routes pour la gestion des réponses
        Route::get('/questions/{question}/responses', [QuestionController::class, 'getResponses'])->name('questions.responses');
        Route::put('/questions/{question}/responses', [QuestionController::class, 'updateResponses'])->name('questions.updateResponses');
    });

    // Route pour les statistiques
    Route::get('/admin/statistics', [StatisticsController::class, 'index'])->name('admin.statistics.index');
});

// Routes quiz (publiques)
Route::get('/', [QuizController::class, 'showQr'])->name('home');
Route::get('/quiz/{tableId?}', [QuizController::class, 'show'])->name('quiz.show');
Route::post('/responses', [ResponseController::class, 'store'])->name('responses.store');
Route::view('/thank-you', 'thank-you')->name('thank-you');
