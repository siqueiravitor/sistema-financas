<?php
require_once('../../../required.php');
include_once '../../config/config.php';
include_once '../../functions/func.php';
include_once '../../config/conn.php';
include_once './functions.php';

$finance = filter_input_array(INPUT_POST, [
    "id" => FILTER_SANITIZE_NUMBER_INT
]);

$id = $finance['id'];
$deleteTypePayment = deleteTypePayment($id);
if(!$deleteTypePayment['success']){
    $alert = "&alert=1";
}

header("Location: ../?msg=".$deleteTypePayment['message']. $alert);