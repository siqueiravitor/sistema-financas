<?php
function generateToken($tamanho = 32) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $charactersLength = strlen($characters);

    $token = '';
    for ($i = 0; $i < $tamanho; $i++) {
        $token .= $characters[rand(0, $charactersLength - 1)];
    }
    return $token;
}

function tokenSenha($con){
    $token = generateToken(128);
    $sql = "select 1 from usuariotoken where token = '$token'";
    $query = mysqli_query($con, $sql);
    if(mysqli_num_rows($query) > 0){
        tokenSenha($con);
    } else {
        return $token;
    }
}

