function verifyCharacters(s) {
    var returnBool = false;
    var ucLetter = /[A-Z]/;
    var lcLetter = /[a-z]/;
    var nums = /[0-9]/;
    var especialChars = /[!|@|#|$|%|^|&|*|(|)|-|_]/;

    var auxUpperCase = 0;
    var auxLowerCase = 0;
    var auxNumbers = 0;
    var auxEspecial = 0;

    for (var i = 0; i < s.length; i++) {
        if (ucLetter.test(s[i]))
            auxUpperCase++;
        else if (lcLetter.test(s[i]))
            auxLowerCase++;
        else if (nums.test(s[i]))
            auxNumbers++;
        else if (especialChars.test(s[i]))
            auxEspecial++;
    }
    if (auxUpperCase > 0) {
        if (auxLowerCase > 0) {
            if (auxNumbers > 0) {
                if (auxEspecial) {
                    returnBool = true;
                }
            }
        }
    }
    return returnBool;
}

function verifyPassword() {
    let repeatPassword, password, alert, form, msg;
    form = document.getElementById("formSignUp");
    password = document.getElementById("password");
    alert = document.getElementById("msgAlert");
    repeatPassword = document.getElementById("repeatPassword");
    alert.classList.remove('alertSuccess');
    password.classList.add('alertError');
    form.setAttribute('onsubmit', 'event.preventDefault()');

    if (password.value.length >= 8) {
        if (verifyCharacters(password.value)) {
            msg = "<span>Senha Válida</span>";
            alert.classList.add('alertSuccess');
            password.classList.remove('alertError');
            alert.innerHTML = msg;
            if(repeatPassword && password === repeatPassword){
                form.removeAttribute('onsubmit');
            }
            return true;
        } else {
            msg = "A senha precisa conter:<br><ul class='text-left'>";
            msg += "<li>Letra maiúscula</li>";
            msg += "<li>Letra minuscula</li>";
            msg += "<li>Número</li>";
            msg += "<li>Caracter especial</li>";
            msg += "</ul>";
        }
    } else {
        msg = "<span>Tamanho mínimo 8</span>";
    }
    alert.innerHTML = msg;
    return false;
}

function verifyRepeatPassword() {
    let repeatPassword, password, alert, form, msg = "";
    form = document.getElementById("formSignUp");
    password = document.getElementById("password");
    alert = document.getElementById("msgAlert");
    repeatPassword = document.getElementById("repeatPassword");

    form.setAttribute('onsubmit', 'event.preventDefault()');
    if (verifyPassword()) {
        if (password.value !== repeatPassword.value) {
            alert.classList.remove('alertSuccess');
            msg = "<span>Senhas não conferem</span>";
        } else {
            form.removeAttribute('onsubmit');
        }
        alert.innerHTML = msg;
    }
}