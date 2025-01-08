document.addEventListener('DOMContentLoaded', function () {
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  // Open the Add Section Modal
  document.getElementById('open-add-section-modal').addEventListener('click', function () {
    const addSectionModal = new bootstrap.Modal(document.getElementById('addSectionModal'));
    addSectionModal.show();
  });

  // Handle Add Section Form Submission
  document.getElementById('addSectionForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const title = document.getElementById('sectionTitle').value;
    const order = document.getElementById('sectionOrder').value;
    const courseId = document.getElementById('submit-add-section').getAttribute('data-course-id');

    fetch(`/dev/corpu2/simapeka/public/courses/${courseId}/sections`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
      },
      body: JSON.stringify({ title, order })
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
        alert('Something went wrong. Please try again.');
      });
  });

  // Edit Section
  document.querySelectorAll('.edit-section').forEach(button => {
    button.addEventListener('click', function () {
      const sectionId = this.getAttribute('data-id');
      const title = this.getAttribute('data-title');
      const order = this.getAttribute('data-order');

      document.getElementById('editSectionId').value = sectionId;
      document.getElementById('editSectionTitle').value = title;
      document.getElementById('editSectionOrder').value = order;

      const editSectionModal = new bootstrap.Modal(document.getElementById('editSectionModal'));
      editSectionModal.show();
    });
  });

  // Handle Edit Section Form Submission
  document.getElementById('editSectionForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const sectionId = document.getElementById('editSectionId').value;
    const title = document.getElementById('editSectionTitle').value;
    const order = document.getElementById('editSectionOrder').value;

    fetch(`/dev/corpu2/simapeka/public/courses/sections/${sectionId}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
      },
      body: JSON.stringify({ title, order })
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
        alert('Something went wrong. Please try again.');
      });
  });

  // Delete Section
  document.querySelectorAll('.delete-section').forEach(button => {
    button.addEventListener('click', function () {
      const sectionId = this.getAttribute('data-id');
      if (confirm('Are you sure you want to delete this section?')) {
        fetch(`/dev/corpu2/simapeka/public/courses/sections/${sectionId}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': csrfToken
          }
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              location.reload();
            } else {
              alert(data.message || 'An error occurred.');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('Something went wrong. Please try again.');
          });
      }
    });
  });
});
