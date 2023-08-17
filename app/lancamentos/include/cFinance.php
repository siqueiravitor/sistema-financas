<?php
require('../../../required.php');
include '../../config/config.php';
include '../../config/security.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

// Unique payment
$finance = filter_input_array(INPUT_POST, [
    "value" => FILTER_SANITIZE_NUMBER_FLOAT,
    "payment" => FILTER_SANITIZE_NUMBER_INT,
    "date" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "category" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "recurrent" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "description" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
]);
$value = moneyToFloat($finance['value']);
$category = $finance['category'];
$recurrent = $finance['recurrent'];
$financeRecurrent = $recurrent == 'u' ? 'n' : 'y';
$description = $recurrent == 'n' ? $finance['description'] : null;
$paid = !empty($finance['payment']) ? 'y' : 'n';
$payday = dateConvert($finance['date'], '/', '-');

$data['finance'] = [
    'iduser' => $_SESSION['id'],
    'idcategory' => $category,
    'value' => $value,
    'description' => $description,
    'paid' => $paid,
    'payday' => $payday,
    'recurrent' => $financeRecurrent
];

// if ($newFinance['success']) {
$msg = "Dados registrados!";
if ($financeRecurrent == 'y') {
    // U n i q u e
    $recurrences = filter_input_array(INPUT_POST, [
        "recurrence" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        "status" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        "period" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        "date" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ]);
    $date = dateConvert($recurrences['date'], '/', '-');
    $status = $recurrences['status'];
    $period = $recurrences['period'];
    $recurrent = $finance['recurrent'];
    $recurrence = $recurrences['recurrence'];
    $recurrence_desc = $recurrence == 'f' ? 'fixed' : 'installment';

    $data['recurrence'] = [
        'value' => $value,
        'type' => $recurrence_desc,
        'status' => $status,
        'period' => $period,
        'description' => $description,
        'recurrence' => $recurrence
    ];

    $id_recurrence = registerRecurrence($data);

    if ($finance['recurrent'] == 'f') {
        $data['fixed'] = [
            'id_recurrence' => $id_recurrence,
            'value' => $value,
            'payday' => $date
        ];
        $fixed = registerRecurrenceFixed($data);
    }
    if ($finance['recurrent'] == 'i') {
        $data['installment'] = [
            'id_recurrence' => $id_recurrence,
            'value' => $value,
        ];
    }

    $newFinance = registerFinance($data);
    $id_finance = $newFinance['id'];

    $link = [
        'id_finance' => $id_finance,
        'id_recurrence' => $id_recurrence
    ];
    finance_recurrence($link);
} else {
    // U n i q u e
    $newFinance = registerFinance($data);
    $id_finance = $newFinance['id'];
}

if ($paid == 'y') {
    $data['payment'] = [
        'id_finance' => $id_finance,
        'type' => $finance['payment'],
        'value' => $value
    ];

    $payment = registerPayment($data['payment']);
    if (!$payment['success']) {
        $msg .= '<br>' . $payment['message'];
    }

    if ($finance['recurrent'] == 'f') {
        $payday = $data['finance']['payday'];
        $recurrence = $recurrences['recurrence'];
        $period = $recurrences['period'];
        $newDate = dateChange($payday, $period, $recurrence);

        $data['finance']['paid'] = 'n';
        $data['finance']['payday'] = $newDate;
        $newFinance = registerFinance($data);
    }
}


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
// } else {
//     $msg = 'Erro ao registrar dados';
//     $msg .= "&alert=1";
// }
header("Location: ../?msg=$msg");