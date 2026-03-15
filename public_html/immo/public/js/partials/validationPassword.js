$(function() {
    $("#password").on('change keyup', function(e) {
        var sanitizePassword = $(this).val().trim();
        $(this).val(sanitizePassword);
        let tested = isTestedRegex(sanitizePassword);

        if(tested) {
            isValidStatus("password");
        } else {
            isInValidStatus("password");
        }
        isConfirmed();
    });

    $("#password-confirm").on('change keyup', function(e) {
        isConfirmed();
    });

    function isValidStatus(ref) {
        if($('#'+ref).hasClass('is-invalid')) $('#'+ref).removeClass('is-invalid');

        if(!$('#'+ref).hasClass('is-valid')) {
            $('#'+ref).addClass('is-valid');
        }
    }

    function isInValidStatus(ref) {
        if($('#'+ref).hasClass('is-valid')) $('#'+ref).removeClass('is-valid');

        if(!$('#'+ref).hasClass('is-invalid')) {
            $('#'+ref).addClass('is-invalid');
        }
    }

    function isConfirmed() {
        var confirmed = $('#password-confirm').val();
        var password = $('#password').val();

        //Btn
        formIsValid();

        if(!confirmed || confirmed.trim() == '') {
            return false;
        }
        if(confirmed === password && isTestedRegex(confirmed)) {
            isValidStatus("password-confirm");
        } else {
            isInValidStatus("password-confirm");
        }
    }

    //Bouton reset Page
    function formIsValid() {
        var confirmed = $('#password-confirm').val();
        var password = $('#password').val();
        if($('#reset-btn').html()) {
        if(confirmed === password && isTestedRegex(confirmed)) {
                $('#reset-btn').prop("disabled", false);
            } else {
                $('#reset-btn').prop("disabled", true);
            }
        }
    }

    function isTestedRegex(password) {
        return /^(?=.*\d)(?=.*[a-z])(?=.*[@#$%^&+=_!?,;-])(?=.*[A-Z])[0-9a-zA-Z!@#\$%\^\&*\)\(@#$%^&+=_!?,;-]{8,}$/.test(password);
    }
});
