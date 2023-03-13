<?php
require '../vendor/autoload.php';
include '../app/config/connMysql.php';

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
    header("location: ../index?msg=Token não existe.");
}

if (isset($_GET['status'])) {
    $status = $_GET['status'];
    $text = $_GET['text'];
} else {
    $status = null;
    $text = null;
}
$agora = date('Y-m-d H:i:s'); //            -- Horario atual
$sqlToken = "select 
                    idusuario, 
                    datger,
                    token,
                    usado 
             from tokensenha 
             where token = '{$token}'";
$respToken = mysqli_query($con, $sqlToken);
$rowToken = mysqli_fetch_array($respToken);
$datatime1 = strtotime($agora);
$datatime2 = strtotime($rowToken[1]);


if (mysqli_num_rows($respToken) < 0 || $token != $rowToken[2]) {
     header("location: ../index?msg=Token inválido.");
} else if (($datatime1 - $datatime2) / 60 > 30) {
    header("location: ../index?msg=Token expirado.");
} else if ($rowToken[3] == 's') {
    header("location: ../index?msg=Token já foi utilizado.");
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
        <script type="text/javascript">
            function verificaSenha(ope) {
                $.ajax({
                    url: "include/cSenha.php",
                    type: "GET",
                    data: {
                        novaSenha: $("#novaSenha1").val(),
                        ope
                    },
                    success: function (resposta) {
                        if (ope === "nova") {
                            if (resposta === "Senha Forte") {
                                $('#novaSenhaLabel').css('color', '#009900');
                            } else if (resposta === "Senha Fraca") {
                                $('#novaSenhaLabel').css('color', '#ff0000');
                            } else {
                                $('#novaSenhaLabel').css('color', '');
                            }
                            $('#novaSenhaLabel').html(resposta);
                        }
                    }
                });
            }
            function verificaNovaSenha() {
                var senhaNova1 = $("#novaSenha1").val();
                var senhaNova2 = $("#novaSenha2").val();
                if (senhaNova1 === senhaNova2) {
                    $('#novaSenhaLabel2').css('color', '#009900');
                    $('#novaSenhaLabel2').html("Senha confirmada");
                } else {
                    $('#novaSenhaLabel2').css('color', '#ff0000');
                    $('#novaSenhaLabel2').html("Senhas não coincidem");
                }
            }
            function verificaForm() {
                var senhaNova1 = $("#novaSenhaLabel").html();
                var senhaNova2 = $("#novaSenhaLabel2").html();
                if (senhaNova1 === "Senha Forte" && senhaNova2 === "Senha confirmada") {
                    $('#form').submit();
                } else {
                    return false;
                }
            }

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
                                    <h4 class="title" id="smallModalLabel">Alterar senha</h4>
                                    </p>
                                </div>
                                <div class="body">
                                    <form id="form" action="include/aSenha.php" method="post" onsubmit="verificaForm();
                                            return false;">
                                        <div class="col-lg-12 col-md-12 mb-3">
                                            <h6>Nova Senha</h6>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="icon-lock"></i></span>
                                                </div>
                                                <input type="password" onkeyup="verificaSenha('nova');
                                                        verificaNovaSenha()" name="novaSenha" id="novaSenha1" required class="form-control">
                                            </div>
                                            <b><small id="novaSenhaLabel"></small></b>
                                        </div>

                                        <div class="col-lg-12 col-md-12 mb-3">
                                            <h6>Repita a Nova Senha</h6>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="icon-lock"></i></span>
                                                </div>
                                                <input type="password" id="novaSenha2" onkeyup="verificaNovaSenha()" required class="form-control">
                                            </div>
                                            <br><b><small id="novaSenhaLabel2"></small></b>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <input type="text" value="<?= $token ?>" hidden name="token">
                                            <input type="text" value="<?= $rowToken[0] ?>" hidden name="idusuario">
                                            <button type="submit" id="botao" class="btn btn-primary btn-lg btn-block">Alterar</button>
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
        <!-- Javascript -->
        <script src="../app/assets/bundles/libscripts.bundle.js"></script>    
        <script src="../app/assets/bundles/vendorscripts.bundle.js"></script> 
        <script src="../app/assets/bundles/mainscripts.bundle.js"></script>
    </body>
</html>