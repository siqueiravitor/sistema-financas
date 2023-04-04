<?php

include '../../config/config.php';
include '../../config/security.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

$id = $_POST['id'];
$date = mysqli_escape_string($con, $_POST['date']);
$value = mysqli_escape_string($con, $_POST['value']);
$category = mysqli_escape_string($con, $_POST['category']);
$description = empty($_POST['description']) ? null : mysqli_escape_string($con, $_POST['description']);
$payment = empty($_POST['payment']) ? null : mysqli_escape_string($con, $_POST['payment']);

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
