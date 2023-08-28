<?php
require('../../../required.php');
include '../../config/config.php';
include '../../config/security.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

$savings = filter_input_array(INPUT_POST, [
    "id" => FILTER_SANITIZE_NUMBER_INT
]);
$id = $savings['id'];

$deleteSavings = deleteSavings($id);
if(!$deleteSavings['success']){
    $alert = "&alert=1";
}

header("Location: ../?msg=".$deleteSavings['message']. $alert);
