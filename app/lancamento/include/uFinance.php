<?php
require('../../../required.php');
include '../../config/config.php';
include '../../config/security.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

$finance = filter_input_array(INPUT_POST, [
    "id" => FILTER_SANITIZE_NUMBER_INT,
    "date" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "value" => FILTER_SANITIZE_NUMBER_FLOAT,
    "category" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "recurrent" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "description" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "payment" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
]);

$date = $finance['date'];
$value = $finance['value'];
$category = $finance['category'];
$description = $finance['description'];
$payment = $finance['payment'];

$dataFinance = [
    'id' => $id,
    'idcategory' => $category,
    'value' => moneyToFloat($value),
    'description' => $description,
    'payment' => $payment,
    'date' => dateConvert($date, '/', '-')
];

if($row = updateFinance($dataFinance)){
    $msg = "Dados atualizados";
} else {
    $msg = 'Erro ao atualizar dados';
    $msg .= "&alert=1";
}
mysqli_close($con);
header("Location: ../?msg=$msg");
