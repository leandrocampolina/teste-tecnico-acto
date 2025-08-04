<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\FormManagementController;
use App\Http\Controllers\QuestionManagementController;
use App\Http\Controllers\AlternativeManagementController;
use App\Http\Controllers\FormResponseController;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// rotas de login / register / password etc gerenciadas pelo Breeze
require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    // dashboard (remova 'verified' se não estiver usando verificação de e-mail)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // responder formulários
    Route::get('/forms', [FormController::class, 'index'])->name('forms.index');
    Route::get('/forms/{form}', [FormController::class, 'show'])->name('forms.show');
    Route::post('/forms/{form}/submit', [FormController::class, 'submit'])->name('forms.submit');

    // minhas respostas
    Route::get('/my-responses', [FormResponseController::class, 'index'])->name('responses.index');
    Route::get('/my-responses/{response}', [FormResponseController::class, 'show'])->name('responses.show');

    // gerenciamento — só para admins (usa o middleware 'admin' que você criou)
    Route::prefix('manage')
        ->name('manage.')
        ->middleware([\App\Http\Middleware\EnsureAdmin::class])
        ->group(function () {
            Route::resource('forms', FormManagementController::class)->names('forms');
            Route::resource('questions', QuestionManagementController::class)->names('questions');
            Route::resource('alternatives', AlternativeManagementController::class)->names('alternatives');
        });
});
