<?php

session_start();
/* Validar sessão do operado */
if (!isset($_SESSION["user"])) {
    session_destroy();
    $msg = "Sem acesso! =[";
    header("location:../?msg=" . $msg);
    return;
}
//Nome do Sistema
$sistema = 'E-Finanças';

/* UTF Portugues Brasil */
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

/* URL do dominio */
//$protocolo = (strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === false) ? 'http' : 'https';
//
//$protocolo = 'https';
//$host = $_SERVER['HTTP_HOST'];
//$UrlAtual = $protocolo . '://' . $host;
//$url = $UrlAtual;

$url = 'http://localhost/sistema-financas';

/* Parametros do sistema */
//$empresa = mb_strtolower($_SESSION['empresa']);

$empresa = 'SyntaxWeb';
define('ID_SISTEMA', 1);
define('NOME_EMPRESA', ucfirst($empresa));
define('SISTEMA', ucfirst($sistema));
define('TITLE', ucfirst($empresa));
define('BASE_ICO', $url . '/app/assets/images/logo.png');
define('BASEF', $url . '/');
define('BASED', $url . '/app');
define('BASES', '/var/www/html/sistema-financa');

/* Logged time limit */
//if ($_SESSION["timer"] + 10 * 60 < time()) {
//    session_destroy();
//    $msg = "Sessão expirada";
//    header("location: ../?msg=" . $msg);
//} else {
//    $_SESSION["tempo"] = time();
//}
ob_start();
