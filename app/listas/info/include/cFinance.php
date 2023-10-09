<?php
require_once('../../../../required.php');
include_once '../../../config/config.php';
include_once '../../../functions/func.php';
include_once '../../../config/conn.php';
include_once './functions.php';

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