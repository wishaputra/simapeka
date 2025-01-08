document.addEventListener('DOMContentLoaded', function () {
  const lessonModal = new bootstrap.Modal(document.getElementById('lessonModal'));
  const lessonForm = document.getElementById('lessonForm');
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const lessonType = document.getElementById('lesson-type');
  const lessonsTable = document.getElementById('lessons-table');
  const contentUrlGroup = document.getElementById('content-url-group');
  const contentFileGroup = document.getElementById('content-file-group');

  function updateFormFields() {
    if (lessonType.value === 'video') {
      contentUrlGroup.style.display = 'block';
      contentFileGroup.style.display = 'block';
      document.getElementById('lesson-content-file').accept = '.mp4';
    } else if (lessonType.value === 'pdf') {
      contentUrlGroup.style.display = 'none';
      contentFileGroup.style.display = 'block';
      document.getElementById('lesson-content-file').accept = '.pdf';
    } else {
      contentUrlGroup.style.display = 'none';
      contentFileGroup.style.display = 'none';
    }
  }

  lessonType.addEventListener('change', updateFormFields);

  document.getElementById('add-lesson').addEventListener('click', () => {
    lessonForm.reset();
    document.getElementById('lesson-id').value = '';
    document.getElementById('lessonModalLabel').textContent = 'Add Lesson';
    updateFormFields();
    lessonModal.show();
  });

  lessonForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const lessonId = document.getElementById('lesson-id').value;
    const formData = new FormData(lessonForm);
    const url = lessonId
      ? `/dev/corpu2/simapeka/public/sections/${sectionId}/lessons/${lessonId}`
      : `/dev/corpu2/simapeka/public/sections/${sectionId}/lessons`;

    const method = lessonId ? 'PUT' : 'POST';

    if (method === 'PUT') {
      formData.append('_method', 'PUT');
    }

    fetch(url, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken
      },
      body: formData
    })
      .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
      })
      .then(data => {
        if (data.success) {
          location.reload();
        } else {
          alert(data.message || 'An error occurred.');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An unexpected error occurred.');
      });
  });

  lessonsTable.addEventListener('click', function (e) {
    if (e.target.classList.contains('edit-lesson')) {
      const lessonId = e.target.dataset.id;

      fetch(`/dev/corpu2/simapeka/public/sections/${sectionId}/lessons/${lessonId}`)
        .then(response => {
          if (!response.ok) throw new Error('Failed to fetch lesson data.');
          return response.json();
        })
        .then(data => {
          if (data.success) {
            const lesson = data.lesson;
            document.getElementById('lesson-id').value = lesson.id;
            document.getElementById('lesson-title').value = lesson.title;
            document.getElementById('lesson-type').value = lesson.type;
            document.getElementById('lesson-duration').value = lesson.duration;
            document.getElementById('lesson-order').value = lesson.order;

            if (lesson.type === 'video') {
              document.getElementById('lesson-content-url').value = lesson.content;
            }

            updateFormFields();
            document.getElementById('lessonModalLabel').textContent = 'Edit Lesson';
            lessonModal.show();
          } else {
            alert(data.message || 'An error occurred while fetching lesson data.');
          }
        })
        .catch(error => {
          console.error(error.message);
          alert('Error fetching lesson data.');
        });
    } else if (e.target.classList.contains('delete-lesson')) {
      const lessonId = e.target.dataset.id;
      const url = `/dev/corpu2/simapeka/public/sections/${sectionId}/lessons/${lessonId}`;

      if (lessonId && confirm('Are you sure you want to delete this lesson?')) {
        fetch(url, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': csrfToken
          }
        })
          .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
          })
          .then(data => {
            if (data.success) {
              location.reload();
            } else {
              alert(data.message || 'An error occurred.');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An unexpected error occurred.');
          });
      }
    }
  });
});
