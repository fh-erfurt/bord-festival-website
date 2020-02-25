var errors = [];

function validateInput(inputId, validation) {
    var input = document.getElementById(inputId);
    if (input != null) {
        var errormessage = document.getElementById(inputId + '-error');
        if (input.value) {
            if (validation === 'mail') {
                var mailRegex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if (mailRegex.test(String(input.value).toLowerCase())) {
                    errormessage.style.display = 'none';
                    input.classList.remove("text-validate-red");
                    errors.splice(errors.indexOf(inputId), 1);
                } else {
                    errormessage.style.display = 'block';
                    input.classList.add("text-validate-red");
                    addToErrorArray(inputId);
                }
            } else {
                errormessage.style.display = 'none';
                input.classList.remove("text-validate-red");
                errors.splice(errors.indexOf(inputId), 1);
            }
        } else {
            errormessage.style.display = 'block';
            input.classList.add("text-validate-red");
            addToErrorArray(inputId);
        }
    }
    toggleSubmitButton();
}

function addToErrorArray(inputId) {
    if (!errors.includes(inputId)) {
        errors.push(inputId);
    }
}

function toggleSubmitButton() {
    var submitButton = document.getElementById('buttonSubmit');
    if (errors.length > 0) {
        submitButton.disabled = true;
        submitButton.classList.add('btn-disabled');
        return false;
    } else {
        submitButton.disabled = false;
        submitButton.classList.remove('btn-disabled');
        return true;
    }
}

function validateRegister() {
    validateInput('InputEmail', 'mail');
    validateInput('InputPassword');
    validateInput('InputPassword2');
    validateInput('InputFirstname');
    validateInput('InputLastname');
    validateInput('InputBirthday');
    validateInput('InputStreet');
    validateInput('InputZip');
    validateInput('InputCity');

    var result = toggleSubmitButton();
    return result;
}

function validateLogin() {
    validateInput('InputMail', 'mail');
    validateInput('InputPassword');

    var result = toggleSubmitButton();
    return result;
}

function validateProfile() {
    validateInput('InputMail', 'mail');
    validateInput('InputFirstname');
    validateInput('InputLastname');
    validateInput('InputBirthday');
    validateInput('InputStreet');
    validateInput('InputZip');
    validateInput('InputCity');
    validateInput('InputCountry');

    var result = toggleSubmitButton();
    return result;
}

function validateContact() {
    validateInput('InputMail', 'mail');
    validateInput('InputFirstname');
    validateInput('InputLastname');
    validateInput('InputInformation');
    validateInput('InputProblem');

    var result = toggleSubmitButton();
    return result;
}