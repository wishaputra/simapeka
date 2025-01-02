document.addEventListener('DOMContentLoaded', function () {
  const examData = JSON.parse(document.getElementById('examData').dataset.questions);
  const passingScore = parseInt(document.getElementById('examData').dataset.passingScore);
  const examId = document.getElementById('examData').dataset.examId;

  // Question navigation
  document.querySelectorAll('.question-nav').forEach(button => {
    button.addEventListener('click', function () {
      document.querySelectorAll('.question').forEach(q => (q.style.display = 'none'));
      const target = this.getAttribute('data-target');
      document.getElementById(target).style.display = 'block';
    });
  });

  // Submit exam
  document.getElementById('submitExam').addEventListener('click', function () {
    let userScore = 0;
    let totalPoints = 0;

    examData.forEach(question => {
      totalPoints += question.points;
      const userAnswer =
        document.querySelector(`[name="answer${question.id}"]:checked`)?.value ||
        document.getElementById(`answer${question.id}`)?.value;

      if (userAnswer && userAnswer.trim().toLowerCase() === question.correct_answer.trim().toLowerCase()) {
        userScore += question.points;
      }
    });

    const percentageScore = (userScore / totalPoints) * 100;
    const passed = percentageScore >= passingScore;

    // Display results
    document.getElementById('userScore').textContent = `${percentageScore.toFixed(2)}%`;
    document.getElementById('passingScore').textContent = `${passingScore}%`;
    document.getElementById('resultMessage').textContent = passed
      ? 'Congratulations! You passed the exam.'
      : 'Sorry, you did not pass the exam. Please try again.';

    document.getElementById('restartExam').style.display = passed ? 'none' : 'inline-block';

    // Show modal
    new bootstrap.Modal(document.getElementById('resultModal')).show();

    // Update progress if passed
    if (passed) {
      updateExamProgress(examId);
    }
  });

  // Restart exam
  document.getElementById('restartExam').addEventListener('click', function () {
    location.reload();
  });

  function updateExamProgress(examId) {
    fetch('/dev/corpu2/simapeka/public/exam-progress', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({ exam_id: examId })
    })
      .then(response => response.json())
      .then(data => {
        console.log('Exam progress updated:', data);
      })
      .catch(error => {
        console.error('Error updating exam progress:', error);
      });
  }
});
