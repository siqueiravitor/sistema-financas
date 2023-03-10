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
$password = $_POST["password"];
$pass = md5($password);

if (!$user || !$user){
    $msg = "Preencha todos os campos";
} else {
    echo $sql = "select 
                id,
                email,
                name,
                status
            from user
            where login = '$user' 
            and password = '$pass'";
    $query = mysqlI_query($con, $sql);
    $row = mysqli_fetch_array($query);
    if ($query) {
        mysqlI_close($con);
        if ($row > 0) {
            if ($row[3] == 'a') {
                $_SESSION['empresa'] = 'binare';
                $_SESSION['iduser'] = $row[0];
                $_SESSION['user'] = $user;
                $_SESSION['nome'] = $row[2];
                $_SESSION['email'] = $row[1];
                $_SESSION['timer'] = time();

//                header('Location: ../app/permissionamento.php');
                header('Location: ../app');
            } else {
                $msg = "Usuário inativado.";
            }
        } else {
            $msg = "Não foi possivel realizar login.";
        }
    } else {
        $msg = "Erro ao tentar se conectar";
    }
}
//header("location: ../?msg=" . $msg);
