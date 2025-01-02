@extends('layouts/layoutMaster')

@section('title', 'Course Management')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js',
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js'
])
@endsection

@section('page-script')
@vite('resources/assets/js/course-management.js')
@endsection

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5>Manage Courses</h5>
        </div>
        <div class="card-body">
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                Add Course
            </button>
            <table id="courseTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Thumbnail</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Time Period</th>
                        <th>Check-In Time</th> <!-- New Column -->
                        <th>Material</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Add Course Modal -->
<div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCourseModalLabel">Add New Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addCourseForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="courseTitle" class="form-label">Course Title</label>
                        <input type="text" id="courseTitle" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="courseDescription" class="form-label">Description</label>
                        <textarea id="courseDescription" name="description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="startDate" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="startDate" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="endDate" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="endDate" name="end_date" required>
                    </div>
                    <div class="form-group">
                        <label for="checkInStart">Check-In Start Time</label>
                        <input type="time" id="checkInStart" name="check_in_start" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="checkInEnd">Check-In End Time</label>
                        <input type="time" id="checkInEnd" name="check_in_end" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="courseThumbnail" class="form-label">Thumbnail</label>
                        <input type="file" id="courseThumbnail" name="thumbnail" class="form-control" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="courseMaterial" class="form-label">Course Material (PPT)</label>
                        <input type="file" id="courseMaterial" name="material" class="form-control" accept=".ppt,.pptx" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Course Modal -->
<div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCourseForm">
                @csrf
                <input type="hidden" id="editCourseId" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editCourseTitle" class="form-label">Course Title</label>
                        <input type="text" id="editCourseTitle" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCourseDescription" class="form-label">Description</label>
                        <textarea id="editCourseDescription" name="description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editCourseThumbnail" class="form-label">Thumbnail</label>
                        <input type="file" id="editCourseThumbnail" name="thumbnail" class="form-control" accept="image/*">
                        <img id="currentThumbnail" src="" alt="Current Thumbnail" class="img-fluid mt-2" width="150">
                    </div>
                    <div class="mb-3">
                        <label for="editCourseStartDate" class="form-label">Start Date</label>
                        <input type="date" id="editCourseStartDate" name="start_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCourseEndDate" class="form-label">End Date</label>
                        <input type="date" id="editCourseEndDate" name="end_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editCheckInStart">Check-In Start Time</label>
                        <input type="time" id="editCheckInStart" name="check_in_start" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editCheckInEnd">Check-In End Time</label>
                        <input type="time" id="editCheckInEnd" name="check_in_end" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCourseMaterial" class="form-label">Course Material (PPT)</label>
                        <input type="file" id="editCourseMaterial" name="material" class="form-control" accept=".ppt,.pptx">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this course?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button id="confirmDeleteBtn" type="button" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>

@endsection
