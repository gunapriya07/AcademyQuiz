<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = \App\Models\Quiz::all();
        return view('quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('quizzes.create');
    }

    public function createQuestion($quizId)
    {
        $quiz = \App\Models\Quiz::findOrFail($quizId);
        return view('quizzes.add_question', compact('quiz'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \App\Models\Quiz::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('quizzes.index');
    }

    public function storeQuestion(Request $request, $quizId)
    {
        $question = \App\Models\Question::create([
            'quiz_id' => $quizId,
            'type' => $request->type,
            'body' => $request->body,
            'marks' => $request->marks,
        ]);

        // Save options
        if ($request->has('options')) {
            foreach ($request->options as $option) {
                \App\Models\Option::create([
                    'question_id' => $question->id,
                    'text' => $option['text'] ?? null,
                    'is_correct' => isset($option['is_correct']),
                ]);
            }
        }

        return redirect()->route('quizzes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
