<?php

include '../../config/config.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

$date = dateConvert($_POST['date'], '/', '-', true);
$value = moneyToFloat($_POST['value']);
$category = $_POST['category'];
$recurrence = $_POST['recurrence'];
$description = empty($_POST['description']) ? null : $_POST['description'];

$dataFinance = [
    'idusuario' => $_SESSION['id'],
    'idcategoria' => $category,
    'valor' => $value,
    'descricao' => $description,
    'recurrent' => $recurrence,
    'data' => $date
];

if($id = registerFinance($dataFinance)){
    if($recurrence != 'u'){
        //CODE
    }
    mysqli_close($con);

    $msg = 'Dados registrados';
} else {
    $msg = 'Erro ao registrar dados';
    $msg .= "&alert=1";
}
header("Location: ../?msg=$msg");
