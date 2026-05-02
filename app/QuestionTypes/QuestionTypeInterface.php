<?php

namespace App\QuestionTypes;

use App\Models\Question;

interface QuestionTypeInterface
{
    public function evaluate($answer, Question $question): bool;
}
