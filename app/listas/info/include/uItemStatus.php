<?php
require_once('../../../../required.php');
include_once '../../../config/config.php';
include_once '../../../functions/func.php';
include_once '../../../config/conn.php';
include_once './functions.php';

$item = filter_input_array(INPUT_POST, [
    "id" => FILTER_SANITIZE_NUMBER_INT  
]);

$id = $item['id'];

$dataItem = [
    'id' => $id
];
$updateItem = updateItemStatus($dataItem);

echo json_encode($updateItem);
