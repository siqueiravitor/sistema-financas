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
    "category" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "recurrent" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "description" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
]);
$value = moneyToFloat($finance['value']);
$category = $finance['category'];
$recurrent = $finance['recurrent'] == 'u' ? 'n' : 'y';
$description = empty($finance['description']) ? null : $finance['description'];
$paid = !empty($finance['payment']) ? 'y' : 'n';

$data['finance'] = [
    'iduser' => $_SESSION['id'],
    'idcategory' => $category,
    'value' => $value,
    'description' => $description,
    'paid' => $paid,
    'recurrent' => $recurrent
];

$newFinance = registerFinance($data);

if ($newFinance['success']) {
    $msg = "Dados registrados!";
    $id = $newFinance['id'];

    if ($paid) {
        $data['payment'] = [
            'type' => $finance['payment'],
            'value' => $value
        ];

        $payment = registerPayment($id, $data['payment']);
        if (!$payment['success']) {
            $msg .= '<br>' . $payment['message'];
        }
    }
    


    if ($recurrent == 'y') {
        $recurrences = filter_input_array(INPUT_POST, [
            "recurrence" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            "status" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            "period" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            "date" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ]);
        $date = dateConvert($recurrences['date'], '/', '-');
        $status = $recurrences['status'];
        $period = $recurrences['period'];
        $recurrent = $recurrences['recurrent'];
        $recurrence = $recurrences['recurrence'];
        $recurrence_desc = $recurrence == 'f' ? 'fixed' : 'installment';

        $data['recurrence'] = [
            'id_finance' => $id,
            'value' => $value,
            'type' => $recurrence_desc,
            'status' => $status,
            'period' => $period,
            'recurrence' => $recurrence
        ];
        $id_recurrence = registerRecurrence($id, $data);
        
        if ($finance['recurrent'] == 'f') {
            $data['fixed'] = [
                'value' => $value,
                'payday' => $date,
                'paid' => $paid
            ];
            $fixed = registerRecurrenceFixed($id_recurrence, $data);

            if ($fixed && $paid && $status == 'ongoing') {
                $newDate = dateChange($date, $recurrences['period'], $recurrences['recurrence']);

                $data['fixed'] = [
                    'payday' => $newDate,
                    'value' => $value,
                    'paid' => 'n'
                ];

                registerRecurrenceFixed($id_recurrence, $data);
            }
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
} else {
    $msg = 'Erro ao registrar dados';
    $msg .= "&alert=1";
}
header("Location: ../?msg=$msg");
