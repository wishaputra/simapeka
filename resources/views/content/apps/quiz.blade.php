@extends('layouts/layoutMaster')

@section('title', 'Quiz Management')

@section('page-script')
@vite('resources/assets/js/quiz-management.js')
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container">
    <h1>Quizzes for Section: {{ $section->title }}</h1>

    <button class="btn btn-primary mb-3" id="open-add-quiz-modal" data-section-id="{{ $section->id }}">Add Quiz</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Points</th>
                <th>Duration (minutes)</th>
                <th>Status</th>
                <th>Questions</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($section->quizzes as $quiz)
                <tr>
                    <td>{{ $quiz->title }}</td>
                    <td>{{ $quiz->points }}</td>
                    <td>{{ $quiz->duration }}</td>
                    <td>{{ $quiz->status ? 'Active' : 'Inactive' }}</td>
                    <td>{{ $quiz->questions->count() }}</td>
                    <td>
                        <button class="btn btn-warning edit-quiz" data-id="{{ $quiz->id }}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-danger delete-quiz" data-id="{{ $quiz->id }}">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                        <a href="{{ route('questions.index', ['quizId' => $quiz->id]) }}" class="btn btn-info">
                            Manage Questions
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add/Edit Quiz Modal -->
<div class="modal fade" id="quizModal" tabindex="-1" aria-labelledby="quizModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quizModalLabel">Add/Edit Quiz</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="quizForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="quiz-id" name="id">
                    <input type="hidden" id="section-id" name="section_id" value="{{ $section->id }}">
                    <div class="mb-3">
                        <label for="quiz-title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="quiz-title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="quiz-points" class="form-label">Points</label>
                        <input type="number" class="form-control" id="quiz-points" name="points" required>
                    </div>
                    <div class="mb-3">
                        <label for="quiz-duration" class="form-label">Duration (minutes)</label>
                        <input type="number" class="form-control" id="quiz-duration" name="duration" required>
                    </div>
                    <div class="mb-3">
                        <label for="quiz-status" class="form-label">Status</label>
                        <select class="form-select" id="quiz-status" name="status" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
