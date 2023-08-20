<?php
require('../../../../required.php');
include '../../../config/config.php';
include '../../../config/security.php';
include '../../../functions/func.php';
include '../../../config/connMysql.php';
include './functions.php';

$item = filter_input_array(INPUT_POST, [
    "list" => FILTER_SANITIZE_NUMBER_INT,
    "id" => FILTER_SANITIZE_NUMBER_INT
]);

$id = $item['id'];
$list = $item['list'];
$deleteItem = deleteItem($id);
if(!$deleteItem['success']){
    $alert = "&alert=1";
}

header("Location: ../?item=$list&msg=".$deleteItem['message']. $alert);
