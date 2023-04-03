<?php

include '../../config/config.php';
include '../../config/security.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';
$user = mysqli_escape_string($con, $_REQUEST['user']);

// Unique payment
$date = mysqli_escape_string($con, $_REQUEST['date']);
$value = mysqli_escape_string($con, $_REQUEST['value']);
$category = mysqli_escape_string($con, $_REQUEST['category']);
$recurrent = mysqli_escape_string($con, $_REQUEST['recurrent']);
$description = empty($_REQUEST['description']) ? null : mysqli_escape_string($con, $_REQUEST['description']);
$payment = empty($_REQUEST['payment']) ? null : mysqli_escape_string($con, $_REQUEST['payment']);

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
        $categoryRecurrence = isset($_REQUEST['categoryRecurrence']) ? mysqli_escape_string($con, $_REQUEST['categoryRecurrence']) : null;
        $valueInstallment = isset($_REQUEST['valueInstallment']) ? mysqli_escape_string($con, $_REQUEST['valueInstallment']) : null;
        $installment = isset($_REQUEST['installment']) ? mysqli_escape_string($con, $_REQUEST['installment']) : null;
        $recurrence = isset($_REQUEST['recurrence']) ? mysqli_escape_string($con, $_REQUEST['recurrence']) : null;
        $dateEnd = isset($_REQUEST['dateEnd']) ? mysqli_escape_string($con, $_REQUEST['dateEnd']) : null;
        $period = isset($_REQUEST['period']) ? mysqli_escape_string($con, $_REQUEST['period']) : null;
        $status = isset($_REQUEST['status']) ? mysqli_escape_string($con, $_REQUEST['status']) : null;

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
    mysqli_close($con);
} else {
    $msg = 'Erro ao registrar dados';
    $msg .= "&alert=1";
}
header("Location: ../?msg=$msg");