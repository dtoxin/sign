/**
 * Тут буду хранить глобальные функции из других скриптов для вызова после загрузки страницы
 * @type {{}}
 */
var globalFunc = {};

$(document).ready(function() {
    bindingEvents();
});

function bindingEvents() {
    $('#select-lng').on('change', function() {
        changeLocale($(this).val());
    });
}
/**
 * Смена языка
 * @param locale из select
 */
function changeLocale(locale) {
    var currLocale = getCookie('locale');
    if (currLocale != locale) {
        setCookie('locale', locale);
        // перезагрузим страницу
        window.location.reload();
    }
}

/**
 * Получение cookie
 * @param name bvz сookie
 * @returns {string} Значение
 */
function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

/**
 * Установка cookie
 * @param name имя
 * @param value значение
 * @param options опции (secure, expire, path etc)
 */
function setCookie(name, value, options) {
    options = options || {};

    var expires = options.expires;

    if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires*1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }

    value = encodeURIComponent(value);

    var updatedCookie = name + "=" + value;

    for(var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }
    document.cookie = updatedCookie;
}

