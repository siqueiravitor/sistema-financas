<?php
require('../../../required.php');
include '../../config/config.php';
include '../../config/security.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

$finance = filter_input_array(INPUT_POST, [
    "finance" => FILTER_SANITIZE_FULL_SPECIAL_CHARS
]);

$id = $finance['finance'];
$deleteFinance = deleteFinance($id);
if(!$deleteFinance['success']){
    $alert = "&alert=1";
}

header("Location: ../?msg=".$deleteFinance['message']. $alert);

