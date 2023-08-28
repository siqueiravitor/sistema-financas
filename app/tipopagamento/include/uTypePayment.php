<?php
require('../../../required.php');
include '../../config/config.php';
include '../../config/security.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

$list = filter_input_array(INPUT_POST, [
    "id" => FILTER_SANITIZE_NUMBER_INT,
    "description" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
]);

$id = $list['id'];
$description = $list['description'];

$data = [
    'id' => $id,
    'description' => $description,
];
$update = updateTypePayment($data);

if(!$update['success']){
    $alert = "&alert=1";
}

header("Location: ../?msg=".$update['message']. $alert);
