<?php

$uri = array_reverse(explode('/', $_SERVER['REQUEST_URI']));
if($uri[0] == 'include' || $uri[1] == 'include') {
    if (($_SERVER["REQUEST_METHOD"] == "POST" and empty($_SERVER['CONTENT_LENGTH']))
    or ($_SERVER["REQUEST_METHOD"] == "GET" and empty($_SERVER['QUERY_STRING']))){
        exit(header("location: ../"));
    }
}
