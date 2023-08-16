<?php
require('../../../required.php');
include '../../config/config.php';
include '../../config/security.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

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
