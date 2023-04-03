<?php
session_start();
session_destroy();
setcookie("SESSION", '', 1,'/'); 
setcookie("USER_SESSION", '', 1,'/');
unset($_SESSION);
$msg = "Logout efetuado!";
header("location:../?msg=" . $msg);
