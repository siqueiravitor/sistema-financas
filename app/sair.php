<?php

session_start();
session_destroy();
setcookie("USER_SESSION", '', 1,'/');
$_SERVER['PHP_AUTH_USER'] = null;
$_SERVER['PHP_AUTH_PW'] = null;

$msg = "Logout efetuado!";
header("location:../?msg=" . $msg);
