<?php
require('../../../required.php');
include '../../config/config.php';
include '../../config/security.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

$finance = filter_input_array(INPUT_POST, [
    "id" => FILTER_SANITIZE_NUMBER_INT
]);

$id = $finance['id'];
$deleteList = deleteList($id);
if(!$deleteList['success']){
    $alert = "&alert=1";
}

header("Location: ../?msg=".$deleteList['message']. $alert);
