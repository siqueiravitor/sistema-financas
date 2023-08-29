<?php
require('../../../required.php');
include '../../config/config.php';
include '../../config/security.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

$savings = filter_input_array(INPUT_POST, [
    "id_finance" => FILTER_SANITIZE_NUMBER_INT,
    "id" => FILTER_SANITIZE_NUMBER_INT
]);
$id_finance = $savings['id_finance'];
$id = $savings['id'];

$data = [
    'id' => $id,
    'id_finance' => $id_finance
];

$delete = deleteSavings($data);
if(!$delete['success']){
    $alert = "&alert=1";
}

header("Location: ../?msg=".$delete['message']. $alert);
