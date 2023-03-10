<?php
include '../../config/config.php';
include '../../config/func.php';
include '../../config/connMysql.php';

echo "<pre>";
print_r($_POST);
$date = $_POST['date'];
$value = $_POST['value'];
$category = $_POST['category'];
$recurrence = $_POST['recurrence'];
$description = $_POST['description'];