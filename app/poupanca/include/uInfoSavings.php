<?php
require_once('../../../required.php');
include_once '../../config/config.php';
include_once '../../functions/func.php';
include_once '../../config/conn.php';
include_once './functions.php';

$filter = filter_input_array(INPUT_POST, [
    "id" => FILTER_SANITIZE_NUMBER_INT,
    "value" => FILTER_SANITIZE_NUMBER_FLOAT,
    "savings-radio" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "goal" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
]);

$id = $filter['id'];
$goal = $filter['goal'];
$value = moneyToFloat($filter['value']);
$savings_radio = $filter['savings-radio'];

$data = [
    'id' => $id,
    'goal' => $goal,
    'value' => $value,
    'savings_radio' => $savings_radio,
];
$update = updateSavingsReserved($data);

if(!$update['success']){
    $alert = "&alert=1";
}
$description = 'Retirado';
$entry = 'out';
if($savings_radio == 'save'){
    $description = 'Adicionado';
    $entry = 'in';
}

$idFinance = registerFinance($description, $value);

$link = [
    'id_finance' => $idFinance,
    'id_savings' => $id,
    'entry' => $entry
];

linkSavingsFinances($link);

header("Location: ../?msg=".$update['message']. $alert);
