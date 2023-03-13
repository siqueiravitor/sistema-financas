<?php
require '../vendor/autoload.php';

use Sinergi\BrowserDetector\Browser;
use Sinergi\BrowserDetector\Os;

$os = new Os();
$browser = new Browser();
$navegadoresSuportados = array('Chrome', 'Firefox', 'Opera');
if (in_array($browser->getName(), $navegadoresSuportados) || ($browser->getName() == 'Safari' && $os->getName() !== 'Windows')) {
    
} else {
    header("location: ../navegadorSemSuporte");
}

if (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    $msg = "Token inválido";
    header("location: ../../?msg=$msg");
}

$urlapi = "http://rotas.binare.com.br:3001/verificaToken/{$token}";
$ch = curl_init($urlapi);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$dados = json_decode($response, true)['response'];

if (!$dados) {
    $msg = "Token inválido";
    header("location: ../../?msg=$msg");
}

if (isset($_POST['senha'])) {
    $urlapi = "http://rotas.binare.com.br:3001/recuperaSenha/{$token}/{$_POST['senha']}";
    $ch = curl_init($urlapi);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $dados = json_decode($response, true);

    if ($dados['response']) {
        $msg = $dados['msg'];
        header("location: ../?msg=$msg&alert=0");
    } else {
        $msg = "Erro ao atualizar senha!";
        header("location: ../?msg=$msg");
    }
}
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <title>Recuperar senha</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <link rel="icon" href="img/favicon.png"/>
        <!-- VENDOR CSS -->
        <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/vendor/animate-css/animate.min.css">
        <link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.min.css">
        <!-- MAIN CSS -->
        <link rel="stylesheet" href="../app/assets/css/main.css">
        <link rel="stylesheet" href="../app/assets/css/color_skins.css">

        <script src="include/validaSenha.js"></script>    

        <style>
            *{
                --color-primary: #2271b1;
                --color-secondary: #606270;
            }
            body{
                background-color: #efefef;
                height: 100vh
            }
            .areaLogin{
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .loginCard{
                margin: 0px 1rem;
                border-radius: 4px;
                background: #fff;
                padding: 2rem;
                box-shadow: 3px 3px 20px 5px rgb(0 0 0 / 5%);
            }
            .loginCard div:first-child{
                border-color: #ccc!important
            }
            .cardLeft{
                height: 100%;
                display: flex;
                align-items: center;
                flex-direction: column;
                justify-content: center;
            }
            .cardLeft h4,
            .cardLeft h5{
                color: var(--color-tertiary);
            }
            .cardLeft h5{
                font-size: 1rem;
                letter-spacing: 2px;
            }
            .cardLeft h4{
                letter-spacing: 1px;
                margin: 10px 0 0;
                font-size: 2rem
            }
            .divisor{
                border-left: 1px solid var(--color-secondary);
                margin: 2rem 0;
            }
            .loginCard input{
                border: 1px solid #aaa;
                background: transparent;
                padding: 1.2rem 1.5rem;
                margin-bottom: .7rem;
                font-size: 1rem;
                color: #6B7982
            }
            .loginCard input:focus{
                border-color: var(--color-primary);
                color: var(--color-primary);
                background: #E8F0FE;
            }
            .loginCard .btn-primary{
                color: #fff;
                letter-spacing: 1px;
                background: var(--color-primary);
                border-color: var(--color-primary);
            }
            .loginCard .btn-primary:hover{
                background: #0f568f;
            }
            .esqueceuSenha, .esqueceuSenha a{
                margin-top: 1rem;
                color: #606270;
            }
            img {
                width: 100%;
                object-fit: contain;
                margin-left: .7rem
            }
            .form-group span{
                font-weight: bold;
            }

            .alertError{
                border: 1px solid #dc3545!important;
                background: #cd5c5c22!important;
                color: #000!important;
            }
            #msgAlert{
                color: #dc3545;
            }
            .alertSuccess{
                color: green!important;
            }
            @media (min-width: 768px){
                .loginCard{
                    padding: 1rem 4rem 4rem;
                }
            }
        </style>
    </head>
    <body>
        <form id="formAlteraSenha" class="areaLogin" onsubmit="event.preventDefault()"
              method="post" action="./mudaSenha.php?token=<?= $token ?>" autocomplete="off">
            <div class="loginCard ">
                <div class="cardLeft">
                    <div style="min-width: 10rem;max-width: 22rem;">
                        <img src="../assets/images/sistema_noBG.png" alt="Manutenção" >
                    </div>
                </div>
                <div class="cardRight ">
                    <div class="text-center mb-3" style="margin: 1rem; margin-top: -2rem">
                        <h4>Alterar senha</h4>
                    </div>

                    <div class="form-group">
                        <span>Nova Senha</span>
                        <input type="password" class="form-control" onkeyup="validaSenha()"
                               id="senha" name="senha" required placeholder="Senha">
                    </div>
                    <div class="form-group">
                        <span>Repita a Nova Senha</span>
                        <input type="password" class="form-control" onkeyup="validaRepetirSenha()"
                               id="repetirSenha" name="senha" required placeholder="Senha">
                    </div>
                    <div class='text-center' id='msgAlert'></div>

                    <button type="submit" class="btn btn-primary btn-lg btn-block mt-3">Alterar senha</button>
                </div>
            </div>
        </form>
    </body>
</html>