<?php

function verificaSenha($login, $senha) {
    $nomes = explode(".", $login);
    $tamanhoSenha = strlen($senha);
    $erro = 0;
    $contNome = "";
    $complexidade = 0;
    $texto = array();

    if ($tamanhoSenha >= 6) {
        foreach ($nomes as $nome) {
            if (strpos($senha, $nome) !== False) {
                $erro++;
            }
            $contNome .= $nome;
        }
        $tamanhoNome = strlen($contNome) - 3;
        if ($erro == 0) {
            for ($i = 0; $i <= ($tamanhoNome); $i++) {
                $temp = substr($contNome, $i, 3);
                if (stripos($senha, $temp) !== False) {
                    $erro++;
                    $texto[] = "+ de 2 caracteres em sequencia do login";
                }
            }
            if ($erro == 0) {
                if (preg_match("/[a-z]/", $senha)) {
                    $texto[] = "contem minusculo";
                    $complexidade++;
                }
                if (preg_match("/[A-Z]/", $senha)) {
                    $texto[] = "contem maiusculo";
                    $complexidade++;
                }
                if (preg_match("/[*!+$%-&]/", $senha)) {
                    $texto[] = "contem simbolos";
                    $complexidade++;
                }
                if (preg_match("/[0-9]/", $senha)) {
                    $texto[] = "contem numeros";
                    $complexidade++;
                }
                if ($complexidade >= 3) {
                    $texto[] = "atende requisitos";
                } else {
                    $texto[] = "senha nao atende requisitos";
                    $erro++;
                }
            }
        }
    } else {
        $erro++;
    }
    if ($erro == 0) {
        return true;
    } else {
        return false;
    }
}