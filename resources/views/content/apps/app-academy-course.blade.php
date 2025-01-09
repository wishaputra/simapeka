@extends('layouts/layoutMaster')
@php
$configData = Helper::appClasses();
use Illuminate\Support\Str;
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
  <div class="card p-0 mb-4">
    <!-- ... (keep the existing header content) ... -->
  </div>

  <div class="card mb-4">
    <div class="card-header d-flex flex-wrap justify-content-between gap-2">
        <div class="card-title mb-0">
            <h5 class="mb-0">Pelatihan Saya</h5>
            <p class="mb-0 text-body">Total {{ $courses->count() }} pelatihan yang anda ikuti</p>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @foreach ($courses as $course)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="rounded-top text-center">
                            <a href="{{ url('app/academy/course-details/' . $course->id) }}">
                                <img class="img-fluid" src="{{ $course->thumbnail ? asset($course->thumbnail) : asset('assets/img/placeholder.png') }}" alt="{{ $course->title }}">
                            </a>
                        </div>
                        <div class="card-body p-3">
                            <h6 class="card-title mb-1">
                                <a href="{{ url('app/academy/course-details/' . $course->id) }}" class="text-body">{{ $course->title }}</a>
                            </h6>
                            <p class="card-text small mb-2">{{ Str::limit($course->description, 100) }}</p>
                            <div class="d-flex align-items-center mb-1 small">
                                <i class="ri-time-line ri-lg me-1"></i>
                                <span>{{ $course->progress['completed_lessons'] }}/{{ $course->progress['total_lessons'] }} Lessons |
                                {{ $course->progress['completed_quizzes'] }}/{{ $course->progress['total_quizzes'] }} Quizzes |
                                Exam: {{ $course->progress['is_final_exam_passed'] ? 'Passed' : 'Not Passed' }}</span>
                            </div>
                            <div class="progress rounded-pill mb-2" style="height: 6px">
                                <div class="progress-bar" role="progressbar" style="width: {{ $course->progress['percentage'] }}%;" aria-valuenow="{{ $course->progress['percentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="text-end small mb-3">{{ $course->progress['percentage'] }}% Complete</p>
                            <div class="d-flex flex-wrap gap-2">
                                @if($course->progress['is_final_exam_passed'])
                                    <a class="btn btn-sm btn-success flex-grow-1" href="{{ url('app/academy/course-details/' . $course->id) }}">
                                        <i class="ri-check-line ri-lg align-middle me-1"></i>Completed
                                    </a>
                                    <a class="btn btn-sm btn-primary flex-grow-1" href="{{ route('academy.download.certificate', $course->id) }}">
                                        <i class="ri-download-line ri-lg align-middle me-1"></i>Certificate
                                    </a>
                                @else
                                    <a class="btn btn-sm btn-outline-secondary flex-grow-1" href="{{ url('app/academy/course-details/' . $course->id) }}">
                                        <i class="ri-refresh-line ri-lg align-middle me-1"></i>Continue
                                    </a>
                                @endif
                                @if ($course->material)
                                    <a class="btn btn-sm btn-outline-primary flex-grow-1" href="{{ asset($course->material) }}" download>
                                        <i class="ri-download-line ri-lg align-middle me-1"></i>Material
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
