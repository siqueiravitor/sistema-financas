<?php

include '../vendor/autoload.php';
include '../app/config/connMysql.php';

function getUserIP() {
    $client = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote = $_SERVER['REMOTE_ADDR'];

    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }

    return $ip;
}

session_start();

$_SESSION['ip'] = $user_ip = getUserIP();

$user = $_POST["usuario"];
$pass = $_POST["senha"];
$empresa = $_POST["empresa"];
$senha = md5($pass);

if ($user == null || $user == '') {
    $msg = "=) <br>usuário e/ou senha inválidos.";
    header("location:../index?msg=" . $msg);
} else {
    $sql = "select idusuario,email,nome from usuario where login = '$user' and senha = '$senha' and ativo = 's'";
    $query = mysqlI_query($con, $sql);
    $row = mysqli_fetch_array($query);
    mysqlI_close($con);
    if ($row[0] > 0) {
        $_SESSION['empresa'] = 'binare';
        $_SESSION['iduser'] = $row[0];
        $_SESSION['user'] = $user;
        $_SESSION['pass'] = $pass;
        $_SESSION['nome'] = $row[2];
        $_SESSION['email'] = $row[1];
        $_SESSION['temp'] = time();

        header('Location: ../app/permissionamento');
    } else {
        $msg = "Não foi possivel realizar login.";
        header("location: ../index?msg=" . $msg);
    }
}
