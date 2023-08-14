<?php
require('../../../required.php');
include '../../config/config.php';
include '../../config/security.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

$msg = 'Dados registrados';

$categoryFilter = filter_input_array(INPUT_POST, [
    "type" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "description" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
]);

$type = $categoryFilter['type'] ? $categoryFilter['type'] : null;
$description = empty($categoryFilter['description']) ? null : $categoryFilter['description'];

$category = [
    'type' => $type,
    'description' => $description
];

if(!createCategory($category)){
    $msg = 'Erro ao registrar dados';
    $msg .= "&alert=1";
}

header("Location: ../?msg=$msg");