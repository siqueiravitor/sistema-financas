<?php

$uri = array_reverse(explode('/', $_SERVER['REQUEST_URI']));
if($uri[0] == 'include' || $uri[1] == 'include') {
    if (($_SERVER["REQUEST_METHOD"] == "POST" and empty($_SERVER['CONTENT_LENGTH']))
    or ($_SERVER["REQUEST_METHOD"] == "GET" and empty($_SERVER['QUERY_STRING']))){
        exit(header("location: ../"));
    }
}

if (!($data = token_parse($_SESSION['token']))) {
    unauthorized('SpiderCode');
}

function unauthorized($realm){
    header('WWW-Authenticate: Basic realm="' . $realm . '", qop="auth", opaque="' . md5($realm) . '"');
    header('HTTP/1.0 401 Unauthorized');
    setcookie("SESSION", '', 1,'/'); 
    setcookie("USER_SESSION", '', 1,'/');
    unset($_SESSION);
    session_destroy();
    $msg = 'Credenciais inválidas!';
    exit(header("location: ../?msg=" . $msg));
}
function token_parse($txt){
    $needed_parts = array('nonce' => 1, 'username' => 1, 'uri' => 1, 'response' => 1, 'opaque' => 1, 'realm' => 1);
    $data = array();
    $keys = implode('|', array_keys($needed_parts));

    preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', base64_decode($txt), $matches, PREG_SET_ORDER);

    foreach ($matches as $m) {
        $data[$m[1]] = $m[3] ? $m[3] : $m[4];
        unset($needed_parts[$m[1]]);
    }

    return $needed_parts ? false : $data;
}