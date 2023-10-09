<?php
require('../../../../required.php');
include '../../../config/config.php';
include '../../../config/security.php';
include '../../../functions/func.php';
include '../../../config/connMysql.php';
include './functions.php';

$msg = 'Dados registrados';

$itemFilter = filter_input_array(INPUT_GET, [
    "listid" => FILTER_SANITIZE_NUMBER_INT
]);
$listid = $itemFilter['listid'];

$msg = 'Dados registrados';
if(!createFinance($listid)){
    $msg = 'Erro ao registrar dados';
    $msg .= "&alert=1";
}

header("Location: ../../?msg=$msg");