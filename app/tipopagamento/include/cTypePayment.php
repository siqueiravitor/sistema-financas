<?php
require('../../../required.php');
include '../../config/config.php';
include '../../config/security.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

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