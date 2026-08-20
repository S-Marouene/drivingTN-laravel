<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExamController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ExamController::class, 'home'])->name('home');
Route::get('/examens/{exam}', [ExamController::class, 'show'])->name('exams.show');
Route::post('/examens/{exam}/soumettre', [ExamController::class, 'submit'])->name('exams.submit');
Route::get('/resultat/{attempt}', [ExamController::class, 'result'])->name('attempt.result');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/examens/nouveau', [AdminController::class, 'createExam'])->name('exams.create');
    Route::post('/examens', [AdminController::class, 'storeExam'])->name('exams.store');
    Route::get('/examens/{exam}', [AdminController::class, 'editExam'])->name('exams.edit');
    Route::put('/examens/{exam}', [AdminController::class, 'updateExam'])->name('exams.update');
    Route::delete('/examens/{exam}', [AdminController::class, 'destroyExam'])->name('exams.destroy');
    Route::get('/examens/{exam}/questions/nouvelle', [AdminController::class, 'createQuestion'])->name('questions.create');
    Route::post('/examens/{exam}/questions', [AdminController::class, 'storeQuestion'])->name('questions.store');
    Route::get('/examens/{exam}/questions/{question}', [AdminController::class, 'editQuestion'])->name('questions.edit');
    Route::put('/examens/{exam}/questions/{question}', [AdminController::class, 'updateQuestion'])->name('questions.update');
    Route::delete('/examens/{exam}/questions/{question}', [AdminController::class, 'destroyQuestion'])->name('questions.destroy');
});
