<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Pegawai;
use App\Models\AsnCourseProgress;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class AcademyCourse extends Controller
{
  public function index()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Retrieve courses the user has enrolled in
        $enrolledCourses = Enrollment::where('nip', $user->nip)
            ->pluck('course_id');

        $courses = Course::whereIn('id', $enrolledCourses)->get();

        // Fetch progress data for each course
        $coursesWithProgress = $courses->map(function ($course) use ($user) {
            $progress = AsnCourseProgress::where('nip', $user->nip)
                ->where('course_id', $course->id)
                ->first();

            if ($progress) {
                $totalLessons = $course->sections->flatMap->lessons->count();
                $totalQuizzes = $course->sections->flatMap->quizzes->count();
                $completedLessons = count($progress->lesson_progress);
                $completedQuizzes = count($progress->quiz_progress);

                $totalItems = $totalLessons + $totalQuizzes + 1; // +1 for the exam
                $completedItems = $completedLessons + $completedQuizzes + ($progress->is_final_exam_passed ? 1 : 0);

                $percentageComplete = $totalItems > 0 ? ($completedItems / $totalItems) * 100 : 0;

                $course->progress = [
                    'percentage' => round($percentageComplete, 2),
                    'completed_lessons' => $completedLessons,
                    'total_lessons' => $totalLessons,
                    'completed_quizzes' => $completedQuizzes,
                    'total_quizzes' => $totalQuizzes,
                    'is_final_exam_passed' => $progress->is_final_exam_passed,
                    'completed_at' => $progress->completed_at,
                ];
            } else {
                $course->progress = [
                    'percentage' => 0,
                    'completed_lessons' => 0,
                    'total_lessons' => $course->sections->flatMap->lessons->count(),
                    'completed_quizzes' => 0,
                    'total_quizzes' => $course->sections->flatMap->quizzes->count(),
                    'is_final_exam_passed' => false,
                    'completed_at' => null,
                ];
            }

            return $course;
        });

        return view('content.apps.app-academy-course', ['courses' => $coursesWithProgress]);
    }



  public function downloadCertificate($courseId)
    {
        $user = Auth::user();
        $course = Course::findOrFail($courseId);
        $progress = AsnCourseProgress::where('nip', $user->nip)
            ->where('course_id', $courseId)
            ->firstOrFail();

        if (!$progress->is_final_exam_passed) {
            return redirect()->back()->with('error', 'You have not completed this course yet.');
        }

        if (!view()->exists('certificates.course_completion')) {
            \Log::error('Certificate view file not found');
            return redirect()->back()->with('error', 'Unable to generate certificate. Please contact support.');
        }

        $pegawai = Pegawai::where('nip', $user->nip)->first(); // Get Pegawai data
        $data = [
            'user_name' => $pegawai ? $pegawai->nama : $user->name, // Use pegawai nama if available, otherwise fallback to user name
            'course_name' => $course->title,
            'completion_date' => $progress->completed_at->format('F d, Y'),
        ];

        $pdf = PDF::loadView('certificates.course_completion', $data);

        $fileName = 'certificate_' . $course->id . '_' . $user->nip . '.pdf';
        Storage::put('public/certificates/' . $fileName, $pdf->output());

        return response()->download(storage_path('app/public/certificates/' . $fileName))->deleteFileAfterSend(true);
    }
}
