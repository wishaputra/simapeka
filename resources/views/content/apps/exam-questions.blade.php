@extends('layouts/layoutMaster')

@section('title', 'Manage Exam Questions')

@section('page-script')
@vite('resources/assets/js/exam-questions.js')
@endsection

@section('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container">
    <input type="hidden" name="exam_id" value="{{ $examId }}">
    <div class="card">
        <div class="card-header">
            <h5>Manage Questions for Exam: {{ $exam->title }}</h5>
        </div>
        <div class="card-body">
            <button class="btn btn-primary mb-3" id="open-add-question-modal">Add Question</button>
            <table id="questionTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Question</th>
                        <th>Type</th>
                        <th>Points</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="questionList">
                    @foreach ($exam->questions as $question)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $question->question_text }}</td>
                            <td>{{ $question->type }}</td>
                            <td>{{ $question->points }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-question" 
                                    data-id="{{ $question->id }}" 
                                    data-question="{{ $question->question_text }}" 
                                    data-type="{{ $question->type }}" 
                                    data-points="{{ $question->points }}" 
                                    data-options="{{ json_encode($question->options) }}" 
                                    data-correct="{{ $question->correct_answer }}">
                                    Edit
                                </button>
                                <button class="btn btn-danger btn-sm delete-question" 
                                    data-id="{{ $question->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Question Modal -->
<div class="modal fade" id="questionModal" tabindex="-1" aria-labelledby="questionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="questionForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="questionModalLabel">Add/Edit Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                    <input type="hidden" id="questionId" name="id">
                    <div class="mb-3">
                        <label for="questionText" class="form-label">Question Text</label>
                        <textarea id="questionText" name="question_text" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select id="type" name="type" class="form-select" required>
                            <option value="">Select Type</option>
                            <option value="essay">Essay</option>
                            <option value="multiple_choice">Multiple Choice</option>
                        </select>
                    </div>
                    <div id="multipleChoiceFields" style="display: none;">
                        <div class="mb-3">
                            <label for="options" class="form-label">Options</label>
                            <div id="optionsContainer">
                                <!-- Options will be dynamically added here -->
                            </div>
                            <button type="button" class="btn btn-secondary" id="addOptionButton">Add Option</button>
                        </div>
                        <div class="mb-3">
                            <label for="correctAnswer" class="form-label">Correct Answer</label>
                            <input type="text" id="correctAnswer" name="correct_answer" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="points" class="form-label">Points</label>
                        <input type="number" id="points" name="points" class="form-control" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="save-question">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


