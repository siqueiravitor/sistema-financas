<?php

// include '../vendor/autoload.php';
include './connMysql.php';
include './functions.php';

session_start();
$_SESSION['ip'] = $user_ip = getUserIP();

$user = mysqli_escape_string($con, $_POST['user']);
$password = mysqli_escape_string($con, $_POST['password']);

// $user = filter_var($_POST['user'], FILTER_SANITIZE_STRING);
// $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
// if(password_verify($password, SENHA DO BANCO DE DADOS DO USUÁRIO));
echo "<pre>";
print_r(verifyUser($user, $password));
return;


if (!$user || !$password) {
    $msg = "Preencha todos os campos";
} else {
    if ($data = verifyUser($user, $password)) {
        if (!$data['error']) {
            setcookie("SESSION", 'AUTH', 0, '/');
            setcookie("USER_SESSION", $user, time() + (3600 * 1), '/');

            $_SESSION['empresa'] = 'SyntaxWeb';
            $_SESSION['id'] = $data[0];
            $_SESSION['user'] = $user;
            $_SESSION['name'] = $data[1];
            $_SESSION['email'] = $data[2];
            $_SESSION['timer'] = time();

            mysqli_close($con);
            // exit(header('Location: ../app/permission.php'));
        } else {
            $msg = $data['error'];
        }
    } else {
        $msg = "Erro ao tentar se conectar";
    }
}
mysqli_close($con);
header("location: ../?msg=" . $msg);