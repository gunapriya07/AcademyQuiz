<?php

namespace App\QuestionTypes;

use App\Models\Question;

class NumberType implements QuestionTypeInterface
{
    public function evaluate($answer, Question $question): bool
    {
        $correctOption = $question->options()->where('is_correct', true)->first();
        return $answer !== null && $correctOption && (float) $answer === (float) $correctOption->text;
    }
}
