<?php
require('../../../required.php');
include '../../config/config.php';
include '../../config/security.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

$msg = 'Dados registrados';

$listFilter = filter_input_array(INPUT_POST, [
    "title" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "description" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
]);

$title = $listFilter['title'];
$description = empty($listFilter['description']) ? null : $listFilter['description'];

$list = [
    'title' => $title,
    'description' => $description
];

if(!createList($list)){
    $msg = 'Erro ao registrar dados';
    $msg .= "&alert=1";
}

header("Location: ../?msg=$msg");