<?php

// app/Models/Question.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'quiz_id', 'question_text', 'type', 'options', 'correct_answer', 'points'
    ];

    protected $casts = [
        'options' => 'array', // Automatically cast the options JSON to an array
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
