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
$haveItems = checkListEmpty($id);
if($haveItems){
    $msg = "Remova os itens da lista antes de excluir";
    isset($haveItems['message']) ? $msg = $haveItems['message'] : null;
    exit(header("Location: ../?msg=$msg&alert=2"));
}
$deleteList = deleteList($id);
if(!$deleteList['success']){
    $alert = "&alert=1";
}

header("Location: ../?msg=".$deleteList['message']. $alert);
