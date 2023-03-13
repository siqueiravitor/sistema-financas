<?php
require './vendor/autoload.php';
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <title>App Binare</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <link rel="icon" href="login/img/favicon.png"/>
        <!-- VENDOR CSS -->
        <link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="./assets/vendor/animate-css/animate.min.css">
        <link rel="stylesheet" href="./assets/vendor/font-awesome/css/font-awesome.min.css">
        <!-- MAIN CSS -->
        <link rel="stylesheet" href="./app/assets/css/main.css">
        <link rel="stylesheet" href="./app/assets/css/color_skins.css">

        <style>
            *{
                --color-primary: #3b4654;
                --color-secondary: #0dcaf0;
                --color-tertiary: #606270;
                --btn-primary: #2271b1;
                --color-success: #269471;
                --color-warning: #ffcc33;
                --color-danger: #f32013;
                --color-dark: #212529;
                --color-text-ligh: #6c757d;
                /*
                #2a323c
                #323c48
                #3b4654
                #04a2b3
                #c5d0d5
                #2271
                */
            }
            *:not(i){
                font-family: 'montserrat'!important;
            }
            body{
                /*background-color: #c5d0d5;*/
                /*background-color: #2271b122;*/
                background-color: #f1f5f7;
                height: 100vh
            }
            .areaLogin{
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .loginCard{
                /*width: 100%;*/
                min-width: 80%;
                margin: 0px 1rem;
                border-radius: 4px;
                background: #fff;
                padding: 2rem;
                box-shadow: 0 2px 2px 0 rgb(0 0 0 / 7%),
                    0 3px 1px -2px rgb(0 0 0 / 6%),
                    0 1px 5px 0 rgb(0 0 0 / 10%);
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
            .cardLeft h5,
            .cardLeft h4{
                color: var(--color-tertiary);
            }
            .cardLeft h5{
                font-size: .9rem;
                letter-spacing: 1px;
            }
            .cardLeft h4{
                letter-spacing: 1px;
                margin: 10px 0 0;
                font-size: 2.5rem
            }
            .cardRight{
                padding-top: 2rem;
            }
            .divisor{
                border-left: 1px solid var(--color-tertiary);
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
                border-color: var(--btn-primary);
                color: var(--color-primary);
                background: #E8F0FE!important;
            }
            .loginCard .btn-primary{
                color: #fff;
                letter-spacing: 1px;
                background: var(--btn-primary);
                border-color: var(--btn-primary);
            }
            .loginCard .btn-primary:hover{
                background: #0f568f;
            }
            .bottomInfo{
                /*margin-top: 1rem;*/
            }
            .bottomInfo a{
                margin-top: 1rem;
                display: block;
                color: #606270;
            }
            img {
                width: 100%;
                object-fit: contain;
            }
            .form-group span{
                font-weight: bold;
            }
            .ph-fix{
                padding-left: 0!important;
                padding-right: 0!important;
            }
            
            
            .alert-danger{
                color: var(--color-danger);
                background: none;
            }

            @media (min-width: 1440px){
                .loginCard{
                    min-width: 30%!important;
                }
                .ph-fix{
                    padding-left: 15px!important;
                    padding-right: 15px!important;
                }
            }
            @media (min-width: 768px) and (max-width: 1439px){
                .loginCard{
                    min-width: 50%!important;
                }
            }
            @font-face {
                font-family: 'montserrat';
                src: url("./login/montserrat.ttf") format("truetype");
                font-weight: normal;
                font-style: normal
            }
        </style>
    </head>
    <body>
        <form class="areaLogin" method="post" action="./login/verLogin.php" autocomplete="off">
            <div class="loginCard ">
                <div class="">
                    <div class="cardLeft">
                        <div style="min-width: 10rem;max-width: 12rem;">
                            <img src="./assets/images/logo.png" alt="Finanças" >
                        </div>

                        <h4>Finanças</h4>
                        <h5 class="text-muted">SyntaxWeb</h5>
                    </div>
                </div>
                <div class="ph-fix">
                    <div class="cardRight ">
                        <div class="text-center">
                            <h4>Acessar conta</h4>
                        </div>
                        <?php
                        if (!empty($_GET["msg"])) {
                            $msg = $_GET["msg"];
                            echo "<div class='text-center'><span class='alert-danger'>" . $msg . "</span></div>";
                        }
                        ?>
                        <div class="form-group">
                            <span>Usuário</span>
                            <input type="text" class="form-control" name="usuario" required placeholder="usuario">
                        </div>
                        <div class="form-group">
                            <span>Senha</span>
                            <input type="password" class="form-control" name="senha" required placeholder="senha">
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block">Acessar</button>
                        <div class="bottomInfo text-center">
                            <a href="login/esqueceuSenha">Esqueceu a senha?</a>
                            <a href="login/criarConta">Criar nova conta</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>