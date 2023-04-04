<?php

include '../../config/config.php';
include '../../config/security.php';
include '../../config/connMysql.php';
include './functions.php';

if(!isset($_GET['id'])){
    $msg = "Registro não encontrado&alert=1";
    exit(header("Location: ../?msg=$msg"));
}
$id = $_GET['id'];
$mult = isset($_GET['mult']) ? true : false;

if($rows = deleteFinance($id, $mult)){
    $msg = "Dados apagados ($rows)";
} else {
    $msg = 'Erro ao apagar dados';
    $msg .= "&alert=1";
}
mysqli_close($con);
header("Location: ../?msg=$msg");