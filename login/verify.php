<?php
ini_set('display_errors', 0);

require('../required.php');
include './connMysql.php';
include './functions.php';

session_start();
$_SESSION['ip'] = $user_ip = getUserIP();

$user_post = filter_input_array(INPUT_POST, [
    "user" => FILTER_SANITIZE_FULL_SPECIAL_CHARS, 
    "password" => FILTER_SANITIZE_SPECIAL_CHARS, 
]);

$user = $user_post['user'];
$password = $user_post['password'];

if (!$user || !$password) {
    $msg = "Preencha todos os campos";
} else {
    if ($data = verifyUser($user, $password)) {
        if (!$data['error']) {
            setcookie("USER_SESSION", $user, time() + (3600 * 1), '/');
            setcookie("SESSION", 'AUTH', 0, '/');

            $_SESSION['id'] = $data['id'];
            $_SESSION['user'] = $user;
            $_SESSION['name'] = $data['nome'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['timer'] = time();

            mysqli_close($con);
            exit(header('Location: ../app/permission.php'));
        } else {
            $msg = $data['error'];
        }
    } else {
        $msg = "Erro ao tentar se conectar";
    }
}

mysqli_close($con);
header("location: ../?msg=" . $msg);