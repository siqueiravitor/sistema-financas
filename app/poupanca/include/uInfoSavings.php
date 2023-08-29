<?php
require('../../../required.php');
include '../../config/config.php';
include '../../config/security.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

$filter = filter_input_array(INPUT_POST, [
    "id" => FILTER_SANITIZE_NUMBER_INT,
    "value" => FILTER_SANITIZE_NUMBER_FLOAT,
    "savings-radio" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "goal" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
]);

$id = $filter['id'];
$goal = $filter['goal'];
$value = $filter['value'];
$savings_radio = $filter['savings-radio'];

$data = [
    'id' => $id,
    'goal' => $goal,
    'value' => moneyToFloat($value),
    'savings_radio' => $savings_radio,
];

$update = updateSavingsReserved($data);

if(!$update['success']){
    $alert = "&alert=1";
}

header("Location: ../?msg=".$update['message']. $alert);
