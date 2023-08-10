<?php
require('../../../required.php');
include '../../config/config.php';
include '../../config/security.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

if(!isset($_GET['id'])){
    $msg = "Registro não encontrado&alert=1";
    exit(header("Location: ../?msg=$msg"));
}

$finance = filter_input_array(INPUT_GET, [
    "id" => FILTER_SANITIZE_NUMBER_INT
]);
$id = $finance['id'];

if($rows = deleteFinance($id)){
    $msg = "Dados apagados ($rows)";
} else {
    $msg = 'Erro ao apagar dados';
    $msg .= "&alert=1";
}
mysqli_close($con);
header("Location: ../?msg=$msg");