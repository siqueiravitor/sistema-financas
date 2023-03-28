<?php

include '../../config/config.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

// Unique payment
$date = dateConvert($_POST['date'], '/', '-');
$value = moneyToFloat($_POST['value']);
$category = $_POST['category'];
$recurrent = $_POST['recurrent'];
$description = empty($_POST['description']) ? null : $_POST['description'];
$payment = empty($_POST['payment']) ? null : $_POST['payment'];

// Payment in installment
$valueInstallment = isset($_POST['valueInstallment']) ? $_POST['valueInstallment'] : null;
$installment = isset($_POST['installment']) ? $_POST['installment'] : null;
$categoryRecurrence = isset($_POST['categoryRecurrence']) ? $_POST['categoryRecurrence'] : null;
$recurrence = isset($_POST['recurrence']) ? $_POST['recurrence'] : null;
$period = isset($_POST['period']) ? $_POST['period'] : null;
$dateEnd = isset($_POST['dateEnd']) ? $_POST['dateEnd'] : null;
$status = isset($_POST['status']) ? $_POST['status'] : null;

$data['finance'] = [
    'iduser' => $_SESSION['id'],
    'idcategory' => $category,
    'value' => $value,
    'description' => $description,
    'payment' => $payment,
    'recurrent' => $recurrent,
    'date' => $date
];

if ($id = registerFinance($data['finance'])) {
    $msg = 'Dados registrados';

    if ($recurrence != 'u') {
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