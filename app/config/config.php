<?php

session_start();
// Validar sessão
if (!isset($_SESSION["user"])) {
    session_destroy();
    $msg = "Sem acesso! =[";
    header("location:../?msg=" . $msg);
    return;
}

define('COMPANY', $_SESSION['COMPANY']);
define('SYSTEM', $_SESSION['SYSTEM']);
define('TITLE', $_SESSION['TITLE']);
define('VERSION', $_SESSION['VERSION']);
define('LOGO', $_SESSION['LOGO']);
define('LOGOALT', $_SESSION['LOGOALT']);
define('BASE', $_SESSION['BASEF']);
define('BASED', $_SESSION['BASED']);
define('BASES', $_SESSION['BASES']);

// UTF-8 Portugues Brasil \\
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

// Verificar se sistema esta ativo/inativo/manutenção

// Tempo limit de logado
//if ($_SESSION["timer"] + 10 * 60 < time()) {
//    session_destroy();
//    $msg = "Sessão expirada";
//    header("location: ../?msg=" . $msg);
//} else {
//    $_SESSION["tempo"] = time();
//}
ob_start();
