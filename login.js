$('#login-form').on('submit', function(event) {
    event.preventDefault();
    
    let username = $('#username-login').val();
    let password = $('#password-login').val();
    
    if (username === '' || password === '') {
        alert('Both fields are required');
    } else {
        alert('Login successful!');
    }
    // Tambahkan ini di dalam $(document).ready
$('#username-login').on('keyup', function() {
    if($(this).val().length < 3) {
        $(this).css('border-color', 'red');
    } else {
        $(this).css('border-color', '#e1e1e1');
    }
});

$('#password-login').on('keyup', function() {
    if($(this).val().length < 6) {
        $(this).css('border-color', 'red');
    } else {
        $(this).css('border-color', '#e1e1e1');
    }
});
});
