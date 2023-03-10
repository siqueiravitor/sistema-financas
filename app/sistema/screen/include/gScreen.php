<?php
include '../config/config.php';
include '../config/func.php';
include '../config/connMysql.php';
//require '../vendor/autoload.php';            

echo "<pre>";
print_r($_POST);

$name = $_POST['name'];
$icon = $_POST['icon'];
$link = $_POST['link'];
$directory = $_POST['directory'];
$description = $_POST['description'];


echo $name . "<BR>";
echo $icon . "<BR>";
echo $link . "<BR>";
echo $directory . "<BR>";
echo $description . "<BR>";
return;