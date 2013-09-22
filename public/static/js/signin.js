/*
    Скрипт страницы входа
 */

/**
 * Отправка формы
 */
function bindEventsLoginForm() {
    $('#submit-login-form').click(function() {
        var email = $('#inp-email');
        var password = $('#inp-password');
        // Проверка на заполнение
        if (email.val() == '' ||  typeof(email.val()) === 'undefined'){
            $('#err-email').css({display: 'inline-block'}).text(t('required_field'));
            email.addClass('field-error');
            return 0;
        } else {
            email.removeClass('field-error');
            $('#err-email').hide();
        }
        //Проверка на валидный email
        var reExp = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/igm;
        if (email.val() == '' || !reExp.test(email.val()))
        {
            $('#err-email').css({display: 'inline-block'}).text(t('invalid_email'));
            email.addClass('field-error');
            return false;
        } else {
            email.removeClass('field-error');
            $('#err-email').hide();
        }
        //Заполнение пароля
        if (password.val() == '' ||  typeof(password.val()) === 'undefined'){
            $('#err-password').css({display: 'inline-block'}).text(t('required_field'));
            email.addClass('field-error');
            return 0;
        } else {
            password.removeClass('field-error');
            $('#err-password').hide();
        }

        $.ajax({
            type: 'post',
            dataType: 'json',
            data: {email: email.val(), psw: password.val()},
            url: '/users/jxSignin',
            success: function (data) {
                if (data.stat == 1) {
                    alert('we are sign!');
                }
            }
        });

    });
}


globalFunc['submitLoginForm'] = bindEventsLoginForm;
