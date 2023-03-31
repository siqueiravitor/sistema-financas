<?php
session_start();

$realm = "SyntaxWeb";

function authenticate($realm) {
    setcookie("SESSION", '', 1,'/'); 
    header('WWW-Authenticate: Basic realm="'.$realm.'", qop="auth", opaque="' . md5($realm) . '"');
    header('HTTP/1.0 401 Unauthorized');
    
    return 'Credenciais inválidas!';
}
echo "<PRE>";

$user = $_SERVER['PHP_AUTH_USER'];
$pass = $_SERVER['PHP_AUTH_PW'];

// Validar sessão
if (!isset($_SESSION["user"])) {
    session_destroy();
    $msg = "Sem acesso! =[";
    exit(header("location:../?msg=" . $msg));
}
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    if(!$auth = authenticate($realm)){

    }
}
// analisar a variável PHP_AUTH_DIGEST
if (!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) || !isset($users[$data['username']])) {
    echo 'Credenciais inválidas!';
    // die('Credenciais inválidas!');
}
// função para decompor o http auth header
function http_digest_parse($txt)
{
    // proteção contra dados incompletos
    $needed_parts = array('nonce' => 1, 'qop' => 1, 'response' => 1);
    $data = array();
    $keys = implode('|', array_keys($needed_parts));

    preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

    foreach ($matches as $m) {
        $data[$m[1]] = $m[3] ? $m[3] : $m[4];
        unset($needed_parts[$m[1]]);
    }

    return $needed_parts ? false : $data;
}
 
// if (!isset($_SERVER['PHP_AUTH_USER']) ||
//     ($_POST['SeenBefore'] == 1 && $_POST['OldAuth'] == $_SERVER['PHP_AUTH_USER'])) {
//     authenticate();
// } else {
//     echo "<p>Welcome: " . htmlspecialchars($_SERVER['PHP_AUTH_USER']) . "<br />";
//     echo "Old: " . htmlspecialchars($_REQUEST['OldAuth']);
//     echo "<form action='' method='post'>\n";
//     echo "<input type='hidden' name='SeenBefore' value='1' />\n";
//     echo "<input type='hidden' name='OldAuth' value=\"" . htmlspecialchars($_SERVER['PHP_AUTH_USER']) . "\" />\n";
//     echo "<input type='submit' value='Re Authenticate' />\n";
//     echo "</form></p>\n";
// }
// if(!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) || !isset($users[$data['username']])){
//     die('Credenciais inválidas!');
// }


print_r($_SERVER);

exit();
define('COMPANY', $_SESSION['COMPANY']);
define('SYSTEM', $_SESSION['SYSTEM']);
define('TITLE', $_SESSION['TITLE']);
define('VERSION', $_SESSION['VERSION']);
define('LOGO', $_SESSION['LOGO']);
define('LOGOALT', $_SESSION['LOGOALT']);
define('BASE', $_SESSION['BASEF']);
define('BASED', $_SESSION['BASED']);
define('BASES', $_SESSION['BASES']);
define('ICON', $_SESSION['BASEI']);

// UTF-8 Portugues Brasil \\
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

// Verificar se sistema esta ativo/inativo/manutenção

// Tempo limit de logado
//if ($_SESSION["timer"] + 10 * 60 < time()) {
//    session_destroy();
//    $msg = "Sessão expirada";
//    header("location: ../?msg=" . $msg);
//} else {
//    $_SESSION["tempo"] = time();
//}
ob_start();