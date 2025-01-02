<?php

namespace App\Http\Controllers\apps;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class EnrollmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Retrieve all courses
        $courses = Course::all();

        // Get a list of course IDs the user is already enrolled in
        $enrolledCourseIds = Enrollment::where('nip', $user->nip)->pluck('course_id')->toArray();

        return view('content.apps.enrollment', [
            'courses' => $courses,
            'enrolledCourseIds' => $enrolledCourseIds,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $user = Auth::user(); // Get the authenticated user
        $nip = $user->nip;

        // Check if the user is already enrolled in the course
        if (Enrollment::where('nip', $nip)->where('course_id', $request->course_id)->exists()) {
            return redirect()->back()->with('error', 'You are already enrolled in this course!');
        }

        // Create the enrollment
        Enrollment::create([
            'nip' => $nip,
            'course_id' => $request->course_id,
        ]);

        return redirect()->back()->with('success', 'Successfully enrolled in the course!');
    }
}
