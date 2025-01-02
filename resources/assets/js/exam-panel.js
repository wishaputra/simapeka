document.addEventListener('DOMContentLoaded', function () {
    // Select elements
    const addExamForm = document.getElementById('addExamForm');
    const editExamForm = document.getElementById('editExamForm');
    const editExamModal = new bootstrap.Modal(document.getElementById('editExamModal'));
    const deleteExamButtons = document.querySelectorAll('.deleteExamBtn');
    const editExamButtons = document.querySelectorAll('.editExamBtn');
    

    // CSRF Token for AJAX requests
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Handle Add Exam Form Submission
    if (addExamForm) {
        addExamForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(addExamForm);

            fetch(addExamForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload(); // Reload the page to update the table
                    } else {
                        alert('Failed to add exam: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error adding exam:', error);
                    alert('An error occurred while adding the exam.');
                });
        });
    }

    // Handle Edit Exam Button Click
    editExamButtons.forEach(button => {
        button.addEventListener('click', function () {
            const examId = this.dataset.id;
            const title = this.dataset.title;
            const passingScore = this.dataset.passing_score;
            const duration = this.dataset.duration;
            const maxAttempts = this.dataset.max_attempts;

            // Populate the edit form
            editExamForm.querySelector('#editExamId').value = examId;
            editExamForm.querySelector('#editExamTitle').value = title;
            editExamForm.querySelector('#editPassingScore').value = passingScore;
            editExamForm.querySelector('#editDuration').value = duration;
            editExamForm.querySelector('#editMaxAttempts').value = maxAttempts;

            // Show the modal
            editExamModal.show();
        });
    });

    // Handle Edit Exam Form Submission

    
    if (editExamForm) {
        editExamForm.addEventListener('submit', function (e) {
            e.preventDefault();
    
            const examId = editExamForm.querySelector('#editExamId').value;
            const courseId = document.getElementById('courseId').value; // Assuming you have a hidden input with course ID
            const formData = new FormData(editExamForm);
    
            fetch(`/dev/corpu2/simapeka/public/courses/${courseId}/exams/${examId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-HTTP-Method-Override': 'PUT'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.location.reload(); // Reload the page to update the table
                } else {
                    alert('Failed to edit exam: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error editing exam:', error);
                alert('An error occurred while editing the exam. Please try again.');
            });
        });
    }

    // Handle Delete Exam
    deleteExamButtons.forEach(button => {
        button.addEventListener('click', function () {
            const examId = this.dataset.id;

            if (confirm('Are you sure you want to delete this exam?')) {
                fetch(`/dev/corpu2/simapeka/public/exams/${examId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload(); // Reload the page to update the table
                        } else {
                            alert('Failed to delete exam: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting exam:', error);
                        alert('An error occurred while deleting the exam.');
                    });
            }
        });
    });
});
