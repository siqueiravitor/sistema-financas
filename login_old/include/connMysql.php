<?php
/* Mysql */
$schemaBase = "mslogin";
$con = mysqlI_connect("hmlmysql01.corp.milanobrasil.com.br", "root", "MySql@2018!!", $schemaBase); // connJF - Servidor

$sql = "SET NAMES 'utf8'";
mysqli_query($con, $sql);

$sql = 'SET character_set_connection=utf8';
mysqli_query($con, $sql);

$sql = 'SET character_set_client=utf8';
mysqli_query($con, $sql);

$sql = 'SET character_set_results=utf8';
$res = mysqli_query($con, $sql);