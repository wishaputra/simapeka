<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AsnCourseProgress;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AcademyDashboard extends Controller
{
  public function index()
    {
        $user = Auth::user();

        // Fetch all enrolled courses
        $enrolledCourses = Enrollment::where('nip', $user->nip)
            ->with('course')
            ->get();

        $courseData = $enrolledCourses->map(function ($enrollment) use ($user) {
            $course = $enrollment->course;
            $progress = AsnCourseProgress::where('nip', $user->nip)
                ->where('course_id', $course->id)
                ->first();

            $totalLessons = $course->sections->sum(function ($section) {
                return $section->lessons->count();
            });
            $totalQuizzes = $course->sections->sum(function ($section) {
                return $section->quizzes->count();
            });

            $completedLessons = count($progress->lesson_progress ?? []);
            $completedQuizzes = count($progress->quiz_progress ?? []);

            $totalItems = $totalLessons + $totalQuizzes;
            $completedItems = $completedLessons + $completedQuizzes;

            $progressPercentage = $totalItems > 0 ? round(($completedItems / $totalItems) * 100) : 0;

            return [
                'title' => $course->title,
                'progress' => $progressPercentage,
            ];
        });

        // Sort courses by progress percentage in descending order
        $courseData = $courseData->sortByDesc('progress')->values();

        // Count completed courses
        $completedCoursesCount = AsnCourseProgress::where('nip', $user->nip)
            ->where('is_final_exam_passed', true)
            ->count();

        // Fetch popular courses based on enrollment count (unchanged)
        $popularCourses = Enrollment::select('course_id', DB::raw('count(*) as enrollment_count'))
            ->groupBy('course_id')
            ->orderByDesc('enrollment_count')
            ->limit(5)
            ->with('course')
            ->get()
            ->map(function ($enrollment) {
                return [
                    'title' => $enrollment->course->title,
                    'enrollment_count' => $enrollment->enrollment_count,
                    'icon' => $this->getCourseIcon($enrollment->course->title),
                ];
            });

        return view('content.apps.app-academy-dashboard', compact('courseData', 'popularCourses', 'completedCoursesCount'));
    }

    private function getCourseIcon($courseTitle)
    {
        $icons = [
            'ri-vidicon-line',
            'ri-code-fill',
            'ri-image-2-line',
            'ri-palette-line',
            'ri-music-2-line',
        ];

        // Use a hash of the course title to consistently assign an icon
        $iconIndex = crc32($courseTitle) % count($icons);
        return $icons[$iconIndex];
    }
}
