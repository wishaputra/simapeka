@extends('layouts/layoutMaster')

@section('title', 'Course Detail')

@section('page-script')
@vite('resources/assets/js/management-details.js')
@endsection


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container">
    <h1>{{ $course->title }} - Course Details</h1>
    <p>{{ $course->description }}</p>

    <div id="sections-panel">
        <h3>Sections</h3>
        <button class="btn btn-primary" id="open-add-section-modal" data-course-id="{{ $course->id }}">Add Section</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Title</th>
                    <th>Lessons</th>
                    <th>Quizzes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($course->sections as $section)
                    <tr>
                        <td>{{ $section->order }}</td>
                        <td>{{ $section->title }}</td>
                        <td>{{ $section->lessons->count() }}</td>
                        <td>{{ $section->quizzes->count() }}</td>
                        <td>
                            <a href="{{ route('lessons.index', ['sectionId' => $section->id]) }}" class="btn btn-info">
                                Manage Lessons
                            </a>
                            <a href="{{ route('quizzes.index', ['sectionId' => $section->id]) }}" class="btn btn-success">
                                Manage Quiz
                            </a>
                            <button class="btn btn-warning edit-section" data-id="{{ $section->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger delete-section" data-id="{{ $section->id }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Add Section Modal -->
    <div class="modal fade" id="addSectionModal" tabindex="-1" aria-labelledby="addSectionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addSectionLabel">Add Section</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="addSectionForm">
            <div class="modal-body">
            <div class="mb-3">
                <label for="sectionTitle" class="form-label">Title</label>
                <input type="text" class="form-control" id="sectionTitle" name="title" required>
            </div>
            <div class="mb-3">
                <label for="sectionOrder" class="form-label">Order</label>
                <input type="number" class="form-control" id="sectionOrder" name="order" required>
            </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary" id="submit-add-section" data-course-id="{{ $course->id }}">Submit</button>
            </div>
        </form>
        </div>
    </div>
    </div>
</div>
@endsection