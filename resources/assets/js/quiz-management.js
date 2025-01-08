document.addEventListener('DOMContentLoaded', () => {
  const quizForm = document.getElementById('quizForm');
  const quizModal = new bootstrap.Modal(document.getElementById('quizModal'));
  const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

  document.getElementById('open-add-quiz-modal').addEventListener('click', () => {
    quizForm.reset();
    document.getElementById('quiz-id').value = '';
    document.getElementById('quizModalLabel').textContent = 'Add Quiz';
    quizModal.show();
  });

  document.querySelectorAll('.edit-quiz').forEach(button => {
    button.addEventListener('click', () => {
      const quizId = button.dataset.id;

      fetch(`/dev/corpu2/simapeka/public/quizzes/${quizId}`)
        .then(response => response.json())
        .then(data => {
          document.getElementById('quiz-id').value = data.id;
          document.getElementById('quiz-title').value = data.title;
          document.getElementById('quiz-points').value = data.points;
          document.getElementById('quiz-duration').value = data.duration;
          document.getElementById('quiz-status').value = data.status ? '1' : '0';

          document.getElementById('quizModalLabel').textContent = 'Edit Quiz';
          quizModal.show();
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while fetching quiz data. Please try again.');
        });
    });
  });

  document.querySelectorAll('.delete-quiz').forEach(button => {
    button.addEventListener('click', () => {
      const quizId = button.dataset.id;

      if (confirm('Are you sure you want to delete this quiz?')) {
        fetch(`/dev/corpu2/simapeka/public/quizzes/${quizId}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json'
          }
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              location.reload();
            } else {
              alert(data.message || 'Error deleting quiz');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
          });
      }
    });
  });

  quizForm.addEventListener('submit', e => {
    e.preventDefault();
    const formData = new FormData(quizForm);
    const quizId = formData.get('id');
    const url = quizId ? `/dev/corpu2/simapeka/public/quizzes/${quizId}` : '/dev/corpu2/simapeka/public/quizzes';
    const method = quizId ? 'PUT' : 'POST';

    fetch(url, {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'X-HTTP-Method-Override': method
      }
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          location.reload();
        } else {
          alert(data.message || 'Error saving quiz');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An unexpected error occurred. Please try again.');
      });
  });
});
