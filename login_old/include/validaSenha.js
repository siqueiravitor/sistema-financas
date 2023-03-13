function validaSenha() {
    let senha, alert, msg;
    senha = document.getElementById("senha");
    alert = document.getElementById("msgAlert");
    senha.classList.add('alertError');
    alert.classList.remove('alertSuccess');

    if (senha.value.length >= 8) {
        if (validaCaracteres(senha.value)) {
            msg = "<span>Senha Válida</span>";
            alert.classList.add('alertSuccess');
            senha.classList.remove('alertError');
            alert.innerHTML = msg;
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

function validaCaracteres(s) {
    var retorno = false;
    var letrasMaiusculas = /[A-Z]/;
    var letrasMinusculas = /[a-z]/;
    var numeros = /[0-9]/;
    var caracteresEspeciais = /[!|@|#|$|%|^|&|*|(|)|-|_]/;

    var auxMaiuscula = 0;
    var auxMinuscula = 0;
    var auxNumero = 0;
    var auxEspecial = 0;

    for (var i = 0; i < s.length; i++) {
        if (letrasMaiusculas.test(s[i]))
            auxMaiuscula++;
        else if (letrasMinusculas.test(s[i]))
            auxMinuscula++;
        else if (numeros.test(s[i]))
            auxNumero++;
        else if (caracteresEspeciais.test(s[i]))
            auxEspecial++;
    }
    if (auxMaiuscula > 0) {
        if (auxMinuscula > 0) {
            if (auxNumero > 0) {
                if (auxEspecial) {
                    retorno = true;
                }
            }
        }
    }
    return retorno;
}
function validaRepetirSenha() {
    let repetirSenha, senha, alert, form, msg = "";
    form = document.getElementById("formAlteraSenha");
    senha = document.getElementById("senha");
    alert = document.getElementById("msgAlert");
    repetirSenha = document.getElementById("repetirSenha");

    if (validaSenha()) {
        form.setAttribute('onsubmit', 'event.preventDefault()');
        if (senha.value !== repetirSenha.value) {
            alert.classList.remove('alertSuccess');
            msg = "<span>Senhas não conferem</span>";
        } else {
            form.removeAttribute('onsubmit');
        }
        alert.innerHTML = msg;
    }
}