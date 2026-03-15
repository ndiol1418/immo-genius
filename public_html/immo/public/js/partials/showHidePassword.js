$('#showPassword').click(function() {
    $(this).toggleClass('reveal');
    showOrHiddenPassword();
});

function showOrHiddenPassword() {
    var isRevealed = $('#showPassword').hasClass('reveal');
    if(isRevealed) { //Show password
        $('input[type=password]').attr('type', 'text');
        $('#showPassword i').attr('class','fas fa-eye');
    } else { //Hide password
        $('#password').attr('type', 'password');
        $('#password-confirm').attr('type', 'password');
        $('#showPassword i').attr('class','fas fa-eye-slash');
    }
}
