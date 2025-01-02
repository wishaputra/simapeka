@extends('layouts/layoutMaster')

@section('title', 'Lesson Management')

@section('page-script')
@vite('resources/assets/js/lesson-details.js')
@endsection

@section('content')
<script>
    const sectionId = "{{ $sectionId }}"; // Assuming $sectionId is available in your backend
</script>

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container"> 
    <h1>Manage Lessons for Section: {{ $section->title }}</h1>
    <!-- <p>{{ $section->description }}</p> -->

    <!-- Add Lesson Button -->
    <div class="mb-3">
        <button class="btn btn-primary" id="add-lesson">Add Lesson</button>
    </div>

    <!-- Lessons Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order</th>
                <th>Title</th>
                <th>Type</th>
                <th>Duration</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="lessons-table">
            @foreach ($section->lessons as $lesson)
                <tr data-id="{{ $lesson->id }}">
                    <td>{{ $lesson->order }}</td>
                    <td>{{ $lesson->title }}</td>
                    <td>{{ $lesson->type }}</td>
                    <td>{{ $lesson->duration }} mins</td>
                    <td>
                    <button 
                        class="btn btn-warning edit-lesson" 
                        data-id="{{ $lesson->id }}" 
                        data-lesson="{{ json_encode(['id' => $lesson->id, 'title' => $lesson->title, 'type' => $lesson->type, 'duration' => $lesson->duration, 'order' => $lesson->order, 'content' => $lesson->content]) }}">
                        Edit
                    </button>
                    <button class="btn btn-danger delete-lesson" 
                        data-id="{{ $lesson->id }}" 
                        data-url="{{ route('lessons.destroy', ['sectionId' => $section->id, 'lessonId' => $lesson->id]) }}">
                        Delete
                    </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Add/Edit Lesson Modal -->
    <div class="modal fade" id="lessonModal" tabindex="-1" aria-labelledby="lessonModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lessonModalLabel">Add/Edit Lesson</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="lessonForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="lesson-id" name="id">
                        <div class="mb-3">
                            <label for="lesson-order" class="form-label">Order</label>
                            <input type="number" class="form-control" id="lesson-order" name="order" required>
                        </div>
                        <div class="mb-3">
                            <label for="lesson-title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="lesson-title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="lesson-type" class="form-label">Type</label>
                            <select class="form-select" id="lesson-type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="video">Video</option>
                                <option value="pdf">PDF</option>
                            </select>
                        </div>
                        <div class="mb-3" id="content-url-group" style="display: none;">
                            <label for="lesson-content-url" class="form-label">Video URL</label>
                            <input type="url" class="form-control" id="lesson-content-url" name="content_url">
                        </div>
                        <div class="mb-3" id="content-file-group" style="display: none;">
                            <label for="lesson-content-file" class="form-label">Upload File</label>
                            <input type="file" class="form-control" id="lesson-content-file" name="content_file" accept=".pdf,.mp4">
                        </div>
                        <div class="mb-3">
                            <label for="lesson-duration" class="form-label">Duration (minutes)</label>
                            <input type="number" class="form-control" id="lesson-duration" name="duration" required>
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
</div>
@endsection
