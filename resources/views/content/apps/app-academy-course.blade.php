@extends('layouts/layoutMaster')
@php
$configData = Helper::appClasses();
@endphp

@section('title', 'Academy My Courses - App')

@section('vendor-style')
@vite([
'resources/assets/vendor/libs/select2/select2.scss',
'resources/assets/vendor/libs/plyr/plyr.scss'
])
@endsection

@section('page-style')
@vite('resources/assets/vendor/scss/pages/app-academy.scss')
@endsection

@section('vendor-script')
@vite([
'resources/assets/vendor/libs/select2/select2.js',
'resources/assets/vendor/libs/plyr/plyr.js'
])
@endsection

@section('page-script')
@vite('resources/assets/js/app-academy-course.js')
@endsection

@section('content')
<div class="app-academy">
  <div class="card p-0 mb-6">
    <!-- ... (keep the existing header content) ... -->
  </div>

  <div class="card mb-6">
    <div class="card-header d-flex flex-wrap justify-content-between gap-4">
        <div class="card-title mb-0 me-1">
            <h5 class="mb-0">Pelatihan Saya</h5>
            <p class="mb-0 text-body">Total {{ $courses->count() }} pelatihan yang anda ikuti</p>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach ($courses as $course)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="rounded-4 text-center mb-3">
                            <a href="{{ url('app/academy/course-details/' . $course->id) }}">
                                <img class="img-fluid" src="{{ $course->thumbnail ? asset($course->thumbnail) : asset('assets/img/placeholder.png') }}" alt="{{ $course->title }}">
                            </a>
                        </div>
                        <div class="card-body p-3 pt-0">
                            <a href="{{ url('app/academy/course-details/' . $course->id) }}" class="h5">{{ $course->title }}</a>
                            <p class="mt-1">{{ $course->description }}</p>
                            <p class="d-flex align-items-center mb-1">
                                <i class="ri-time-line ri-20px me-1"></i>
                                {{ $course->progress['completed_lessons'] }}/{{ $course->progress['total_lessons'] }} Lessons
                                | {{ $course->progress['completed_quizzes'] }}/{{ $course->progress['total_quizzes'] }} Quizzes
                            </p>
                            <div class="progress rounded-pill mb-2" style="height: 8px">
                                <div class="progress-bar" role="progressbar" style="width: {{ $course->progress['percentage'] }}%;" aria-valuenow="{{ $course->progress['percentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="text-end mb-4">{{ $course->progress['percentage'] }}% Complete</p>
                            <div class="d-flex flex-column flex-md-row gap-4 text-nowrap flex-wrap flex-md-nowrap flex-lg-wrap flex-xxl-nowrap">
                                @if($course->progress['is_final_exam_passed'])
                                    <a class="w-100 btn btn-success d-flex align-items-center" href="{{ url('app/academy/course-details/' . $course->id) }}">
                                        <i class="ri-check-line ri-16px align-middle me-2"></i><span>Course Completed</span>
                                    </a>
                                    <a class="w-100 btn btn-primary d-flex align-items-center" href="{{ route('academy.download.certificate', $course->id) }}">
                                        <i class="ri-download-line ri-16px align-middle me-2"></i><span>Download Certificate</span>
                                    </a>
                                @else
                                    <a class="w-100 btn btn-outline-secondary d-flex align-items-center" href="{{ url('app/academy/course-details/' . $course->id) }}">
                                        <i class="ri-refresh-line ri-16px align-middle me-2"></i><span>Continue Course</span>
                                    </a>
                                @endif

                                @if ($course->material)
                                    <a class="w-100 btn btn-outline-primary d-flex align-items-center" href="{{ asset($course->material) }}" download>
                                        <i class="ri-download-line ri-16px align-middle me-2"></i><span>Download Material</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
