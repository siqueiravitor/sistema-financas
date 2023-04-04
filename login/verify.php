<?php

// include '../vendor/autoload.php';
include './connMysql.php';
include './functions.php';

session_start();
$_SESSION['ip'] = $user_ip = getUserIP();

$user = mysqli_escape_string($con, $_POST['user']);
$password = mysqli_escape_string($con, $_POST['password']);

if (!$user || !$password) {
    $msg = "Preencha todos os campos";
} else {
    if ($data = verifyUser($user, $password)) {
        if (!$data['error']) {
            setcookie("USER_SESSION", $user, time() + (3600 * 1), '/');
            setcookie("SESSION", 'AUTH', 0, '/');
            authenticate($user);

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

function authenticate($user){
    $realm = 'Authorized users of spidercode.com.br';
    $uri = '/sistema-financas';
    $opaque = md5(uniqid());
    $nonce = md5(uniqid());
    $A1 = md5("$user:$realm");
    $A2 = md5($_SERVER['REQUEST_METHOD'] . ":$uri");
    $response = md5("$A1:$nonce:$A2");
    $sprintf = sprintf(
        'token: username="%s", realm="%s", nonce="%s", uri="%s", response="%s", opaque="%s"',
        $user,
        $realm,
        $nonce,
        $uri,
        $response,
        $opaque
    );
    header($sprintf);
    $_SESSION['token'] = base64_encode($sprintf);
}

mysqli_close($con);
header("location: ../?msg=" . $msg);