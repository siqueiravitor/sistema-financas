<?php

include_once '../vendor/autoload.php';
include_once './config/connMysql.php';

session_start();
/* log de acesso */
$login = $_SESSION['user'];
$empresa = $_SESSION['empresa'];
$ipcolaborador = $_SESSION['ip'];
$idUser = $_SESSION['iduser'];

$select_ultimoAcesso = "select 
                            case when max(data) is not null 
                                then max(data) 
                                else now() 
                            end as data 
                            from logacesso where login ='" . $login . "'";
$ultimoAcesso = mysqli_query($con, $select_ultimoAcesso);
$retorno = mysqli_fetch_array($ultimoAcesso);
$_SESSION['ultimoAcesso'] = $retorno[0];

$agora = date('Y-m-d H:i:s');
$gravarLogAcesso = "insert into logacesso values(null,'$login','$agora')";
$res = mysqli_query($con, $gravarLogAcesso);

/* URL do dominio */
$protocolo = (strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === false) ? 'http' : 'https';
$host = $_SERVER['HTTP_HOST'];
$UrlAtual = $protocolo . '://' . $host;
$url = $UrlAtual;

$select_foto = "select foto from usuario where idusuario = " . $idUser;
$mysql_foto = mysqli_query($con, $select_foto);
$foto = mysqli_fetch_array($mysql_foto);

if ($foto[0] <> "") {
    $_SESSION['foto'] = $url . "/app_dev/app" . $foto['foto'];
} else {
    $_SESSION['foto'] = $url . "/app/assets/images/central/perfil.png";
}

$select_acessos = "select count(idlogacesso) from logacesso 
                    where login = '" . $login . "' 
                    and data > NOW() - INTERVAL 15 DAY";
$mysql_acessos = mysqli_query($con, $select_acessos);
$qtdAcesso = mysqli_fetch_array($mysql_acessos);
mysqli_close($con);
if ($qtdAcesso[0] == 0) {
    header("Location: ./primeiroAcesso/");
} else {
    header("Location: ./");
}