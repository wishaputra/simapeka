<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsnCourseProgress extends Model
{
    use HasFactory;

    protected $table = 'asn_course_progress';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nip',
        'course_id',
        'lesson_progress',
        'quiz_progress',
        'exam_id',
        'is_final_exam_passed',
        'completed_at',
    ]; 

    /**
     * Cast attributes to native types.
     *
     * @var array
     */
    protected $casts = [
        'lesson_progress' => 'array', // Cast JSON to array
        'quiz_progress' => 'array', // Cast JSON to array
        'is_final_exam_passed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    /**
     * Define the relationship to the course.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Define the relationship to the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }
}
