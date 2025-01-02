<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Kehadiran;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index($courseId)
    {
        $course = Course::findOrFail($courseId);

        // Fetch attendance for the current student (assuming user is logged in)
        $attendance = Kehadiran::where('course_id', $courseId)
            ->where('nip', auth()->user()->nip)
            ->get();

        // Generate date range for the course
        $startDate = Carbon::parse($course->start_date);
        $endDate = Carbon::parse($course->end_date);

        $dates = [];
        while ($startDate->lte($endDate)) {
            $dates[] = $startDate->format('Y-m-d');
            $startDate->addDay();
        }

        return view('content.apps.attendance', compact('course', 'attendance', 'dates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'nip' => 'required|exists:users,nip',
            'tanggal_hadir' => 'required|date',
        ]);

        // Get course and its check-in time range
        $course = Course::findOrFail($request->course_id);
        $checkInStart = Carbon::parse($course->check_in_start);
        $checkInEnd = Carbon::parse($course->check_in_end);

        // Current check-in time
        $currentTime = Carbon::now();

        // Determine attendance status
        $status = $currentTime->between($checkInStart, $checkInEnd) ? 'On-Time' : 'Late';

        // Create new attendance record
        Kehadiran::create([
            'course_id' => $request->course_id,
            'nip' => $request->nip,
            'tanggal_hadir' => $request->tanggal_hadir,
            'status' => $status,
        ]);

        return back()->with('success', 'Attendance recorded successfully!');
    }

    public function showAttendance($course_id)
    {
        $course = Course::findOrFail($course_id);

        // Fetch attendance with pegawai relationship
        $attendance = Kehadiran::where('course_id', $course_id)
            ->with('pegawai') // Eager load pegawai data
            ->get();

        return view('content.apps.kehadiran', compact('course', 'attendance'));
    }
}
