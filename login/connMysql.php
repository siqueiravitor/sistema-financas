<?php
error_reporting(E_ERROR | E_PARSE);
$host = 'localhost';
$user = 'root';
$pass = '';
$shma = 'financa';

try{
    $con = mysqli_connect($host, $user, $pass, $shma);
} catch (Exception $e){
    printf("Connect failed: %s\n", mysqli_connect_error());
    $msg = "Database failed: Sistema fora do ar";
    exit(header("Location: ../?msg=$msg"));
}

$sql1 = "SET NAMES 'utf8'";
mysqli_query($con, $sql1);

$sql2 = 'SET character_set_connection=utf8';
mysqli_query($con, $sql2);

$sql3 = 'SET character_set_client=utf8';
mysqli_query($con, $sql3);

$sql4 = 'SET character_set_results=utf8';
$res = mysqli_query($con, $sql4);