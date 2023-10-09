<?php
require_once('../../../../required.php');
include_once '../../../config/config.php';
include_once '../../../functions/func.php';
include_once '../../../config/conn.php';
include_once './functions.php';

$item = filter_input_array(INPUT_POST, [
    "list" => FILTER_SANITIZE_NUMBER_INT,
    "id" => FILTER_SANITIZE_NUMBER_INT
]);
$id = $item['id'];
$idList = $item['list'];
$list = getList(null, $idList)[0][5];
if($list){
    $deleteItem = deleteItem($id);
    if(!$deleteItem['success']){
        $alert = "&alert=1";
    }
}

header("Location: ../?list=$list&msg=".$deleteItem['message']. $alert);
