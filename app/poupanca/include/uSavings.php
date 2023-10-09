<?php
require_once('../../../required.php');
include_once '../../config/config.php';
include_once '../../functions/func.php';
include_once '../../config/conn.php';
include_once './functions.php';

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
