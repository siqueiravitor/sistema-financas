<?php
/* Mysql */
$con = mysqlI_connect("localhost", "root", "", "finance");

$sql = "SET NAMES 'utf8'";
mysqli_query($con, $sql);

$sql = 'SET character_set_connection=utf8';
mysqli_query($con, $sql);

$sql = 'SET character_set_client=utf8';
mysqli_query($con, $sql);

$sql = 'SET character_set_results=utf8';
$res = mysqli_query($con, $sql);