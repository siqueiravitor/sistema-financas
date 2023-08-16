<?php
require('../../../required.php');
include '../../config/config.php';
include '../../config/security.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

// Unique payment
$finance = filter_input_array(INPUT_POST, [
    "date" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "value" => FILTER_SANITIZE_NUMBER_FLOAT,
    "category" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "recurrent" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "description" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "payment" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "payment_type" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
]);
$date = $finance['date'];
$value = moneyToFloat($finance['value']);
$category = $finance['category'];
$recurrent = $finance['recurrent'];
$description = empty($finance['description']) ? null : $finance['description'];
$paid = $finance['payment'] ? 'y' : 'n';
$payment = $finance['payment'];

$data['finance'] = [
    'iduser' => $_SESSION['id'],
    'idcategory' => $category,
    'value' => $value,
    'description' => $description,
    'paid' => $paid,
    'recurrent' => $recurrent,
    'date' => dateConvert($date, '/', '-')
];

if ($paid) {
    $data['payment'] = [
        'type' => $payment,
        'value' => $value
    ];
}
$finance = registerFinance($data);

if ($finance['success']) {
    $msg = $finance['message'];

    // if ($recurrent != 'u') { // Payment in installment
    //     $recurrences = filter_input_array(INPUT_POST, [
    //                 "categoryRecurrence" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    //                 "valueInstallment" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    //                 "installment" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    //                 "recurrence" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    //                 "dateEnd" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    //                 "period" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    //                 "status" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    //             ]);

    //     $dateEnd = !empty($dateEnd) ? dateConvert($dateEnd, '/', '-') : null; 
    //     $valueInstallment = !empty($valueInstallment) ? moneyToFloat($valueInstallment) : $value; 
    //     $data['recurrence'] = [
    //         'idfinance' => $id,
    //         'valueInstallment' => $valueInstallment,
    //         'installment' => $installment,
    //         'categoryRecurrence' => $categoryRecurrence,
    //         'recurrence' => $recurrence,
    //         'period' => $period,
    //         'status' => $status,
    //         'dateEnd' => dateConvert($dateEnd, '/', '-'),
    //     ];
    //     if(!registerRecurrence($data['recurrence'])) {
    //         $msg = 'Erro ao registrar recorrência';
    //     }
    // }
} else {
    $msg = 'Erro ao registrar dados';
    $msg .= "&alert=1";
}
header("Location: ../?msg=$msg");
