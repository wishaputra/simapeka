document.addEventListener('DOMContentLoaded', () => {
    const questionModal = new bootstrap.Modal(document.getElementById('questionModal'));
    const questionForm = document.getElementById('questionForm');
    const typeInput = document.getElementById('type');
    const multipleChoiceFields = document.getElementById('multipleChoiceFields');
    const optionsContainer = document.getElementById('optionsContainer');
    const addOptionButton = document.getElementById('addOptionButton');
    const examId = document.querySelector('input[name="exam_id"]').value;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Handle question type changes
    typeInput.addEventListener('change', function () {
        multipleChoiceFields.style.display = this.value === 'multiple_choice' ? 'block' : 'none';
    });

    // Add option dynamically
    addOptionButton.addEventListener('click', () => {
        const optionId = `option-${Date.now()}`;
        const optionRow = document.createElement('div');
        optionRow.className = 'input-group mb-2';
        optionRow.innerHTML = `
            <input type="text" class="form-control" name="options[]" placeholder="Option text" required>
            <button class="btn btn-danger" type="button" onclick="this.parentElement.remove()">Remove</button>
        `;
        optionsContainer.appendChild(optionRow);
    });

    // Show modal for adding a new question
    document.getElementById('open-add-question-modal').addEventListener('click', () => {
        questionForm.reset();
        document.getElementById('questionId').value = '';
        optionsContainer.innerHTML = '';
        typeInput.dispatchEvent(new Event('change'));
        questionModal.show();
    });

    // Handle Edit Question button click
    document.querySelectorAll('.edit-question').forEach((button) => {
        button.addEventListener('click', (event) => {
            const questionData = event.target.dataset;
            questionForm.reset();

            document.getElementById('questionId').value = questionData.id;
            document.getElementById('questionText').value = questionData.question;
            typeInput.value = questionData.type;
            document.getElementById('points').value = questionData.points;

            typeInput.dispatchEvent(new Event('change'));

            if (questionData.type === 'multiple_choice') {
                const options = JSON.parse(questionData.options || '[]');
                optionsContainer.innerHTML = '';
                options.forEach((option) => {
                    const optionRow = document.createElement('div');
                    optionRow.className = 'input-group mb-2';
                    optionRow.innerHTML = `
                        <input type="text" class="form-control" name="options[]" value="${option}" required>
                        <button class="btn btn-danger" type="button" onclick="this.parentElement.remove()">Remove</button>
                    `;
                    optionsContainer.appendChild(optionRow);
                });
                document.getElementById('correctAnswer').value = questionData.correct;
            }
            questionModal.show();
        });
    });
 
    // Save question (Add/Edit)
    document.getElementById('save-question').addEventListener('click', (e) => {
        e.preventDefault();
        const formData = new FormData(questionForm);
        const questionId = document.getElementById('questionId').value;

        let url = `/dev/corpu2/simapeka/public/exams/${examId}/questions`;
        let method = 'POST';

        if (questionId) {
            url = `/dev/corpu2/simapeka/public/questions/${questionId}`;
            method = 'PUT';
        }

        fetch(url, {
            method,
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
        })
        .then((response) => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`Server responded with ${response.status}: ${text}`);
                });
            }
            return response.json();
        })
        .then((data) => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error saving question');
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('An error occurred while saving the question. Check the console for more details.');
        });
    });

    // Handle Delete Question button click
    document.querySelectorAll('.delete-question').forEach((button) => {
        button.addEventListener('click', (event) => {
            const questionId = event.target.dataset.id;
            if (confirm('Are you sure you want to delete this question?')) {
                fetch(`/dev/corpu2/simapeka/public/questions/${questionId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Error deleting question');
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the question.');
                });
            }
        });
    });
});

