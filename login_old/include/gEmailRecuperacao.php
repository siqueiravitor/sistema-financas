<?php

require '../../vendor/autoload.php';
include '../../app/config/connMysql.php';

use PHPMailer\PHPMailer\PHPMailer;

$login = $_POST['usuario'];

$sqlEmail = "select 
                email,
                nome,
                idusuario 
            from app.usuario 
            where login = '$login'";
$respEmail = mysqli_query($con, $sqlEmail);

if (mysqli_num_rows($respEmail) > 0) {
    $rowEmail = mysqli_fetch_array($respEmail);

    $email = $rowEmail[0];
    $nome = $rowEmail[1];
    $idusuario = $rowEmail[2];

    $token = date('YmdHms') . rand(1000, 99999);
    $agora = date('Y-m-d H:i:s');

    $PhpMailer = new PHPMailer(true);
//  Server settings
    $PhpMailer->isSMTP();
    $PhpMailer->Host = "webmail.agilecorp.com.br"; //Servidor de email
    $PhpMailer->SMTPAuth = true;
    $PhpMailer->Username = 'rodrigo.martins@agilecorp.com.br'; //Usuario
    $PhpMailer->Password = 'Rhsm#09071997'; //Senha
    $PhpMailer->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $PhpMailer->Port = 587; //Porta
    $PhpMailer->Charset = 'UTF-8';
    $PhpMailer->setFrom("rodrigo.martins@agilecorp.com.br", "NAO RESPONDA"); // -> MUDAR DEPOIS
    try {
        $corpo = "Acesse o link abaixo para alterar sua senha do app.binare.com.br<br><a href='https://app.binare.com.br/app_dev/login/mudaSenha?token=$token'>Clique aqui</a>";

        $PhpMailer->addAddress($email, $nome); //Destinatario - manter
//      Content
        $PhpMailer->isHTML(true);
        $PhpMailer->Subject = utf8_decode('Recuperação de senha!');
        $PhpMailer->Body = utf8_decode($corpo);
        $PhpMailer->send();

        $insetToken = "insert into tokensenha value(
                                null,
                                {$idusuario},
                                {$token},
                                    'n',
                                '{$agora}'
                                )";
        mysqli_query($con, $insetToken);

        $msg = 'Foi enviado um link para realizar a alteração de senha para o seu e-mail';
    } catch (Exception $e) {
        $erro = "Email não pode ser enviado $e";
    }
} else {
    $msg = "Esta conta não possui um e-mail vinculado, abrir chamado em <a class='text-dark btn btn-link' href='http://suporte.binare.com.br/index.php'>Sistema de Gestão de Serviços</a>";
}
//
mysqli_close($con);
header("location: ../../index?msg=" . $msg);

