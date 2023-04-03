<?php
// verificar se página é um include, caso não, verificar se o acesso foi um request POST
// if($_SERVER["REQUEST_METHOD"] == "POST"){

if (!($data = token_parse($_SESSION['token']))) {
    unauthorized('WebVoid');
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
// função para decompor o http auth header
function token_parse($txt){
    // proteção contra dados incompletos
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