<?php
require('../../../required.php');
include '../../config/config.php';
include '../../config/security.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

$msg = 'Dados registrados';

$itemFilter = filter_input_array(INPUT_POST, [
    "id_list" => FILTER_SANITIZE_NUMBER_INT,
    "value" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "description" => FILTER_SANITIZE_FULL_SPECIAL_CHARS
]);

$value = $itemFilter['value'];
$id_list = $itemFilter['id_list'];
$description = $itemFilter['description'];

$item = [
    'value' => $value,
    'id_list' => $id_list,
    'description' => $description
];
echo "<pre>";
print_r($itemFilter);
return;

if(!createItem($item)){
    $msg = 'Erro ao registrar dados';
    $msg .= "&alert=1";
}

header("Location: ../?msg=$msg");