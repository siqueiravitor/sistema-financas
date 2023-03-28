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
$payment = empty($_POST['payment']) ? null : $_POST['payment'];

$dataFinance = [
    'iduser' => $_SESSION['id'],
    'idcategory' => $category,
    'value' => $value,
    'description' => $description,
    'payment' => $payment,
    'recurrent' => $recurrence,
    'date' => $date
];

echo "<PRE>";
print_r($dataFinance);

print_r($_POST);

return;

if ($id = registerFinance($dataFinance)) {
    if ($recurrence != 'u') {
        $dataRecurrence =[
            'idfinance' => $id
        ];
        array_unshift($result, $dataRecurrence);
        registerRecurrence($fields);
        return;
    }
    mysqli_close($con);

    $msg = 'Dados registrados';
} else {
    $msg = 'Erro ao registrar dados';
    $msg .= "&alert=1";
}
header("Location: ../?msg=$msg");