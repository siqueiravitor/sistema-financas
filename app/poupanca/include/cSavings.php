<?php
require('../../../required.php');
include '../../config/config.php';
include '../../config/security.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

$msg = 'Dados registrados';

$filter = filter_input_array(INPUT_POST, [
    "name" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "value" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "description" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
]);

$name = $filter['name'];
$value = moneyToFloatAlt($filter['value']);
$description = empty($filter['description']) ? null : $filter['description'];

$idFinance = registerFinance($name, $value);
$savings = [
    'name' => $name,
    'value' => $value,
    'id_finance' => $idFinance,
    'description' => $description
];
if(!createSavings($savings)){
    $msg = 'Erro ao registrar dados';
    $msg .= "&alert=1";
}

header("Location: ../?msg=$msg");