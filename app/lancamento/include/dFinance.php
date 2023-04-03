<?php

include '../../config/config.php';
include '../../config/security.php';
include '../../config/connMysql.php';
include './functions.php';

if(!isset($_REQUEST['id'])){
    $msg = "Registro não encontrado&alert=1";
    exit(header("Location: ../?msg=$msg"));
}
$id = $_REQUEST['id'];
$mult = isset($_REQUEST['mult']) ? true : false;

if($rows = deleteFinance($id, $mult)){
    $msg = "Dados apagados ($rows)";
} else {
    $msg = 'Erro ao apagar dados';
    $msg .= "&alert=1";
}
header("Location: ../?msg=$msg");