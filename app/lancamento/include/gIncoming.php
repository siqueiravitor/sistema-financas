<?php

include '../../config/config.php';
include '../../config/func.php';
include '../../config/connMysql.php';

$date = dateConvert($_POST['date'], '/', '-', true);
$value = moneyToFloat($_POST['value']);
$category = $_POST['category'];
$recurrence = $_POST['recurrence'];
$description = empty($_POST['description']) ? 'null' : "'".$_POST['description']."'";

$sqlFinance = "insert into financa(
                    idusuario,
                    idcategoria,
                    valor,
                    descricao,
                    data
                ) values (
                    {$_SESSION['id']},
                    $category,
                    '$value',
                    $description,
                    '$date'
                )";

if(mysqli_query($con, $sqlFinance)){
    $msg = 'Dados registrados';
} else {
    $msg = 'Erro ao registrar dados';
    $msg .= "&alert=1";
}
header("Location: ../?msg=$msg");