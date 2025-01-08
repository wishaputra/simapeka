@extends('layouts/layoutMaster')

@section('title', 'Manage Questions')


@section('page-script')
@vite('resources/assets/js/question-management.js')
@endsection

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container">
    <h1>Manage Questions for Quiz: {{ $quiz->title }}</h1>
    <button class="btn btn-primary" id="open-add-question-modal">Add Question</button>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Question</th>
                <th>Type</th>
                <th>Points</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($quiz->questions as $question)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $question->question_text }}</td>
                    <td>{{ $question->type }}</td>
                    <td>{{ $question->points }}</td>
                    <td>
                        <button
                            class="btn btn-warning edit-question"
                            data-id="{{ $question->id }}"
                            data-question="{{ $question->question_text }}"
                            data-type="{{ $question->type }}"
                            data-options="{{ json_encode($question->options) }}"
                            data-correct="{{ $question->correct_answer }}"
                            data-points="{{ $question->points }}">
                            Edit
                        </button>
                        <button class="btn btn-danger delete-question" data-id="{{ $question->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal for Add/Edit Questions -->
<div id="quiz-container" data-quiz-id="{{ $quizId }}"></div>
<div class="modal" id="question-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add/Edit Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="question-form">
                    <div class="mb-3">
                        <label for="question_text" class="form-label">Question Text</label>
                        <textarea id="question_text" class="form-control" name="question_text" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <input type="hidden" name="quiz_id" value="{{ $quizId }}">
                        <select id="type" class="form-control" name="type" required>
                            <option value="essay">Essay</option>
                            <option value="multiple_choice">Pilihan Ganda</option>
                        </select>
                    </div>
                    <div class="mb-3" id="options-container" style="display: none;">
                        <label for="options" class="form-label">Options</label>
                        <div id="options-list">
                            <!-- Dynamic options will be appended here -->
                        </div>
                        <button type="button" class="btn btn-success mt-2" id="add-option">Add Option</button>
                    </div>
                    <div class="mb-3" id="correct-answer-container">
                        <label for="correct_answer" class="form-label">Correct Answer</label>
                        <input type="text" id="correct_answer" class="form-control" name="correct_answer">
                    </div>
                    <div class="mb-3">
                        <label for="points" class="form-label">Points</label>
                        <input type="number" id="points" class="form-control" name="points" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="save-question">Save</button>
            </div>
        </div>
    </div>
</div>

@endsection
