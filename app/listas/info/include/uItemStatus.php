<?php
require('../../../../required.php');
include '../../../config/config.php';
include '../../../functions/func.php';
include '../../../config/connMysql.php';
include './functions.php';

$item = filter_input_array(INPUT_POST, [
    "id" => FILTER_SANITIZE_NUMBER_INT  
]);

$id = $item['id'];

$dataItem = [
    'id' => $id
];
$updateItem = updateItemStatus($dataItem);

echo json_encode($updateItem);
