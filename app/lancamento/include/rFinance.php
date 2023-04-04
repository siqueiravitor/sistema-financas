<?php

include '../../config/config.php';
include '../../config/security.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';
$user = mysqli_escape_string($con, $_POST['user']);

// Unique payment
$date = mysqli_escape_string($con, $_POST['date']);
$value = mysqli_escape_string($con, $_POST['value']);
$category = mysqli_escape_string($con, $_POST['category']);
$recurrent = mysqli_escape_string($con, $_POST['recurrent']);
$description = empty($_POST['description']) ? null : mysqli_escape_string($con, $_POST['description']);
$payment = empty($_POST['payment']) ? null : mysqli_escape_string($con, $_POST['payment']);

$data['finance'] = [
    'iduser' => $_SESSION['id'],
    'idcategory' => $category,
    'value' => moneyToFloat($value),
    'description' => $description,
    'payment' => $payment,
    'recurrent' => $recurrent,
    'date' => dateConvert($date, '/', '-')
];

if ($id = registerFinance($data['finance'])) {
    $msg = 'Dados registrados';

    if ($recurrence != 'u') {
        // Payment in installment
        $categoryRecurrence = isset($_POST['categoryRecurrence']) ? mysqli_escape_string($con, $_POST['categoryRecurrence']) : null;
        $valueInstallment = isset($_POST['valueInstallment']) ? mysqli_escape_string($con, $_POST['valueInstallment']) : null;
        $installment = isset($_POST['installment']) ? mysqli_escape_string($con, $_POST['installment']) : null;
        $recurrence = isset($_POST['recurrence']) ? mysqli_escape_string($con, $_POST['recurrence']) : null;
        $dateEnd = isset($_POST['dateEnd']) ? mysqli_escape_string($con, $_POST['dateEnd']) : null;
        $period = isset($_POST['period']) ? mysqli_escape_string($con, $_POST['period']) : null;
        $status = isset($_POST['status']) ? mysqli_escape_string($con, $_POST['status']) : null;

        $dateEnd = !empty($dateEnd) ? dateConvert($dateEnd, '/', '-') : null; 
        $valueInstallment = !empty($valueInstallment) ? moneyToFloat($valueInstallment) : $value; 
        $data['recurrence'] = [
            'idfinance' => $id,
            'valueInstallment' => $valueInstallment,
            'installment' => $installment,
            'categoryRecurrence' => $categoryRecurrence,
            'recurrence' => $recurrence,
            'period' => $period,
            'status' => $status,
            'dateEnd' => dateConvert($dateEnd, '/', '-'),
        ];
        if(!registerRecurrence($data['recurrence'])) {
            $msg = 'Erro ao registrar recorrência';
        }
    }
} else {
    $msg = 'Erro ao registrar dados';
    $msg .= "&alert=1";
}
mysqli_close($con);
header("Location: ../?msg=$msg");