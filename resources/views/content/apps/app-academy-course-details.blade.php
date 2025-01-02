@extends('layouts/layoutMaster')

@section('title', 'Academy - My Course Details - App')

@section('vendor-style')
@vite('resources/assets/vendor/libs/plyr/plyr.scss')
@endsection

@section('page-style')
@vite('resources/assets/vendor/scss/pages/app-academy-details.scss')
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/plyr/plyr.js')
@endsection

@section('page-script')
@vite('resources/assets/js/app-academy-course-details.js')
@endsection

@section('content')
<div class="row g-6">
  <!-- Left Section -->
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">
        <!-- Course Header -->
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-6 gap-1">
          <div class="me-1">
            <h5 class="mb-0">{{ $course->title }}</h5>
          </div>
          <div class="d-flex align-items-center">
            <span class="badge bg-label-danger rounded-pill">{{ $course->category }}</span>
            <i class='ri-share-forward-line ri-24px mx-4'></i>
            <i class='ri-bookmark-line ri-24px'></i>
          </div>
        </div>

        <!-- Content Player -->
        <div class="card academy-content shadow-none border">
          <div class="p-2">
            <div id="lesson-content" class="bg-light p-4 rounded">
              <!-- Default content -->
              @if ($course->sections->isNotEmpty() && $course->sections->first()->lessons->isNotEmpty())
                @php
                  $lesson = $course->sections->first()->lessons->first();
                @endphp

                <!-- Lesson Content -->
                @if ($lesson->type === 'video')
                  <iframe
                    class="w-100 rounded shadow"
                    src="{{ strpos($lesson->content, 'youtube') !== false ? str_replace('watch?v=', 'embed/', $lesson->content) : $lesson->content }}"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                    style="height: 500px;">
                  </iframe>
                @elseif ($lesson->type === 'pdf')
                  <iframe class="w-100 rounded border" src="{{ $lesson->content }}" frameborder="0" style="height: 500px;"></iframe>
                @else
                  <p class="text-center text-muted">No content available for this lesson.</p>
                @endif

              @else
                <p class="text-center text-muted">No lessons available for this course.</p>
              @endif
            </div>

            <!-- Quiz Navigation -->
            <div id="quiz-navigation" class="mt-3 d-none">
              <div class="quiz-content">
                <!-- This will be dynamically filled by JavaScript -->
              </div>
              <div class="d-flex justify-content-between mt-3">
                <button id="prev-button" class="btn btn-secondary d-none">Previous</button>
                <button id="next-button" class="btn btn-primary d-none">Next</button>
              </div>
            </div>
          </div>

          <!-- Course Information -->
          <div class="card-body pt-3">
            <h5>Tentang</h5>
            <p class="mb-0">{{ $course->description }}</p>

            <hr class="my-6">
            <h5>Deskripsi</h5>
            <p class="mb-6">{{ $course->description }}</p>

            <hr class="my-6">
            <h5>Widyaiswara</h5>
            <div class="d-flex justify-content-start align-items-center user-name">
              <div class="avatar-wrapper">
                <div class="avatar me-4">
                  <!-- Add instructor's avatar -->
                </div>
              </div>
              <div class="d-flex flex-column">
                <!-- Add instructor's name/details -->
              </div>
            </div>

            <hr class="my-6">
            <div class="d-flex justify-content-between align-items-center">
              <!-- Absensi Button -->
              <a href="{{ route('attendance.index', ['courseId' => $course->id]) }}" class="btn btn-primary">
                <i class="ri-calendar-check-line ri-20px me-1_5"></i> Absensi
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Right Section -->
  <div class="col-lg-4">
  <input type="hidden" name="course_id" value="{{ $course->id }}">
    <div class="accordion stick-top accordion-custom-button" id="courseContent">
      @foreach ($course->sections as $section)
        <div class="accordion-item mb-0">
          <div class="accordion-header border-bottom-0" id="heading{{ $section->id }}">
            <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#section{{ $section->id }}" aria-expanded="true" aria-controls="section{{ $section->id }}">
              <span class="d-flex flex-column">
                <span class="h5 mb-0">{{ $section->title }}</span>
                <span class="text-body fw-normal">
                  {{ $section->lessons->count() }} Pelajaran |
                  {{ $section->duration }} min |
                  {{ $section->quizzes->count() }} Kuis
                </span>
              </span>
            </button>
          </div>
          <div id="section{{ $section->id }}" class="accordion-collapse collapse show" data-bs-parent="#courseContent">
            <div class="accordion-body py-4 border-top">
              <!-- Lessons Section -->
              <div class="lesson-section mb-4">
                <h6 class="text-uppercase text-muted mb-3">Lessons</h6>
                @foreach ($section->lessons as $lesson)
                  <div class="form-check d-flex align-items-center mb-3">
                    <input class="form-check-input lesson-selector" type="checkbox" name="lesson[]"
                           id="lesson{{ $lesson->id }}"
                           data-type="{{ $lesson->type }}"
                           data-content="{{ $lesson->content }}"
                           data-id="{{ $lesson->id }}"
                           {{ in_array($lesson->id, $progress->lesson_progress ?? []) ? 'checked' : '' }} />
                    <label for="lesson{{ $lesson->id }}" class="form-check-label ms-4">
                      <span class="mb-0 h6">{{ $lesson->title }}</span>
                      <small class="text-body d-block">{{ $lesson->duration }} min</small>
                    </label>
                  </div>
                @endforeach
              </div>

              <!-- Quizzes Section -->
              <div class="quiz-section">
                <h6 class="text-uppercase text-muted mb-3">Quizzes</h6>
                @foreach ($section->quizzes as $quiz)
                  <div class="form-check d-flex align-items-center mb-3">
                    <input class="form-check-input quiz-selector" type="checkbox" name="quiz[]"
                           id="quiz{{ $quiz->id }}"
                           data-id="{{ $quiz->id }}"
                           {{ in_array($quiz->id, $progress->quiz_progress ?? []) ? 'checked' : '' }} />
                    <label for="quiz{{ $quiz->id }}" class="form-check-label ms-4">
                      <span class="mb-0 h6">{{ $quiz->title }}</span>
                      <small class="text-body d-block">
                        {{ $quiz->duration }} min | {{ $quiz->points }} points
                      </small>
                    </label>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      @endforeach

      <!-- Final Exam Section -->
      @if ($exams)
        <div class="accordion-item mt-3">
          <div class="accordion-header border-bottom-0" id="headingFinalExam">
            <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#finalExam" aria-expanded="false" aria-controls="finalExam">
              <span class="d-flex flex-column">
                <span class="h5 mb-0">Final Exam</span>
                <span class="text-body fw-normal">
                  {{ $exams->duration }} min | Passing Score: {{ $exams->passing_score }}
                </span>
              </span>
            </button>
          </div>
          <div id="finalExam" class="accordion-collapse collapse" data-bs-parent="#courseContent">
            <div class="accordion-body py-4 border-top">
              <p class="mb-3">Complete the final exam to finish this course.</p>
              @if($progress && $progress->is_final_exam_passed)
                <p class="text-success">You have passed the final exam!</p>
              @else
              <button id="startExamBtn" class="btn btn-primary w-100" data-exam-id="{{ $exams->id }}" disabled>Start Final Exam</button>
                <p id="examRequirementMsg" class="text-warning mt-2">Complete all lessons and quizzes to unlock the final exam.</p>
              @endif
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>
</div>

<!-- Progress Modal -->
<div class="modal fade" id="progressModal" tabindex="-1" aria-labelledby="progressModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="progressModalLabel">Course Progress</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Lessons Completed: <span id="lessonsCompleted"></span>/<span id="totalLessons"></span></p>
        <p>Quizzes Completed: <span id="quizzesCompleted"></span>/<span id="totalQuizzes"></span></p>
        <p>Final Exam: <span id="finalExamStatus"></span></p>
      </div>
    </div>
  </div>
</div>
@endsection
