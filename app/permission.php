<?php
include_once './functions/system.php';
include_once './config/connMysql.php';
session_start();

$msg = "Erro de sincronia";
if ($data = dataSystem()) {
    $system = $data[1];

    if($data[0] > 0 && $system['status'] == 'a'){
        $url = 'http://localhost/'. $system['apelido'];
        $_SESSION['COMPANY'] = ucfirst($system['empresa']);
        $_SESSION['SYSTEM'] = ucfirst($system['nome']);
        $_SESSION['TITLE'] = ucfirst($system['empresa']);
        $_SESSION['VERSION'] = ucfirst($system['versao']);
        $_SESSION['LOGO'] = $url . '/app/assets/images/' . $system['logo'];
        $_SESSION['LOGOALT'] = $url . '/app/assets/images/' . $system['logoalt'];
        $_SESSION['BASEF'] = $url . '/';
        $_SESSION['BASED'] = $url . '/app';
        $_SESSION['BASEI'] = $url . '/app/assets/icons';
        $_SESSION['BASES'] = '/var/www/html/'. $system['apelido'];

        exit(header("Location: ./"));
    } elseif ($system['status'] == 'i'){
        $msg = "Sistema indisponível";
    } elseif ($system['status'] == 'm'){
        $msg = "Sistema em manutenção";
    }
}
header("Location: ../?msg=$msg");