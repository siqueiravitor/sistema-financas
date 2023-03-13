<?php
session_start();
/*UTF Portugues Brasil*/
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

/*URL do dominio*/
$protocolo = (strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === false) ? 'http' : 'https';
$host = $_SERVER['HTTP_HOST'];
$UrlAtual = $protocolo . '://' . $host;
$url =  $UrlAtual;


/*Conexão AD
define('HOST_AD', 'rendar.masan.com.br');
define('PORT_AD', 389);
define('DOMINIO_AD',  'masan.com.br');
*/