<?php

function getUserIP() {
    $client = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote = $_SERVER['REMOTE_ADDR'];

    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }

    return $ip;
}

$ipusuario = getUserIP();
if(empty(trim($_POST['usuario'])) || empty(trim($_POST['senha']))){
    header("Location: ../?msg=Preencha email e senha");
}

$urlapi = "http://rotas.binare.com.br:3001/login/{$_POST['usuario']}/{$_POST['senha']}/{$ipusuario}/1";

$ch = curl_init($urlapi);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$dados = json_decode($response, true);

if ($dados['response'] == 1) {
    /* URL do dominio */
    $protocolo = (strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === false) ? 'http' : 'https';
    $host = $_SERVER['HTTP_HOST'];
    $url = $protocolo . '://' . $host;

    session_start();
    $_SESSION['empresa'] = 'binare';
    $_SESSION['iduser'] = $dados['dados']['id'];
    $_SESSION['user'] = $dados['dados']['login'];
    $_SESSION['status'] = $dados['dados']['status'];
    $_SESSION['nome'] = $dados['dados']['nome'];
    $_SESSION['email'] = $dados['dados']['email'];
    $_SESSION['idempresa'] = $dados['dados']['idempresa'];
    $_SESSION['temp'] = time();
    $_SESSION['token'] = $dados['token'];
    $foto = $dados['dados']['foto'];
    $_SESSION['foto'] = $foto ? "$url/app{$foto}" : "$url/assets/images/central/perfil.png";
    header('Location: ../app/');
} else {
    header("location: ../index?msg=" . $dados['msg']);
}
