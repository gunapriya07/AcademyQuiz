<?php

namespace App\QuestionTypes;

use App\Models\Question;

class TextType implements QuestionTypeInterface
{
    public function evaluate($answer, Question $question): bool
    {
        $correctOption = $question->options()->where('is_correct', true)->first();
        if (!$correctOption || !isset($answer)) {
            return false;
        }
        $userText = strtolower(trim($answer));
        $correctText = strtolower(trim($correctOption->text));
        return $userText === $correctText;
    }
}
