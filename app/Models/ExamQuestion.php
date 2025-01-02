<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamQuestion extends Model
{ 

    use HasFactory;

    protected $fillable = [
        'exam_id', 'question_text', 'type', 'options', 'correct_answer', 'points'
    ];

    protected $casts = [
        'options' => 'array', // JSON data for options
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
