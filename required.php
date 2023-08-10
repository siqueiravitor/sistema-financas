<?php

define("PATH_REQUIRE", __DIR__);

require_once(PATH_REQUIRE ."/vendor/autoload.php");
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/config');
$dotenv->safeLoad();
