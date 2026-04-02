<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VocabularyController;


Route::get('/', [VocabularyController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard', [VocabularyController::class, 'dashboard']);
Route::get('/vocabularies/flashcards', [VocabularyController::class, 'flashcards'])->name('vocabularies.flashcards');
Route::get('/vocabularies/quiz', [VocabularyController::class, 'quiz'])->name('vocabularies.quiz');
Route::resource('vocabularies', VocabularyController::class);
