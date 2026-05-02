<?php

namespace App\QuestionTypes;

use App\QuestionTypes\BinaryType;
use App\QuestionTypes\SingleChoiceType;
use App\QuestionTypes\MultipleChoiceType;
use App\QuestionTypes\NumberType;
use App\QuestionTypes\TextType;
use App\QuestionTypes\QuestionTypeInterface;

class QuestionTypeFactory
{
    public static function make($type): QuestionTypeInterface
    {
        return match ($type) {
            'binary' => new BinaryType(),
            'single_choice' => new SingleChoiceType(),
            'multiple_choice' => new MultipleChoiceType(),
            'number' => new NumberType(),
            'text' => new TextType(),
            default => throw new \InvalidArgumentException("Unknown question type: $type"),
        };
    }
}