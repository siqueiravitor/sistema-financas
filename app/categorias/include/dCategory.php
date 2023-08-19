<?php
require('../../../required.php');
include '../../config/config.php';
include '../../config/security.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

$finance = filter_input_array(INPUT_POST, [
    "id" => FILTER_SANITIZE_NUMBER_INT
]);
$id = $finance['id'];

if($rows = deleteCategory($id)){
    $msg = "Dados apagados ($rows)";
} else {
    $msg = 'Erro ao apagar dados';
    $msg .= "&alert=1";
}
header("Location: ../?msg=$msg");