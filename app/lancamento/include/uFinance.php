<?php

include '../../config/config.php';
include '../../config/security.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

// Unique payment

$id = $_REQUEST['id'];
$date = mysqli_escape_string($con, $_REQUEST['date']);
$value = mysqli_escape_string($con, $_REQUEST['value']);
$category = mysqli_escape_string($con, $_REQUEST['category']);
$recurrent = mysqli_escape_string($con, $_REQUEST['recurrent']);
$description = empty($_REQUEST['description']) ? null : mysqli_escape_string($con, $_REQUEST['description']);
$payment = empty($_REQUEST['payment']) ? null : mysqli_escape_string($con, $_REQUEST['payment']);

$dataFinance = [
    'id' => $id,
    'idcategory' => $category,
    'value' => moneyToFloat($value),
    'description' => $description,
    'payment' => $payment,
    'recurrent' => $recurrent,
    'date' => dateConvert($date, '/', '-')
];
$row = updateFinance($dataFinance);

if($row = updateFinance($dataFinance)){
    mysqli_close($con);

    $msg = "Dados atualizados ($row)";
} else {
    $msg = 'Erro ao atualizar dados';
    $msg .= "&alert=1";
}
header("Location: ../?msg=$msg");
