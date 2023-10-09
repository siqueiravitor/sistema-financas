<?php
require_once('../../../required.php');
include_once '../../config/config.php';
include_once '../../functions/func.php';
include_once '../../config/conn.php';
include_once './functions.php';

$idUser = $_SESSION['id'];
// Unique payment
$finance = filter_input_array(INPUT_POST, [
    "id" => FILTER_SANITIZE_NUMBER_INT,
    "value" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "payment" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "category" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "description" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
]);
$idFinance = $finance['id'];
$payment = $finance['payment'];
$category = $finance['category'];
$description = $finance['description'];
$value = moneyToFloatAlt($finance['value']);

$data['payment'] = [
    'id_finance' => $idFinance,
    'value' => $value,
    'type' => $payment
];
$data['finance'] = [
    'id' => $idFinance,
    'idcategory' => $category,
    'value' => $value,
    'description' => $description,
    'paid' => 'y'
];
registerPayment($data['payment']);
updateFinance($data['finance']);
repeatFixedRecurrence($idUser, $idFinance, $value);
header("Location: ../?msg=$msg");