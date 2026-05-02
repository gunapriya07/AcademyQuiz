<?php

namespace App\QuestionTypes;

use App\Models\Question;

class MultipleChoiceType implements QuestionTypeInterface
{
    public function evaluate($answer, Question $question): bool
    {
        $correctOptionIds = $question->options()->where('is_correct', true)->pluck('id')->sort()->values()->toArray();
        $userOptionIds = collect($answer ?? [])->sort()->values()->toArray();
        return $userOptionIds === $correctOptionIds;
    }
}
