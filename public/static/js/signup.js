/**
 * Скрипт регистрации
 */

function bindEventsRegisterForm() {
    $('#lnk-add-field').click(addFieldToForm);
    $('#lnk-saveField').click(addNewInput);

    // удаление динамических полей
    // Т.к Jq 2 то
    $(document).on( "click", "a.lnk-din-field-del", function() {
        // удалим весь контэйнер div
        // Можно через jq получить родительский див но мне кажется получение текущего атрибута быстрее
        var parent = $(this).attr('x-data-parent');
        $('#' + parent).remove();
    }); // вместо $.live(...)

    //Отправка формы
    $('#submit-register-form').click(function() {
        if (validateForm()) {
            // Соберём дополнительную информацию
            var allInput = $('input[type="text"].din-field');
            var additionData = {};
            for (var i = 0; i<= allInput.length-1; i++) {
                additionData[$(allInput[i]).attr('x-data-label')] = $(allInput[i]).val();
            }
            // json закидываем в один input
            $('#inp-fullAdInfo').val(JSON.stringify(additionData));

            // Валидация на клиентской стороне прошла успешно отправляем
            $('#frm-signup').submit();
        }
    });

}


//Добавление поля
function addFieldToForm() {
    var fieldAddForm = $('.inner-form');
    // Показать форму добавления
    fieldAddForm.show();
}
/**
 * Добавление элемента в форму
 * @returns {boolean}
 */
function addNewInput () {
    var fieldName = $('#field-name');
    if (fieldName.val() == '') {
        alert(t('no_field_name'));
        return false;
    }

    var rndVal = getRandomId();
    var adFieldsContainer = $('#additions-fields');
    adFieldsContainer.append('<div class="form-element" id="din-field-' + rndVal + '"></div>');
    $('#din-field-' + rndVal).append('<label for="' + fieldName.val()+ '">'+fieldName.val()+':</label>');
    $('#din-field-' + rndVal).append('<input class="form-field din-field" type="text" name="addition[din-'+ rndVal +']" style="margin-left:4px;" x-data-label="'+ fieldName.val() +'"/>');
    $('#din-field-' + rndVal).append('<span class="ctrl-lnk" style="margin-left: 5px;"><a href="#" onclick="return false;" class="lnk-din-field-del" x-data-parent="din-field-'+ rndVal +'">' +t("del")+ '</a></span>');
    $('#field-name').val('');
    $('.inner-form').hide();
}

/**
 *
 * @returns {string} строка содержащие случайное число до 10000
 */
function getRandomId()
{
    Math.round(10000);
    return (Math.random() * (10000 - 10) - 10).toFixed();
}


function validateForm() {
    // В нормальных условиях я бы использовал плагин JQ.validation
    // А так изобрету веллосипед
    // Статус валидации
    var status = false;

    // Установим все поля

    var email = $('#inp-email');
    var password = $('#inp-password');
    var psw_confirm = $('#inp-psw_confirm');
    var name = $('#inp-name');
    var last_name = $('#inp-last_name');

    // Проверка обязательных полей
    // email
    if (email.val() == '' ||  typeof(email.val()) === 'undefined'){
        $('#err-email').css({display: 'inline-block'}).text(t('required_field'));
        email.addClass('field-error');
        status = false;
    } else {
        // Если второй раз вводит
        email.removeClass('field-error');
        $('#err-email').hide();
        status = true;
    }

    // password
    if (password.val() == '' ||  typeof(password.val()) === 'undefined'){
        $('#err-password').css({display: 'inline-block'}).text(t('required_field'));
        password.addClass('field-error');
        status = false;
    } else {
        password.removeClass('field-error');
        $('#err-password').hide();
        status = true;
    }

    // password confirmation field
    if (psw_confirm.val() == '' ||  typeof(psw_confirm.val()) === 'undefined'){
        $('#err-psw_confirm').css({display: 'inline-block'}).text(t('required_field'));
        psw_confirm.addClass('field-error');
        status = false;
    } else {
        psw_confirm.removeClass('field-error');
        $('#err-psw_confirm').hide();
        status = true;
    }

    // name
    if (name.val() == '' ||  typeof(name.val()) === 'undefined'){
        $('#err-name').css({display: 'inline-block'}).text(t('required_field'));
        name.addClass('field-error');
        status = false;
    } else {
        name.removeClass('field-error');
        $('#err-name').hide();
        status = true;
    }

    // last name
    if (last_name.val() == '' ||  typeof(last_name.val()) === 'undefined'){
        $('#err-last_name').css({display: 'inline-block'}).text(t('required_field'));
        last_name.addClass('field-error');
        status = false;
    } else {
        last_name.removeClass('field-error');
        $('#err-last_name').hide();
        status = true;
    }

    if (status != true) {
        return status;
    }

    // Прочие ошибки

    // valid email
    var reExp = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/igm;
    if (email.val() == '' || !reExp.test(email.val()))
    {
        $('#err-email').css({display: 'inline-block'}).text(t('invalid_email'));
        email.addClass('field-error');
        status = false;
    } else {
        email.removeClass('field-error');
        $('#err-email').hide();
        status = true;
    }

    // password to be confirm
    if (psw_confirm.val() != password.val()) {
        $('#err-psw_confirm').css({display: 'inline-block'}).text(t('not_eq'));
        psw_confirm.addClass('field-error');
        status = false;
    } else {
        psw_confirm.removeClass('field-error');
        $('#err-psw_confirm').hide();
        status = true;
    }

    // запрещенные символы name
    if (/^[0-9a-zA-Z-а-яА-Я]+$/.test(name.val())) {
        name.removeClass('field-error');
        $('#err-name').hide();
        status = true;
    } else {
        $('#err-name').css({display: 'inline-block'}).text(t('err_symp'));
        name.addClass('field-error');
        status = false;
    }

    if (/^[0-9a-zA-Z-а-яА-Я]+$/.test(last_name.val())) {
        last_name.removeClass('field-error');
        $('#err-last_name').hide();
        status = true;
    } else {
        $('#err-last_name').css({display: 'inline-block'}).text(t('err_symp'));
        last_name.addClass('field-error');
        status = false;
    }

    return status;
}
// экспортируем
globalFunc['bindEventsRegisterForm'] = bindEventsRegisterForm;
