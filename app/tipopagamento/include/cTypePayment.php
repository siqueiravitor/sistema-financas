<?php
require_once('../../../required.php');
include_once '../../config/config.php';
include_once '../../functions/func.php';
include_once '../../config/conn.php';
include_once './functions.php';

$msg = 'Dados registrados';

$typePaymentFilter = filter_input_array(INPUT_POST, [
    "description" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
]);

$description = empty($typePaymentFilter['description']) ? null : $typePaymentFilter['description'];

$typePayment = [
    'description' => $description
];

if(!createTypePayment($typePayment)){
    $msg = 'Erro ao registrar dados';
    $msg .= "&alert=1";
}

header("Location: ../?msg=$msg");