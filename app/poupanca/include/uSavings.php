<?php
require('../../../required.php');
include '../../config/config.php';
include '../../config/security.php';
include '../../functions/func.php';
include '../../config/connMysql.php';
include './functions.php';

$filter = filter_input_array(INPUT_POST, [
    "id" => FILTER_SANITIZE_NUMBER_INT,
    "goal" => FILTER_SANITIZE_NUMBER_FLOAT,
    "name" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "description" => FILTER_SANITIZE_FULL_SPECIAL_CHARS
]);

$id = $filter['id'];
$goal = moneyToFloat($filter['goal']);
$name = $filter['name'];
$description = $filter['description'];

$data = [
    'id' => $id,
    'goal' => $goal,
    'name' => $name,
    'description' => $description,
];

$update = updateSavings($data);

if(!$update['success']){
    $alert = "&alert=1";
}

header("Location: ../?msg=".$update['message']. $alert);
