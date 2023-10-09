<?php
require_once('../../../required.php');
include_once '../../config/config.php';
include_once '../../functions/func.php';
include_once '../../config/conn.php';
include_once './functions.php';

$msg = 'Dados registrados';

$listFilter = filter_input_array(INPUT_POST, [
    "category" => FILTER_SANITIZE_NUMBER_INT,
    "title" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "description" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "type" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
]);

$title = $listFilter['title'];
$id_category = $listFilter['category'];
$description = empty($listFilter['description']) ? null : $listFilter['description'];
$type = $listFilter['type'];

$list = [
    'title' => $title,
    'id_category' => $id_category,
    'description' => $description,
    'type' => $type
];

if(!createList($list)){
    $msg = 'Erro ao registrar dados';
    $msg .= "&alert=1";
}

header("Location: ../?msg=$msg");