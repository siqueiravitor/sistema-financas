<?php
error_reporting(E_ERROR | E_PARSE);

$host = $_ENV['HOST'];
$user = $_ENV['USER'];
$pass = $_ENV['PASS'];
$shma = $_ENV['SHMA'];
$con = mysqli_connect($host, $user, $pass, $shma);

if (!$con) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    $msg = "Database failed: Sistema fora do ar";
    session_destroy();
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