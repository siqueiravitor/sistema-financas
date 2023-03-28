<?php

include '../../config/config.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

$id = $_POST['id'];
$date = dateConvert($_POST['date'], '/', '-', true);
$value = moneyToFloat($_POST['value']);
$category = $_POST['category'];
$recurrence = $_POST['recurrence'];
$description = empty($_POST['description']) ? null : $_POST['description'];
$payment = empty($_POST['payment']) ? null : $_POST['payment'];

$dataFinance = [
    'id' => $id,
    'idcategory' => $category,
    'value' => $value,
    'description' => $description,
    'payment' => $payment,
    'recurrent' => $recurrence,
    'date' => $date
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
