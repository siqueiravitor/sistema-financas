<?php
include_once './config/connMysql.php';
session_start();

// Log de Acesso
// $hoje = date('Y-m-d');
// $agora = date('H:i:s');
// $logAcesso = "insert into logacesso (idusuario, data, hora) 
//                         values($_SESSION['id'],'$hoje','$agora)";
// $mysqli_query($con, $logAcesso);

// URL do dominio
// $protocolo = (strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === false) ? 'http' : 'https';
// $host = $_SERVER['HTTP_HOST'];
// $UrlAtual = $protocolo . '://' . $host;
// $url = $UrlAtual;

// Foto do usuário
// $sqlFoto = "select foto from usuario where id = " . $_SESSION['id'];
// $queryFoto = mysqli_query($con, $sqlFoto);
// $foto = mysqli_fetch_array($queryFoto, MYSQLI_NUM)[0];
// if ($foto) {
//     $_SESSION['foto'] = $url . "/app_dev/app" . $foto;
// } else { // Foto Placeholder
//     $_SESSION['foto'] = $url . "/app/assets/images/central/perfil.png";
// }

// Dados do Sistema
$sqlSistema = "select
                empresa,
                nome,
                apelido,
                logo,
                logoalt,
                versao,
                status
            from sistema";

$querySistema = mysqli_query($con, $sqlSistema);

$mensagem = "Erro ao tentar realizar login";
if ($querySistema) {
    $sistema = mysqli_fetch_array($querySistema, MYSQLI_ASSOC);
    if($sistema['status'] == 'a'){
        $url = 'http://localhost/'. $sistema['apelido'];
        $_SESSION['COMPANY'] = ucfirst($sistema['empresa']);
        $_SESSION['SYSTEM'] = ucfirst($sistema['nome']);
        $_SESSION['TITLE'] = ucfirst($sistema['empresa']);
        $_SESSION['VERSION'] = ucfirst($sistema['versao']);
        $_SESSION['LOGO'] = $url . '/app/assets/images/' . $sistema['logo'];
        $_SESSION['LOGOALT'] = $url . '/app/assets/images/' . $sistema['logoalt'];
        $_SESSION['BASEF'] = $url . '/';
        $_SESSION['BASED'] = $url . '/app';
        $_SESSION['BASES'] = '/var/www/html/'. $sistema['apelido'];
        header("Location: ./");
        return;
    } elseif ($sistema['status'] == 'i'){
        $mensagem = "Sistema indisponível";
    } elseif ($sistema['status'] == 'm'){
        $mensagem = "Sistema em manutenção";
    }
}
header("Location: ../?msg=$mensagem");