document.addEventListener('DOMContentLoaded', () => {
  const addEditModal = new bootstrap.Modal(document.getElementById('question-modal')); // Bootstrap modal instance
  const questionForm = document.getElementById('question-form');
  const typeInput = document.getElementById('type');
  const optionsContainer = document.getElementById('options-container');
  const correctAnswerContainer = document.getElementById('correct-answer-container');
  const optionsList = document.getElementById('options-list');
  const addOptionButton = document.getElementById('add-option');
  const quizContainer = document.getElementById('quiz-container');
  const quizId = quizContainer.dataset.quizId;
  const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

  // Handle question type changes
  typeInput.addEventListener('change', function () {
    const isMultipleChoice = this.value === 'multiple_choice';

    optionsContainer.style.display = isMultipleChoice ? 'block' : 'none';
    correctAnswerContainer.style.display = isMultipleChoice ? 'block' : 'none';

    if (!isMultipleChoice) {
      optionsList.innerHTML = ''; // Clear options if not multiple choice
    }
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
    optionsList.appendChild(optionRow);
  });

  // Show modal for adding a new question
  document.getElementById('open-add-question-modal').addEventListener('click', () => {
    questionForm.reset();
    questionForm.dataset.id = ''; // Clear the ID for new question
    optionsList.innerHTML = ''; // Clear dynamic options
    typeInput.dispatchEvent(new Event('change')); // Trigger type change for options visibility
    addEditModal.show();
  });

  // Handle Edit Question button click
  document.querySelectorAll('.edit-question').forEach(button => {
    button.addEventListener('click', event => {
      const questionData = event.target.dataset;
      questionForm.reset();

      // Fill form with question data
      questionForm.dataset.id = questionData.id;
      questionForm.querySelector('#question_text').value = questionData.question;
      questionForm.querySelector('#type').value = questionData.type;
      questionForm.querySelector('#points').value = questionData.points;

      typeInput.dispatchEvent(new Event('change')); // Adjust visibility

      // Populate options for multiple choice
      if (questionData.type === 'multiple_choice') {
        const options = JSON.parse(questionData.options || '[]');
        optionsList.innerHTML = '';
        options.forEach(option => {
          const optionRow = document.createElement('div');
          optionRow.className = 'input-group mb-2';
          optionRow.innerHTML = `
                        <input type="text" class="form-control" name="options[]" value="${option}" required>
                        <button class="btn btn-danger" type="button" onclick="this.parentElement.remove()">Remove</button>
                    `;
          optionsList.appendChild(optionRow);
        });
        questionForm.querySelector('#correct_answer').value = questionData.correct || '';
      }
      addEditModal.show();
    });
  });

  // Save question (Add/Edit)
  document.getElementById('save-question').addEventListener('click', () => {
    const formData = new FormData(questionForm);
    const questionId = questionForm.dataset.id;

    // Ensure quiz_id is included in the formData
    formData.append('quiz_id', quizId);

    let url = `/dev/corpu2/simapeka/public/quizzes/${quizId}/questions`;
    let method = 'POST';

    if (questionId) {
      url = `/dev/corpu2/simapeka/public/questions/${questionId}`;
      method = 'PUT';
    }

    // Convert FormData to an object for easier manipulation
    const formDataObject = {};
    formData.forEach((value, key) => {
      if (key === 'options[]') {
        if (!formDataObject.options) formDataObject.options = [];
        formDataObject.options.push(value);
      } else {
        formDataObject[key] = value;
      }
    });

    // Ensure all required fields are present
    if (!formDataObject.question_text || !formDataObject.type || !formDataObject.points) {
      alert('Please fill in all required fields.');
      return;
    }

    // For multiple choice, ensure options are present
    if (formDataObject.type === 'multiple_choice' && (!formDataObject.options || formDataObject.options.length === 0)) {
      alert('Please add at least one option for multiple choice questions.');
      return;
    }

    fetch(url, {
      method,
      body: JSON.stringify(formDataObject),
      headers: {
        'X-CSRF-TOKEN': csrfToken,
        Accept: 'application/json',
        'Content-Type': 'application/json'
      }
    })
      .then(response => {
        if (!response.ok) {
          return response.json().then(err => {
            throw new Error(JSON.stringify(err));
          });
        }
        return response.json();
      })
      .then(data => {
        if (data.success) {
          location.reload();
        } else {
          alert(data.message || 'Error saving question');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        try {
          const errorData = JSON.parse(error.message);
          let errorMessage = 'Validation errors:\n';
          for (let field in errorData.errors) {
            errorMessage += `${field}: ${errorData.errors[field].join(', ')}\n`;
          }
          alert(errorMessage);
        } catch (e) {
          alert('An error occurred while saving the question. Check the console for more details.');
        }
      });
  });

  // Handle Delete Question button click
  document.querySelectorAll('.delete-question').forEach(button => {
    button.addEventListener('click', event => {
      const questionId = event.target.dataset.id;
      if (confirm('Are you sure you want to delete this question?')) {
        fetch(`/dev/corpu2/simapeka/public/questions/${questionId}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': csrfToken
          }
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              location.reload(); // Reload the page on success
            } else {
              alert(data.message || 'Error deleting question');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the question.');
          });
      }
    });
  });
});
