<?php
require_once('../../../../required.php');
include_once '../../../config/config.php';
include_once '../../../functions/func.php';
include_once '../../../config/conn.php';
include_once './functions.php';

$item = filter_input_array(INPUT_POST, [
    "id" => FILTER_SANITIZE_NUMBER_INT,    
    "list" => FILTER_SANITIZE_NUMBER_INT,    
    "value" => FILTER_SANITIZE_NUMBER_FLOAT,
    "description" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
]);

$id = $item['id'];
$list = $item['list'];
$value = $item['value'];
$description = $item['description'];

$dataItem = [
    'id' => $id,
    'value' => moneyToFloat($value),
    'description' => $description,
];
$updateItem = updateItem($dataItem);
if(!$updateItem['success']){
    $alert = "&alert=1";
}

header("Location: ../?item=$list&msg=".$updateItem['message']. $alert);
