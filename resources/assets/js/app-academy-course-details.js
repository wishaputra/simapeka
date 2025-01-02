document.addEventListener('DOMContentLoaded', function () {
  const lessonSelectors = document.querySelectorAll('.lesson-selector');
  const quizSelectors = document.querySelectorAll('.quiz-selector');
  const contentContainer = document.getElementById('lesson-content');
  const courseId = document.querySelector('input[name="course_id"]').value;
  const startExamBtn = document.getElementById('startExamBtn');
  const examRequirementMsg = document.getElementById('examRequirementMsg');

  let currentQuestionIndex = 0;
  let questionsData = [];
  let userAnswers = [];
  let currentQuizId = null;

  const loadLessonContent = selector => {
    const type = selector.dataset.type;
    let content = selector.dataset.content;

    if (type === 'video') {
      if (content.includes('youtube.com/watch')) {
        content = content.replace('watch?v=', 'embed/');
      }
      contentContainer.innerHTML = `
        <iframe
          class="w-100"
          src="${content}"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen
          style="height: 500px;">
        </iframe>
      `;
    } else if (type === 'pdf') {
      contentContainer.innerHTML = `
        <iframe class="w-100" src="${content}" frameborder="0" style="height: 500px;"></iframe>
      `;
    } else {
      contentContainer.innerHTML = `<p>No content available for this lesson.</p>`;
    }
  };

  const displayQuestion = () => {
    if (questionsData.length > 0) {
      const question = questionsData[currentQuestionIndex];
      const isLastQuestion = currentQuestionIndex === questionsData.length - 1;

      let questionContent = `
        <h4>${question.quiz_title}</h4>
        <div class="mb-4">
          <p><strong>${question.question_text}</strong></p>
          ${
            question.type === 'multiple_choice'
              ? question.options
                  .map(
                    (option, index) =>
                      `<div>
                        <input type="radio" id="q${question.id}-o${index}" name="q${question.id}" value="${option}">
                        <label for="q${question.id}-o${index}">${option}</label>
                      </div>`
                  )
                  .join('')
              : `<textarea class="form-control" placeholder="Write your answer here"></textarea>`
          }
        </div>
        <div id="feedback" class="mb-3"></div>
        <div class="d-flex justify-content-between">
          <button id="prev-button" class="btn btn-secondary ${currentQuestionIndex === 0 ? 'd-none' : ''}">Previous</button>
          <button id="check-answer" class="btn btn-primary">Check Answer</button>
          <button id="next-button" class="btn btn-primary d-none">${isLastQuestion ? 'Finish Quiz' : 'Next'}</button>
        </div>
      `;

      contentContainer.innerHTML = questionContent;

      document.getElementById('prev-button')?.addEventListener('click', () => {
        currentQuestionIndex--;
        displayQuestion();
      });

      document.getElementById('check-answer')?.addEventListener('click', () => {
        checkAnswer(question);
      });

      document.getElementById('next-button')?.addEventListener('click', () => {
        if (isLastQuestion) {
          finishQuiz();
        } else {
          currentQuestionIndex++;
          displayQuestion();
        }
      });
    } else {
      contentContainer.innerHTML = `<p>No questions available for this quiz.</p>`;
    }
  };

  const checkAnswer = question => {
    const feedbackElement = document.getElementById('feedback');
    const nextButton = document.getElementById('next-button');
    const checkAnswerButton = document.getElementById('check-answer');
    let userAnswer;

    if (question.type === 'multiple_choice') {
      const selectedOption = document.querySelector(`input[name="q${question.id}"]:checked`);
      if (!selectedOption) {
        feedbackElement.innerHTML = '<p class="text-warning">Please select an answer.</p>';
        return;
      }
      userAnswer = selectedOption.value;
    } else {
      const textAnswer = document.querySelector('textarea').value.trim();
      if (!textAnswer) {
        feedbackElement.innerHTML = '<p class="text-warning">Please enter your answer.</p>';
        return;
      }
      userAnswer = textAnswer;
    }

    if (userAnswer === question.correct_answer) {
      feedbackElement.innerHTML = '<p class="text-success">Correct! You can move to the next question.</p>';
      nextButton.classList.remove('d-none');
      checkAnswerButton.classList.add('d-none');
      userAnswers[currentQuestionIndex] = true;
    } else {
      feedbackElement.innerHTML = '<p class="text-danger">Incorrect. Please try again.</p>';
      userAnswers[currentQuestionIndex] = false;
    }
  };

  const loadQuizQuestions = quizId => {
    currentQuizId = quizId;
    fetch(`/dev/corpu2/simapeka/public/quiz/${quizId}/questions`)
      .then(response => response.json())
      .then(questions => {
        if (questions.length > 0) {
          questionsData = questions;
          userAnswers = new Array(questions.length).fill(false);
          currentQuestionIndex = 0;
          displayQuestion();
        } else {
          contentContainer.innerHTML = `<p>No questions available for this quiz.</p>`;
        }
      })
      .catch(error => {
        console.error('Error fetching quiz questions:', error);
        contentContainer.innerHTML = `<p>Failed to load quiz questions. Please try again later.</p>`;
      });
  };

  const updateLessonProgress = lessonId => {
    fetch('/dev/corpu2/simapeka/public/lesson/progress', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({ lesson_id: lessonId, course_id: courseId })
    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Failed to update lesson progress');
        }
        return response.json();
      })
      .then(data => {
        console.log(data.message);
      })
      .catch(error => {
        console.error('Error:', error);
      });
  };

  const finishQuiz = () => {
    if (userAnswers.every(answer => answer === true)) {
      updateQuizProgress(currentQuizId);
    } else {
      alert('Please answer all questions correctly before finishing the quiz.');
      const firstIncorrectIndex = userAnswers.findIndex(answer => answer === false);
      if (firstIncorrectIndex !== -1) {
        currentQuestionIndex = firstIncorrectIndex;
        displayQuestion();
      }
    }
  };

  const updateQuizProgress = quizId => {
    fetch('/dev/corpu2/simapeka/public/quiz/progress', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({ quiz_id: quizId, course_id: courseId })
    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Failed to update quiz progress');
        }
        return response.json();
      })
      .then(data => {
        console.log(data.message);
        contentContainer.innerHTML = `<p>Quiz completed successfully!</p>`;
        const quizSelector = document.querySelector(`.quiz-selector[data-id="${quizId}"]`);
        if (quizSelector) {
          quizSelector.checked = true;
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
  };

  // Load the first checked lesson or quiz on page load
  const loadInitialContent = () => {
    const firstCheckedLesson = Array.from(lessonSelectors).find(selector => selector.checked);
    const firstCheckedQuiz = Array.from(quizSelectors).find(selector => selector.checked);

    if (firstCheckedLesson) {
      loadLessonContent(firstCheckedLesson);
    } else if (firstCheckedQuiz) {
      loadQuizQuestions(firstCheckedQuiz.dataset.id);
    } else if (lessonSelectors.length > 0) {
      // If nothing is checked, select the first lesson
      lessonSelectors[0].checked = true;
      loadLessonContent(lessonSelectors[0]);
    }
  };

  // Fetch initial progress and update UI
  const fetchAndUpdateProgress = () => {
    fetch(`/dev/corpu2/simapeka/public/course/${courseId}/progress`)
      .then(response => response.json())
      .then(data => {
        if (data.lesson_progress) {
          data.lesson_progress.forEach(lessonId => {
            const selector = document.querySelector(`.lesson-selector[data-id="${lessonId}"]`);
            if (selector) {
              selector.checked = true;
            }
          });
        }
        if (data.quiz_progress) {
          data.quiz_progress.forEach(quizId => {
            const selector = document.querySelector(`.quiz-selector[data-id="${quizId}"]`);
            if (selector) {
              selector.checked = true;
            }
          });
        }
      })
      .catch(error => console.error('Error fetching progress:', error));
  };

  function checkExamEligibility() {
    const allLessonsCompleted = Array.from(lessonSelectors).every(selector => selector.checked);
    const allQuizzesCompleted = Array.from(quizSelectors).every(selector => selector.checked);

    if (allLessonsCompleted && allQuizzesCompleted) {
      startExamBtn.disabled = false;
      examRequirementMsg.style.display = 'none';
    } else {
      startExamBtn.disabled = true;
      examRequirementMsg.style.display = 'block';
    }
  }
  // Check exam eligibility on page load
  checkExamEligibility();
  fetchAndUpdateProgress();
  loadInitialContent();

  // Add event listeners for lessons
  lessonSelectors.forEach(selector => {
    selector.addEventListener('change', checkExamEligibility);
    selector.addEventListener('change', function () {
      if (this.checked) {
        loadLessonContent(this);
        updateLessonProgress(this.dataset.id);
      }
    });
  });

  // Add event listeners for quizzes
  quizSelectors.forEach(selector => {
    selector.addEventListener('change', checkExamEligibility);
    selector.addEventListener('change', function () {
      if (this.checked) {
        loadQuizQuestions(this.dataset.id);
      }
    });

    // Add click event listener to the start exam button
    startExamBtn.addEventListener('click', function (e) {
      e.preventDefault();
      if (!this.disabled) {
        const examId = this.dataset.examId;
        window.location.href = `/dev/corpu2/simapeka/public/final-exam/${examId}`;
      }
    });
  });
});
