<?php
require_once('../../../required.php');
include_once '../../config/config.php';
include_once '../../functions/func.php';
include_once '../../config/conn.php';
include_once './functions.php';

$finance = filter_input_array(INPUT_POST, [
    "finance" => FILTER_SANITIZE_FULL_SPECIAL_CHARS
]);

$id = $finance['finance'];
$deleteFinance = deleteFinance($id);
if(!$deleteFinance['success']){
    $alert = "&alert=1";
}

header("Location: ../?msg=".$deleteFinance['message']. $alert);

