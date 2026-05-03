
<?php
use Illuminate\Support\Facades\Auth;
// Quizzes page (protected)
Route::get('/quizzes', function () {
    if (!Auth::check()) {
        return redirect('/');
    }
    return view('quizzes.index');
})->name('quizzes');

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\AttemptController;

Route::get('quizzes/{quiz}/attempt', [AttemptController::class, 'show'])->name('quizzes.attempt');
Route::post('quizzes/{quiz}/submit', [AttemptController::class, 'submit'])->name('quizzes.submit');

Route::resource('quizzes', QuizController::class);

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('quizzes/{quiz}/questions/create', [QuizController::class, 'createQuestion'])->name('quizzes.questions.create');
Route::post('quizzes/{quiz}/questions', [QuizController::class, 'storeQuestion'])->name('quizzes.questions.store');

// Quiz attempt result page
Route::get('attempts/{attempt}', [AttemptController::class, 'result'])->name('quizzes.result');