<?php
session_start();
define('COMPANY', $_SESSION['COMPANY']);
define('SYSTEM', $_SESSION['SYSTEM']);
define('TITLE', $_SESSION['TITLE']);
define('VERSION', $_SESSION['VERSION']);
define('LOGO', $_SESSION['LOGO']);
define('LOGOALT', $_SESSION['LOGOALT']);
define('BASE', $_SESSION['BASEF']);
define('BASED', $_SESSION['BASED']);
define('BASES', $_SESSION['BASES']);
define('ICON', $_SESSION['BASEI']);

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

// Verificar se sistema esta ativo/inativo/manutenção

if (!isset($_SESSION["user"])) {
    $msg = "Sem acesso! =[";
    unset($_SESSION);
    session_destroy();
    setcookie("SESSION", '', 1, '/');
    setcookie("USER_SESSION", '', 1, '/');
    exit(header("location: ../?msg=" . $msg));
}

if ($_SESSION["timer"] + (3600 * 1) < time()) {
    $msg = "Sessão expirada";
    unset($_SESSION);
    session_destroy();
    setcookie("SESSION", '', 1, '/');
    setcookie("USER_SESSION", '', 1, '/');
    exit(header("location: ../?msg=" . $msg));
} else {
    $_SESSION["timer"] = time();
}
ob_start();



// Verificar se sistema esta ativo/inativo/manutenção
// function authenticate($user){
//     $realm = 'Authorized users of webvoid.com.br';
//     $uri = '/sistema-financas';
//     $opaque = md5(uniqid());
//     $nonce = md5(uniqid());
//     $A1 = md5("$user:$realm");
//     $A2 = md5($_SERVER['REQUEST_METHOD'] . ":$uri");
//     $response = md5("$A1:$nonce:$A2");
//     $sprintf = sprintf('WWW-Authenticate: Digest username="%s", realm="%s", nonce="%s", uri="%s", response="%s", opaque="%s"', $user, $realm, $nonce, $uri, $response, $opaque);
//     $_SERVER['PHP_AUTH_DIGEST'] = $sprintf;
//     header($sprintf);
// }

// function logout(){
//     session_start();
//     session_destroy();
//     setcookie("SESSION", '', 1, '/');
//     setcookie("USER_SESSION", '', 1, '/');
//     unset($_SERVER['PHP_AUTH_DIGEST']);
//     unset($_SERVER['PHP_AUTH_USER']);
//     unset($_SERVER['PHP_AUTH_PW']);
// }
