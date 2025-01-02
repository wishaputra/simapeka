// resources/assets/js/kehadiran.js
document.querySelectorAll('.attendance-day button').forEach(button => {
    button.addEventListener('click', function() {
        let form = this.closest('form');
        let date = form.querySelector('input[name="tanggal_hadir"]').value;
        
        // Handle AJAX form submission
        fetch(form.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                course_id: form.querySelector('input[name="course_id"]').value,
                nip: form.querySelector('input[name="nip"]').value,
                tanggal_hadir: date
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                button.classList.add('btn-success');
                button.innerText = 'Present';
                button.disabled = true;
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
