<?php

include '../../app/config/func.php';
include '../../app/funcao/senhas.php';

$ope = $_GET['ope'];


if ($ope == "nova") {
    $novaSenha = $_GET['novaSenha'];
    if (strlen($novaSenha) >= 8) {
        if (verificaSenha("123", $novaSenha)) {
            $msg = "Senha Forte";
        } else {
            $msg = "Senha Fraca";
        }
    } else {
        $msg = "Tamanho mínimo 8";
    }
}
echo $msg;
