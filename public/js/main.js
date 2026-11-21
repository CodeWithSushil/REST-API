$(document).ready(function () {

    // Show / Hide Password
    $(document).on('click', '.toggle-password', function () {

        let target = $(this).data('target');
        let input = $('#' + target);

        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            $(this).text('<i class="bi bi-eye"></i>');
        } else {
            input.attr('type', 'password');
            $(this).text('<i class="bi bi-eye-slash"></i>');
        }

    });


    // Password Validation
    function validatePassword(password) {

        let minLength = password.length >= 8;
        let uppercase = /[A-Z]/.test(password);
        let lowercase = /[a-z]/.test(password);
        let number = /[0-9]/.test(password);
        let special = /[^A-Za-z0-9]/.test(password);

        return minLength && uppercase && lowercase && number && special;
    }


    // Register Password Match Validation
    $('#confirm_password, #password').on('keyup input', function () {

        let password = $('#password').val();
        let confirmPassword = $('#confirm_password').val();

        if (confirmPassword === '') {
            $('#passwordMatchMessage')
                .text('')
                .removeClass('text-success text-danger');
        }
        else if (password === confirmPassword) {
            $('#passwordMatchMessage')
                .text('✓ Password matched')
                .removeClass('text-danger')
                .addClass('text-success');
        }
        else {
            $('#passwordMatchMessage')
                .text('✗ Password does not match')
                .removeClass('text-success')
                .addClass('text-danger');
        }

    });


    // Register Form Validation
    $('#registerForm').on('submit', function (e) {

        let password = $('#password').val();
        let confirmPassword = $('#confirm_password').val();

        if (!validatePassword(password)) {

            e.preventDefault();

            alert(
                'Password must contain:\n' +
                '- Minimum 8 characters\n' +
                '- At least 1 uppercase letter\n' +
                '- At least 1 lowercase letter\n' +
                '- At least 1 number\n' +
                '- At least 1 special character'
            );

            return false;
        }

        if (password !== confirmPassword) {

            e.preventDefault();

            alert('Password and Confirm Password do not match!');

            return false;
        }

    });

});
