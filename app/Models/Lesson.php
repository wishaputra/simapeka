<?php

// app/Models/Lesson.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'order','section_id', 'title', 'type', 'content', 'duration'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
