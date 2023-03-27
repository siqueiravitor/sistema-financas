<?php

include '../../vendor/autoload.php';
include '../connMysql.php';
include '../functions.php';

session_start();
$_SESSION['ip'] = $user_ip = getUserIP();

$name = mysqli_escape_string($con, $_POST['name']);
$email = mysqli_escape_string($con, $_POST['email']);
$login = mysqli_escape_string($con, $_POST['user']);
$password = md5(mysqli_escape_string($con, $_POST['password']));
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
    $_SESSION['empresa'] = 'SyntaxWeb';
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
