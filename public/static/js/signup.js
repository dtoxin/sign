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

    //submit-register-form
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
    $('#din-field-' + rndVal).append('<input class="form-field din-field" type="text" name="last_name" style="margin-left:4px;" x-data-label="'+ fieldName.val() +'"/>');
    $('#din-field-' + rndVal).append('<span class="ctrl-lnk" style="margin-left: 5px;"><a href="#" onclick="return false;" class="lnk-din-field-del" x-data-parent="din-field-'+ rndVal +'">' +t("del")+ '</a></span>');
    $('#field-name').val('');
    $('.inner-form').hide();
}

function getRandomId()
{
    Math.round(10000);
    return (Math.random() * (10000 - 10) - 10).toFixed();
}

// экспортируем
globalFunc['bindEventsRegisterForm'] = bindEventsRegisterForm;
