<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttemptController extends Controller
{
    // Show the quiz attempt page
    public function show($quizId)
    {
        $quiz = \App\Models\Quiz::with('questions.options')->findOrFail($quizId);
        return view('quizzes.attempt', compact('quiz'));
    }

    // Handle quiz submission
    public function submit(\Illuminate\Http\Request $request, $quizId)
    {
        $quiz = \App\Models\Quiz::with('questions.options')->findOrFail($quizId);

        $attempt = \App\Models\Attempt::create([
            'quiz_id' => $quizId,
            'user_id' => null, // Update if user auth is added
            'total_score' => 0
        ]);

        $totalScore = 0;

        foreach ($quiz->questions as $question) {
            $userAnswer = $request->answers[$question->id] ?? null;
            $handler = $question->getTypeHandler();
            $isCorrect = $handler->evaluate($userAnswer, $question);
            $marks = $isCorrect ? $question->marks : 0;

            \App\Models\Answer::create([
                'attempt_id' => $attempt->id,
                'question_id' => $question->id,
                'given_answer' => json_encode($userAnswer),
                'is_correct' => $isCorrect,
                'marks_awarded' => $marks
            ]);

            $totalScore += $marks;
        }

        $attempt->update(['total_score' => $totalScore]);

        return redirect()->route('quizzes.result', $attempt->id);
    }

    // Show quiz result
    public function result($attemptId)
    {
        $attempt = \App\Models\Attempt::with('answers.question.options')->findOrFail($attemptId);
        return view('quizzes.result', compact('attempt'));
    }
}
