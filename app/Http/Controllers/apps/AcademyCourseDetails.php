<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Exam;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\AsnCourseProgress;

class AcademyCourseDetails extends Controller
{
    /**
     * Show the course details page.
     */
    public function index($courseId)
    {
        // Fetch course details with related data
        $course = Course::with([
            'sections.lessons',
            'sections.quizzes.questions',
            'exams.questions'
        ])->findOrFail($courseId);

        // Fetch exam details
        $exams = Exam::with('questions')->where('course_id', $courseId)->first();

        // Fetch progress for the current user
        $userNip = auth()->user()->nip; // Assuming `nip` is the unique identifier
        $progress = AsnCourseProgress::where('nip', $userNip)
            ->where('course_id', $courseId)
            ->first();

        return view('content.apps.app-academy-course-details', compact('course', 'exams', 'progress'));
    }

    /**
     * Get quiz questions via API.
     */
    public function getQuizQuestions($quizId)
    {
        $quiz = Quiz::with('questions')->findOrFail($quizId);

        return response()->json($quiz->questions->map(function ($question) use ($quiz) {
            return [
                'id' => $question->id,
                'quiz_title' => $quiz->title,
                'question_text' => $question->question_text,
                'type' => $question->type,
                'options' => $question->options ?? [], // Ensure options is always an array
                'correct_answer' => $question->correct_answer,
                'points' => $question->points,
            ];
        }));
    }





    /**
     * Update progress for lessons, quizzes, or exams.
     */
    public function updateLessonProgress(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
        ]);

        $progress = AsnCourseProgress::firstOrCreate(
            [
                'nip' => auth()->user()->nip,
                'course_id' => $request->course_id,
            ],
            [
                'lesson_progress' => [],
                'quiz_progress' => [],
            ]
        );

        $lessonProgress = $progress->lesson_progress ?? [];
        if (!in_array($request->lesson_id, $lessonProgress)) {
            $lessonProgress[] = $request->lesson_id;
            $progress->lesson_progress = $lessonProgress;
            $progress->save();
        }

        return response()->json(['message' => 'Progress updated successfully'], 200);
    }

    public function updateQuizProgress(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $progress = AsnCourseProgress::firstOrCreate(
            [
                'nip' => auth()->user()->nip,
                'course_id' => $request->course_id,
            ],
            [
                'lesson_progress' => [],
                'quiz_progress' => [],
            ]
        );

        $quizProgress = $progress->quiz_progress ?? [];
        if (!in_array($request->quiz_id, $quizProgress)) {
            $quizProgress[] = $request->quiz_id;
            $progress->quiz_progress = $quizProgress;
            $progress->save();
        }

        return response()->json(['message' => 'Quiz progress updated successfully'], 200);
    }

    public function getCourseProgress($courseId)
    {
        $progress = AsnCourseProgress::where('nip', auth()->user()->nip)
            ->where('course_id', $courseId)
            ->first();

        return response()->json($progress ?: ['lesson_progress' => [], 'quiz_progress' => []]);
    }


     /**
     * Show the exam page.
     */
    public function exam($id)
    {
        $exam = Exam::with('questions')->findOrFail($id);

        return view('content.apps.app-academy-course-exam', [
            'exam' => $exam,
        ]);
    }

    public function updateExamProgress(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
        ]);

        $user = auth()->user();
        $exam = Exam::findOrFail($request->exam_id);

        $progress = AsnCourseProgress::firstOrCreate(
            [
                'nip' => $user->nip,
                'course_id' => $exam->course_id,
            ],
            [
                'lesson_progress' => [],
                'quiz_progress' => [],
            ]
        );

        $progress->exam_id = $exam->id;
        $progress->is_final_exam_passed = true;
        $progress->completed_at = now();
        $progress->save();

        return response()->json(['message' => 'Exam progress updated successfully']);
    }
}
