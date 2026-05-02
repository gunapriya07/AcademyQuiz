<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Answer;

class Attempt extends Model
{
    protected $fillable = [
        'quiz_id',
        'user_id',
        'total_score'
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
