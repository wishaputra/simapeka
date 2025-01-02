document.addEventListener('DOMContentLoaded', function () {

    const lessonModal = new bootstrap.Modal(document.getElementById('lessonModal'));
    const lessonForm = document.getElementById('lessonForm');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const lessonType = document.getElementById('lesson-type');
    const lessonsTable = document.getElementById('lessons-table');
    const contentUrlGroup = document.getElementById('content-url-group');
    const contentFileGroup = document.getElementById('content-file-group');

    // Update form fields dynamically based on lesson type
    lessonType.addEventListener('change', function () {
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
    });

    // Open Add Lesson Modal
    document.getElementById('add-lesson').addEventListener('click', () => {
        lessonForm.reset();
        contentUrlGroup.style.display = 'none';
        contentFileGroup.style.display = 'none';
        document.getElementById('lesson-id').value = '';
        document.getElementById('lessonModalLabel').textContent = 'Add Lesson';
        lessonModal.show();
    });

    // Handle Add/Edit Lesson Submission
    lessonForm.addEventListener('submit', function (e) {
        e.preventDefault();
    
        const lessonId = document.getElementById('lesson-id').value;
        const formData = new FormData(lessonForm);
        const url = lessonId
            ? `/dev/corpu2/simapeka/public/sections/${sectionId}/lessons/${lessonId}`
            : `/dev/corpu2/simapeka/public/sections/${sectionId}/lessons`;
    
        const method = lessonId ? 'PUT' : 'POST';
    
        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            body: formData,
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
    

    // Populate Edit Form
    document.querySelectorAll('.edit-lesson').forEach(button => {
        button.addEventListener('click', function () {
            const lessonData = JSON.parse(this.dataset.lesson || '{}'); // Fallback to empty object
            
            if (lessonData.id) {
                document.getElementById('lesson-id').value = lessonData.id; // Set ID for PUT
            } else {
                document.getElementById('lesson-id').value = ''; // Ensure no ID for POST
            }
    
            document.getElementById('lesson-id').value = lessonData.id;
            document.getElementById('lesson-title').value = lessonData.title;
            document.getElementById('lesson-type').value = lessonData.type;
            document.getElementById('lesson-duration').value = lessonData.duration;
            document.getElementById('lesson-order').value = lessonData.order;
    
            // Set content input fields
            if (lessonData.type === 'video') {
                contentUrlGroup.style.display = 'block';
                contentFileGroup.style.display = 'block';
                document.getElementById('lesson-content-url').value = lessonData.content || ''; // Set video URL if available
            } else if (lessonData.type === 'pdf') {
                contentUrlGroup.style.display = 'none';
                contentFileGroup.style.display = 'block';
            }
    
            document.getElementById('lessonModalLabel').textContent = 'Edit Lesson';
            lessonModal.show();
        });
    });
    
    
    // Delete Lesson
        lessonsTable.addEventListener('click', function (e) {
            if (e.target.classList.contains('delete-lesson')) {
                const lessonId = e.target.dataset.id; // Fetch lessonId from data-id attribute
                const url = `/dev/corpu2/simapeka/public/sections/${sectionId}/lessons/${lessonId}`;
                
                if (lessonId && confirm('Are you sure you want to delete this lesson?')) {
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                        },
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
                } else {
                    alert('Lesson ID is missing or invalid.');
                }
            }
        });

 
    // Edit Lesson
    lessonsTable.addEventListener('click', function (e) {
        if (e.target.classList.contains('edit-lesson')) {
            const lessonId = e.target.dataset.id;
    
            if (!lessonId) {
                console.error("Lesson ID is missing.");
                return;
            }
    
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
    
                        if (lesson.type === 'video') {
                            lessonType.value = 'video';
                            contentUrlGroup.style.display = 'block';
                            contentFileGroup.style.display = 'block';
                            document.getElementById('lesson-content-url').value = lesson.content;
                        } else if (lesson.type === 'pdf') {
                            lessonType.value = 'pdf';
                            contentUrlGroup.style.display = 'none';
                            contentFileGroup.style.display = 'block';
                        }
    
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
        }
    });
    
 });
