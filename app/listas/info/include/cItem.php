<?php
require('../../../../required.php');
include '../../../config/config.php';
include '../../../config/security.php';
include '../../../functions/func.php';
include '../../../config/connMysql.php';
include './functions.php';

$msg = 'Dados registrados';

$itemFilter = filter_input_array(INPUT_POST, [
    "idList" => FILTER_SANITIZE_NUMBER_INT,
    "list" => FILTER_SANITIZE_NUMBER_INT,
    "value" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "description" => FILTER_SANITIZE_FULL_SPECIAL_CHARS
]);

$idList = $itemFilter['idList'];
$value = moneyToFloatAlt($itemFilter['value']);
$id_list = $itemFilter['list'];
$description = $itemFilter['description'];

$item = [
    'value' => $value,
    'id_list' => $id_list,
    'description' => $description
];
if(!createItem($item)){
    $msg = 'Erro ao registrar dados';
    $msg .= "&alert=1";
}

header("Location: ../?list=$idList&msg=$msg");