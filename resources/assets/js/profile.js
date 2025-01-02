function togglePassword() {
    var passwordFields = ['password', 'password_baru', 'konfirmasi_password'];
    passwordFields.forEach(function(fieldId) {
        var field = document.getElementById(fieldId);
        field.type = field.type === 'password' ? 'text' : 'password';
    });
}

$(document).ready(function() {
    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
});