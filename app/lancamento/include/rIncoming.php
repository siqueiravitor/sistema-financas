<?php

include '../../config/config.php';
include '../../config/func.php';
include '../../config/connMysql.php';

if(!isset($_GET['id'])){
    $msg = "Registro não encontrado&alert=1";
    header("Location: ../?msg=$msg");
}
$id = $_GET['id'];

$sqlFinance = "delete from financa where id = $id";

if(mysqli_query($con, $sqlFinance)){
    $msg = 'Dados apagados';
} else {
    $msg = 'Erro ao apagar dados';
    $msg .= "&alert=1";
}
header("Location: ../?msg=$msg");