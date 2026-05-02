<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;

Route::resource('quizzes', QuizController::class);

Route::get('/', function () {
    return view('welcome');
});
Route::get('quizzes/{quiz}/questions/create', [QuizController::class, 'createQuestion'])->name('quizzes.questions.create');
Route::post('quizzes/{quiz}/questions', [QuizController::class, 'storeQuestion'])->name('quizzes.questions.store');