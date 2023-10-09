<?php
require_once('../../../required.php');
include_once '../../config/config.php';
include_once '../../functions/func.php';
include_once '../../config/conn.php';
include_once './functions.php';

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
