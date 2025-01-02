$(document).ready(function () {
  const courseTable = $('#courseTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '/dev/corpu2/simapeka/public/courses/data',
    columns: [
      {
        data: 'DT_RowIndex',
        name: 'DT_RowIndex',
        orderable: false,
        searchable: false
      },
      {
        data: 'thumbnail',
        name: 'thumbnail',
        render: data => `<img src="${data}" alt="Thumbnail" style="width: 50px;">`
      },
      {
        data: 'title',
        name: 'title'
      },
      {
        data: 'description',
        name: 'description'
      },
      {
        data: null,
        name: 'time_period',
        render: data => `
                    <span>${encodeHTML(data.start_date)} - ${encodeHTML(data.end_date)}</span>
                `
      },
      {
        data: null, // Combine check_in_start and check_in_end
        name: 'check_in_time',
        render: data => {
          if (data.check_in_start && data.check_in_end) {
            return `<span>${encodeHTML(data.check_in_start)} - ${encodeHTML(data.check_in_end)}</span>`;
          }
          return `<span>Not Set</span>`;
        }
      },
      {
        data: 'material',
        name: 'material',
        render: data => {
          if (data) {
            return `
                            <a href="${encodeHTML(data)}" target="_blank" class="btn btn-sm btn-primary" title="Download Material">
                                <i class="fas fa-file-powerpoint"></i> Download
                            </a>
                        `;
          }
          return `<span>No Material</span>`;
        },
        orderable: false,
        searchable: false
      },
      {
        data: null,
        render: function (data) {
          return `
                        <button class="btn btn-sm btn-warning edit-course"
                            data-id="${encodeHTML(data.id)}"
                            data-title="${encodeHTML(data.title)}"
                            data-description="${encodeHTML(data.description)}"
                            data-thumbnail="${encodeHTML(data.thumbnail)}"
                            data-material="${encodeHTML(data.material)}"
                            data-start_date="${encodeHTML(data.start_date)}"
                            data-end_date="${encodeHTML(data.end_date)}"
                            data-check_in_start="${encodeHTML(data.check_in_start)}"
                            data-check_in_end="${encodeHTML(data.check_in_end)}"
                            title="Edit Course">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-course"
                            data-id="${encodeHTML(data.id)}"
                            title="Delete Course">
                            <i class="fas fa-trash"></i>
                        </button>
                        <a href="/dev/corpu2/simapeka/public/courses/${data.id}/exams"
                            class="btn btn-sm btn-secondary manage-exams"
                            title="Manage Exams">
                            <i class="fas fa-book"></i> Exams
                        </a>
                        <a href="/dev/corpu2/simapeka/public/courses/${data.id}/attendance"
                            class="btn btn-sm btn-info manage-attendance"
                            title="View Attendance">
                            <i class="fas fa-list-alt"></i> Attendance
                        </a>
                    `;
        },
        orderable: false,
        searchable: false
      }
    ]
  });

  function encodeHTML(str) {
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/[\u00A0-\u9999<>&]/g, i => `&#${i.charCodeAt(0)};`)
      .replace(/'/g, '&#039;');
  }

  // Handle Edit Button Click
  $('#courseTable').on('click', '.edit-course', function () {
    const id = $(this).data('id');
    const title = $(this).data('title');
    const description = $(this).data('description');
    const thumbnail = $(this).data('thumbnail');
    const material = $(this).data('material'); // PPT File Link
    const startDate = $(this).data('start_date');
    const endDate = $(this).data('end_date');
    const checkInStart = $(this).data('check_in_start');
    const checkInEnd = $(this).data('check_in_end');

    // Populate form fields
    $('#editCourseId').val(id);
    $('#editCourseTitle').val(title);
    $('#editCourseDescription').val(description);
    $('#currentThumbnail').attr('src', thumbnail);
    $('#editCourseStartDate').val(startDate);
    $('#editCourseEndDate').val(endDate);
    $('#editCheckInStart').val(checkInStart);
    $('#editCheckInEnd').val(checkInEnd);

    // Populate Material Link in Modal
    if (material) {
      $('#currentMaterial').show();
      $('#currentMaterialLink').attr('href', material).text('View Current Material');
    } else {
      $('#currentMaterial').hide();
    }

    $('#editCourseModal').modal('show');
  });

  // Handle Edit Form Submission
  $('#editCourseForm').on('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    $.ajax({
      url: '/dev/corpu2/simapeka/public/course-management/update',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (response) {
        $('#editCourseModal').modal('hide');
        courseTable.ajax.reload(null, false);
        alert('Course updated successfully!');
      },
      error: function (xhr) {
        if (xhr.status === 422) {
          let errors = xhr.responseJSON.errors;
          let errorMessage = 'Validation errors:\n';
          for (let field in errors) {
            errorMessage += `${field}: ${errors[field].join(', ')}\n`;
          }
          alert(errorMessage);
        } else {
          alert('An error occurred. Please try again.');
        }
        console.log(xhr.responseText); // Log the full response for debugging
      }
    });
  });

  // Handle Delete Button Click
  $('#courseTable').on('click', '.delete-course', function () {
    const id = $(this).data('id');

    if (confirm('Are you sure you want to delete this course?')) {
      $.ajax({
        url: `/dev/corpu2/simapeka/public/course-management/delete/${id}`, // Update based on your route
        type: 'DELETE',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
        },
        success: function (response) {
          courseTable.ajax.reload(null, false); // Reload DataTable without resetting pagination
          alert('Course deleted successfully!');
        },
        error: function (error) {
          alert('An error occurred. Please try again.');
        }
      });
    }
  });

  $('#addCourseForm').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    // Add CSRF token to FormData
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

    $.ajax({
      url: '/dev/corpu2/simapeka/public/courses/store', // Update this URL based on your route
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function () {
        $('#addCourseModal').modal('hide');
        courseTable.ajax.reload();
        alert('Course added successfully!');
      },
      error: function () {
        alert('Failed to add course.');
      }
    });
  });
});
