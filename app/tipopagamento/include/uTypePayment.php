<?php
require_once('../../../required.php');
include_once '../../config/config.php';
include_once '../../functions/func.php';
include_once '../../config/conn.php';
include_once './functions.php';

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
