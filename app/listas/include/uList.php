<?php
require_once('../../../required.php');
include_once '../../config/config.php';
include_once '../../functions/func.php';
include_once '../../config/conn.php';
include_once './functions.php';

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
