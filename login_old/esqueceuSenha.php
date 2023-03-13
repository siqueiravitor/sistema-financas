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

if (isset($_GET['status'])) {
    $status = $_GET['status'];
    $text = $_GET['text'];
} else {
    $status = null;
    $text = null;
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

            #msgAlert{
                position: relative;
                text-align: center;
            }
            #msgAlert span{
                position: absolute; 
                top: -3rem; 
                right: 0; 
                left: 0
            }

            @media (min-width: 768px){
                .loginCard{
                    padding: 1rem 4rem 4rem;
                }
            }
        </style>
        <script>
            document.addEventListener("DOMContentLoaded", function (event) {
                document.getElementById('email').focus();
            });
        </script>
    </head>
    <body>
        <form class="areaLogin" method="post" action="./include/gRecuperarSenha.php" autocomplete="off">
            <div class="loginCard ">
                <div class="cardLeft">
                    <div style="min-width: 10rem;max-width: 22rem;">
                        <img src="../assets/images/sistema_noBG.png" alt="Manutenção" >
                    </div>
                </div>
                <div class="cardRight ">
                    <?php
                    if (isset($_GET['msg'])) {
                        echo "<div class='text-danger' id='msgAlert'><span>{$_GET['msg']}</span></div>";
                    }
                    ?>
                    <div class="text-center mb-3" style="margin: 1rem; margin-top: -2rem">
                        <h4>Recuperar senha</h4>
                    </div>
                    <div class="form-group">
                        <span>E-mail</span>
                        <input type="text" class="form-control" id="email" name="email" required placeholder="email">
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg btn-block">Enviar email</button>
                    <div class="esqueceuSenha text-center ">
                        <a href="../"> <i class="fa fa-lock mr-1"></i>Sabe a sua senha? Clique aqui</a>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>