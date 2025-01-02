@extends('layouts/layoutMaster')

@section('title', 'Exam Management')

@section('page-script')
@vite('resources/assets/js/exam-panel.js')
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5>Manage Exams for Course: {{ $course->title }}</h5>
        </div>
        <div class="card-body">
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addExamModal">
                Add Exam
            </button>
            <table id="examTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Passing Score</th>
                        <th>Duration (mins)</th>
                        <th>Max Attempts</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($course->exams as $exam)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $exam->title }}</td>
                        <td>{{ $exam->passing_score }}</td>
                        <td>{{ $exam->duration }}</td>
                        <td>{{ $exam->max_attempts }}</td>
                        <td>
                            <a href="{{ route('exams.questions', $exam->id) }}" class="btn btn-info btn-sm">
                                Manage Questions
                            </a>
                            <button class="btn btn-warning btn-sm editExamBtn" 
                                    data-id="{{ $exam->id }}" 
                                    data-title="{{ $exam->title }}"
                                    data-passing_score="{{ $exam->passing_score }}"
                                    data-duration="{{ $exam->duration }}"
                                    data-max_attempts="{{ $exam->max_attempts }}">
                                Edit
                            </button>
                            <button class="btn btn-danger btn-sm deleteExamBtn" data-id="{{ $exam->id }}">
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

<!-- Add Exam Modal -->
<div class="modal fade" id="addExamModal" tabindex="-1" aria-labelledby="addExamModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addExamForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExamModalLabel">Add New Exam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="examTitle" class="form-label">Title</label>
                        <input type="text" id="examTitle" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="passingScore" class="form-label">Passing Score</label>
                        <input type="number" id="passingScore" name="passing_score" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="duration" class="form-label">Duration (in minutes)</label>
                        <input type="number" id="duration" name="duration" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="maxAttempts" class="form-label">Max Attempts</label>
                        <input type="number" id="maxAttempts" name="max_attempts" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Exam Modal -->
<div class="modal fade" id="editExamModal" tabindex="-1" aria-labelledby="editExamModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editExamForm">
            @csrf
            <input type="hidden" id="editExamId" name="id">
            <input type="hidden" id="courseId" name="course_id" value="{{ $course->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editExamModalLabel">Edit Exam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editExamTitle" class="form-label">Title</label>
                        <input type="text" id="editExamTitle" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPassingScore" class="form-label">Passing Score</label>
                        <input type="number" id="editPassingScore" name="passing_score" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDuration" class="form-label">Duration (in minutes)</label>
                        <input type="number" id="editDuration" name="duration" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editMaxAttempts" class="form-label">Max Attempts</label>
                        <input type="number" id="editMaxAttempts" name="max_attempts" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
