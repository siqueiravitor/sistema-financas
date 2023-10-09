<?php
require_once('../../../required.php');
include_once '../../config/config.php';
include_once '../../functions/func.php';
include_once '../../config/conn.php';
include_once './functions.php';

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