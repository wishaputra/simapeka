@extends('layouts/layoutMaster')

@section('title', 'Academy Final Exam - App')

@section('page-script')
@vite('resources/assets/js/app-academy-course-exam.js')
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Left Section: Questions -->
        <div class="col-lg-8">
            <div id="question-content" class="bg-white p-4 rounded shadow">
                <!-- Default Question Content -->
                @if ($exam->questions->isNotEmpty())
                    @foreach ($exam->questions as $index => $question)
                        <div class="question" id="question{{ $index }}" style="display: {{ $index === 0 ? 'block' : 'none' }};">
                            <h5>Question {{ $index + 1 }}</h5>
                            <p>{{ $question->question_text }}</p>

                            @if ($question->type === 'multiple_choice')
                                <div class="mt-3">
                                    @foreach ($question->options as $optionKey => $option)
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="answer{{ $question->id }}"
                                                id="option{{ $question->id }}{{ $optionKey }}"
                                                value="{{ $option }}">
                                            <label for="option{{ $question->id }}{{ $optionKey }}" class="form-check-label">
                                                {{ $option }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @elseif ($question->type === 'text')
                                <div class="mt-3">
                                    <textarea
                                        class="form-control"
                                        name="answer{{ $question->id }}"
                                        id="answer{{ $question->id }}"
                                        rows="4"
                                        placeholder="Enter your answer here..."></textarea>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p class="text-center text-muted">No questions available for this exam.</p>
                @endif
            </div>
        </div>

        <!-- Right Section: Question Navigation -->
        <div class="col-lg-4">
            <div class="bg-white p-4 rounded shadow stick-top">
                <h5 class="mb-4">Question Navigation</h5>
                <div class="d-grid gap-2">
                    @foreach ($exam->questions as $index => $question)
                        <button
                            class="btn btn-outline-primary question-nav"
                            data-target="question{{ $index }}">
                            Question {{ $index + 1 }}
                        </button>
                    @endforeach
                </div>
                <button id="submitExam" class="btn btn-primary w-100 mt-4">Submit Exam</button>
            </div>
        </div>
    </div>
</div>

<!-- Result Modal -->
<div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="resultModalLabel">Exam Results</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Your score: <span id="userScore"></span></p>
        <p>Passing score: <span id="passingScore"></span></p>
        <p id="resultMessage"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="restartExam" style="display: none;">Restart Exam</button>
      </div>
    </div>
  </div>
</div>

<input type="hidden" id="examData"
    data-questions='@json($exam->questions)'
    data-passing-score="{{ $exam->passing_score }}"
    data-exam-id="{{ $exam->id }}"
>
@endsection
