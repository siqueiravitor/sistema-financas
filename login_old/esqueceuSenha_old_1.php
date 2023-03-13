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
            .checkbox {
                display: flex;
                flex-direction: row;
                justify-content: center;
                align-items: center;
                margin-bottom: 10px;
            }
            .logo {
                position: relative;
                top: 2%;
            }
            .img-fluid {
                height: auto !important;
            }
            .auth-right {
                top: 10%;
            }
            .auth-main .auth-box .auth-left::before {
                content: "";
                width: 300px;
                height: 100%;
                background-color: #fff;
                position: absolute;
                left: 0;
                border-radius: 12px 0 0 12px;
            }


            .auth-main .auth-box .auth-left .left-top img {
                width: 107px;
            }
            .auth-main .auth-box .lead {
                font-size: 20px;
                font-weight: 400;
            }   
        </style>
        <script>
            document.addEventListener("DOMContentLoaded", function (event) {
                var status = "<?= $status ?>";
                var text = document.createElement("div");
                text.innerHTML = "<?= $text ?>";
                if (status != "") {
                    swal({
                        title: "",
                        content: text,
                        icon: status,
                    });
                }
            });
        </script>
    </head>
    <body class="theme-blue">
        <div id="wrapper">
            <div class="vertical-align-wrap">
                <div class="vertical-align-middle auth-main">
                    <div class="auth-box">
                        <div class="auth-left">
                            <div class="left-slider">
                                <img src="../assets/images/login/1.jpg" class="img-fluid" alt="">
                            </div>
                        </div>
                        <div class="auth-right">
                            <div class="card">
                                <div class="header">
                                    <p class="lead">
                                        Recuperar senha
                                    </p>
                                </div>
                                <div class="body">
                                    <form class="form-auth-small" method="post" action="include/gEmailRecuperacao.php" autocomplete="off">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-user-following"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="usuario" name="usuario" required placeholder="Matrícula / E-mail">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">Alterar senha</button>
                                        <div class="bottom">
                                            <span class="helper-text m-b-10"><i class="fa fa-lock"></i> 
                                                <a href="../index">Sabe a sua senha? Clique aqui</a>
                                            </span>                                            
                                        </div>
                                    </form>
                                    <div class="modal" id="modal" tabindex="-1" role="dialog">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>