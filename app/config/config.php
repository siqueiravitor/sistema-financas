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

ob_start();
// Verificar se sistema esta ativo/inativo/manutenção