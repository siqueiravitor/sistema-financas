<?php

include '../vendor/autoload.php';
include './connMysql.php';

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

$user = $_POST["user"];
$password = md5($_POST["password"]);

if (!$user || !$password){
    $msg = "Preencha todos os campos";
} else {
    $sql = "select 
                id,
                nome,
                email,
                status
            from usuario
            where login = '$user' 
            and senha = '$password'";
    $query = mysqlI_query($con, $sql);
    $row = mysqli_fetch_array($query);
    if ($query) {
        
        if ($row > 0) {
            if ($row[3] == 'a') {
                $_SESSION['empresa'] = 'SyntaxWeb';
                $_SESSION['id'] = $row[0];
                $_SESSION['user'] = $user;
                $_SESSION['name'] = $row[1];
                $_SESSION['email'] = $row[2];
                $_SESSION['timer'] = time();

                mysqlI_close($con);
                header('Location: ../app');
                return;
            } else {
                $msg = "Usuário inválido";
            }
        } else {
            $msg = "Não foi possivel realizar login.";
        }
    } else {
        $msg = "Erro ao tentar se conectar";
    }
}
mysqlI_close($con);
header("location: ../?msg=" . $msg);