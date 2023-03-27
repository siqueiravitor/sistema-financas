<?php

include '../vendor/autoload.php';
include './connMysql.php';
include './functions.php';

session_start();
$_SESSION['ip'] = $user_ip = getUserIP();

$user = mysqli_escape_string($con, $_POST['user']);
$password = md5(mysqli_escape_string($con, $_POST['password']));

if (!$user || !$password) {
    $msg = "Preencha todos os campos";
} else {
    if ($data = verifyUser($user, $password)) {
        if ($data[0] > 0) {
            if ($data[1][3] == 'a') {
                $userData = $data[1];
                $_SESSION['empresa'] = 'SyntaxWeb';
                $_SESSION['id'] = $userData[0];
                $_SESSION['user'] = $user;
                $_SESSION['name'] = $userData[1];
                $_SESSION['email'] = $userData  [2];
                $_SESSION['timer'] = time();

                mysqli_close($con);
                exit(header('Location: ../app/permission.php'));
            } else {
                // criar casos de uso para cada status diferente de 'a';
                $msg = "Usuário inválido";
            }
        } else {
            $msg = "Não foi possivel realizar login.";
        }
    } else {
        $msg = "Erro ao tentar se conectar";
    }
}
mysqli_close($con);
header("location: ../?msg=" . $msg);