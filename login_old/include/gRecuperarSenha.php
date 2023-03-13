<?php

require '../../vendor/autoload.php';
include './connMysql.php';
include './gerarToken.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$email = $_POST['email'];
function enviarEmail($email, $mysql) {

    $mail = new PHPMailer(true);
    $emailEmisor = 'email.automatico@agilecorp.com.br';

    try {
        $sqlIdUsuario = "select id from mslogin.usuario where email = '$email'";
        $queryIdUsuario = mysqli_query($mysql, $sqlIdUsuario);
        $idUsuario = mysqli_fetch_array($queryIdUsuario)[0];
        
        $token = tokenSenha($mysql); // Gera Token
        
        $sqlTokenReset = "update mslogin.usuariotoken set status = 'i' where idusuario = $idUsuario";
        mysqli_query($mysql, $sqlTokenReset);
        $hoje = date("Y-m-d");
        $agora = date("H:i:s");
        $sqlToken = "insert into mslogin.usuariotoken (idusuario, token, status, datager, horager,) 
            values ($idUsuario, '$token', 'a', '$hoje', '$agora')";
        mysqli_query($mysql, $sqlToken);
        
        //Configurações do servidor
        $mail->isSMTP();   // ATIVAR SMTP
        $mail->Host = "webmail.agilecorp.com.br";  // SERVIDOR DE EMAIL
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Username = $emailEmisor;    // USUARIO
        $mail->Password = '123qwe!!';  // SENHA
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->port = 587;
        $mail->Charset = 'UTF-8';
        $mail->setFrom($emailEmisor, utf8_decode("App Manutenção"));

        //Recipients
        $mail->addAddress($email);

        $titulo = 'Recuperação de senha';
        $link = "https://manutencao.binare.com.br/login/mudaSenha.php?token=$token";
        $mail->isHTML(true);

        $email_template = 'mail_template.html';
        $mensagem = file_get_contents($email_template);
        $mensagem = str_replace('%email%', $email, $mensagem);
        $mensagem = str_replace('%link%', $link, $mensagem);
        
        $mail->Body = utf8_decode($mensagem);

        $mail->MsgHTML(utf8_decode($mensagem));
        $mail->Subject = utf8_decode($titulo);
        $mail->send();

        echo 'Email enviado';
        return true;
    } catch (Exception $e) {
        echo "Erro ao enviar o email. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

if(enviarEmail($email, $con)){
    $msg = "Email de recuperação de senha enviado!";
} else {
    $msg = "Erro ao enviar email!";
}

header("Location: ../../?msg=$msg&alert=0");

