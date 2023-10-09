<?php
session_start();
// ini_set('display_errors', 0);
define('COMPANY', $_SESSION['COMPANY']);
define('SYSTEM', $_SESSION['SYSTEM']);
define('TITLE', $_SESSION['TITLE']);
define('VERSION', $_SESSION['VERSION']);
define('LOGO', $_SESSION['LOGO']);
define('BASE', $_ENV['BASEF']);
define('BASED', $_ENV['BASED']);
define('BASES', $_ENV['BASES']);
define('ICON', $_ENV['BASEI']);

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

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

if (!isset($_SESSION["user"])) {
    $msg = "Sem acesso! =[";
    unset($_SESSION);
    session_destroy();
    setcookie("SESSION", '', 1, '/');
    setcookie("USER_SESSION", '', 1, '/');
    exit(header("location: ../?msg=" . $msg));
}
