function title(data) {
    if (data.length == 0) {
        return true;
    } else if (data.match(/^[ąćęłńóśźżĄĆĘŁŃÓŚŻŹÄäÖöÜüß.A-Za-z-/./\s]+$/) && data.length > 2 && data.length < 50) {
        return true;
    }
}

function forname(data) {
    if (data.match(/^[ąćęłńóśźżĄĆĘŁŃÓŚŻŹÄäÖöÜüßA-Za-z-/./\s]+$/) && data.length > 2 && data.length < 50) {
        return true;
    }
}

function surname(data) {
    if (data.match(/^[ąćęłńóśźżĄĆĘŁŃÓŚŻŹÄäÖöÜüßA-Za-z-/./\s]+$/) && data.length > 2 && data.length < 50) {
        return true;
    }
}

function phone(data) {
    if (data.length === 0) {
        return true;
    } else {
        if (data.match(/^(?:[+\d].*\d|\d)$/) && data.length > 7 && data.length < 21) {
            return true;
        }
    }
}

function opportunity_phone(data) {
    if (data.match(/^(?:[+\d].*\d|\d)$/) && data.length > 7 && data.length < 21) {
        return true;
    }
}

function companyId(data) {
    if (data.match(/^[0-9]+$/)) {
        return true;
    }
}

function lettersAndNumbers(data) {
    if (data.match(/^[ąćęłńóśźżĄĆĘŁŃÓŚŻŹÄäÖöÜüßA-Za-z0-9-/./\s]+$/) && data.length > 2 && data.length < 50) {
        return true;
    }
}

function organizationName(data) {
    if (data.length > 2 && data.length < 50) {
        return true;
    }
}

function email(data) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(data).toLowerCase());
}

function password(data) {
    if (data.length > 7 && data.length < 19) {
        return true;
    }
}

function passwordsMatch(password, password_repeat) {
    if (password == password_repeat) {
        return true;
    }
}

function password2(data) {
    if (data.length === 0) {
        return true;
    } else {
        if (data.length > 7 && data.length < 19) {
            return true;
        }
    }
}

function passwordsMatch2(password, password_repeat) {
    if (password.length === 0) {
        return true;
    } else {
        if (password == password_repeat) {
            return true;
        }
    }
}

function skills(data) {
    if (data.length > 7 && data.length < 19) {
        return true;
    }
}

function loadStep(item) {
    item.closest('.section').hide();
    item.closest('.section').next().show();

    var prev = item.closest('.register').find('.row.steps .step-point.active');
    item.closest('.register').find('.row.steps .step-point.active').next().next().addClass('active');
    prev.removeClass('active');
    window.scrollTo(0, 0);
}

function inputColorError(item) {
    item.css('border-color', 'red');
}

function clearErrors() {
    $('input, textarea').each(function () {
        $(this).css('border-color', '#adb5bd');
    });
    $('.error-box').hide();
}

function showError(item) {
    item.next().show();
}

function showError2(item) {
    item.closest('.text').find('.error-box').show();
}

function maxChars(item, max) {

    var chars = item.length;
    if (chars > max) {
        return false;
    } else {
        return true;
    }
}

function cannotBeEmpty(item) {
    if (item === "") {
        return false
    } else {
        return true;
    }
}

function validURL(item) {
    var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
        '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
        '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
    return !!pattern.test(item);
}