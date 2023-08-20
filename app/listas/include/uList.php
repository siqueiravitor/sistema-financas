<?php
require('../../../required.php');
include '../../config/config.php';
include '../../config/security.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

$list = filter_input_array(INPUT_POST, [
    "id" => FILTER_SANITIZE_NUMBER_INT,
    "title" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "description" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
]);

$id = $list['id'];
$title = $list['title'];
$description = $list['description'];

$dataList = [
    'id' => $id,
    'title' => $title,
    'description' => $description,
];

$updateList = updateList($dataList);
if(!$updateList['success']){
    $alert = "&alert=1";
}

header("Location: ../?msg=".$updateList['message']. $alert);
