<?php

include '../../app/config/func.php';
include '../../app/config/connMysql.php';


$novaSenha = md5($_POST['novaSenha']);
$iduser = $_POST['idusuario'];
$token = $_POST['token'];

$update = "update usuario set 
                senha = '{$novaSenha}' 
           where idusuario = {$iduser}";
if (mysqli_query($con, $update)) {
    $sqlToken = "update tokensenha set usado = 's' where token = " . $token;
    mysqli_query($con, $sqlToken);
    mysqli_close($con);
//    $msg = "Senha alterada com sucesso.";
    header("location: ../../index?msg=Senha alterada com sucesso.");
} else {
    mysqli_close($con);
//    $msg = "Falha ao alterar senha.";
    header("location: ../../index?msg=Falha ao alterar senha.");
}


