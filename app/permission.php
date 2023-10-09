<?php
require('../required.php');
ini_set('display_errors', 0);
include_once './functions/system.php';
include_once './config/connMysql.php';
session_start();

$msg = "Erro de sincronia";
if ($data = dataSystem()) {
    $system = $data[1];

    if($data[0] > 0 && $system['status'] == 'a'){
        $url = $_ENV['URL'];
        $_SESSION['COMPANY'] = "Mente Dev";
        $_SESSION['SYSTEM'] = ucfirst($system['name']);
        $_SESSION['TITLE'] = ucfirst($system['name']);
        $_SESSION['VERSION'] = ucfirst($system['version']);
        $_SESSION['LOGO'] = $url . '/app/assets/images/' . $system['logo'];

        exit(header("Location: ./"));
    } elseif ($system['status'] == 'i'){
        $msg = "Sistema indisponível";
    } elseif ($system['status'] == 'm'){
        $msg = "Sistema em manutenção";
    }
}
header("Location: ../?msg=$msg");