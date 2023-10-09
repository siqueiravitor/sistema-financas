<?php
require_once('../../../required.php');
include_once '../../config/config.php';
include_once '../../functions/func.php';
include_once '../../config/conn.php';
include_once './functions.php';

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
$description = $financeRecurrent == 'n' ? $finance['description'] : null;
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
    $recurrence_desc = 'fixed';

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
        $newFinanceId = $newFinance['id'];

        $link = [
            'id_finance' => $newFinanceId,
            'id_recurrence' => $id_recurrence
        ];

        finance_recurrence($link);
    }
}

header("Location: ../?msg=$msg");