<?php
require_once('../../../required.php');
include_once '../../config/config.php';
include_once '../../functions/func.php';
include_once '../../config/conn.php';
include_once './functions.php';

$finance = filter_input_array(INPUT_POST, [
    "id" => FILTER_SANITIZE_NUMBER_INT,
    "value" => FILTER_SANITIZE_NUMBER_FLOAT,
    "category" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "description" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
]);

$id = $finance['id'];
$value = $finance['value'];
$category = $finance['category'];
$description = $finance['description'];

$dataFinance = [
    'id' => $id,
    'idcategory' => $category,
    'value' => moneyToFloat($value),
    'description' => $description,
];

$updateFinance = updateFinance($dataFinance);

if(!$updateFinance['success']){
    $alert = "&alert=1";
}

header("Location: ../?msg=".$updateFinance['message']. $alert);
