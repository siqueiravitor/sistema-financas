<?php
require('../../required.php');
include '../connMysql.php';
include '../functions.php';

session_start();
$_SESSION['ip'] = $user_ip = getUserIP();

$user_post = filter_input_array(INPUT_POST, [
    "name" => FILTER_SANITIZE_FULL_SPECIAL_CHARS, 
    "user" => FILTER_SANITIZE_FULL_SPECIAL_CHARS, 
    "email" => FILTER_SANITIZE_EMAIL, 
    "password" => FILTER_SANITIZE_SPECIAL_CHARS, 
]);

$name = $user_post['name'];
$login = $user_post['user'];
$email = $user_post['email'];
$password = $user_post['password'];
$nameFormat = ucwords(mb_strtolower($name));


if (!$name || !$email || !$login || !$password) {
    $msg = "Preencha todas as informações";
    exit(header("Location: ./?msg=$msg"));
}

if (checkUserExists($login, $email) > 0) {
    $msg = "Usuário/email já cadastrado";
    exit(header("Location: ./?msg=$msg"));
}

$dataUser = [
    'name' => $nameFormat,
    'email' => $email,
    'login' => $login,
    'password' => $password
];

if ($id = createUser($dataUser)) {
    $_SESSION['id'] = $id;
    $_SESSION['user'] = $login;
    $_SESSION['name'] = $nameFormat;
    $_SESSION['email'] = $email;
    $_SESSION['timer'] = time();
    
    mysqli_close($con);
    exit(header('Location: ../../app/permission.php'));
}

$msg = "Erro ao cadastrar nova conta";
exit(header("Location: ./?msg=$msg"));
