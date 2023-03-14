<?php
//require './vendor/autoload.php';
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <title>E-Finanças</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        
        <link rel="icon" href="login/img/favicon.png"/>
        <!-- VENDOR CSS -->
        <link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="./assets/vendor/animate-css/animate.min.css">
        <link rel="stylesheet" href="./assets/vendor/font-awesome/css/font-awesome.min.css">
        <!-- MAIN CSS -->
        <link rel="stylesheet" href="./assets/css/main.css">
        <link rel="stylesheet" href="./assets/css/login.css">
    </head>
    <body>
        <form class="areaLogin" method="post" action="./login/verLogin.php" autocomplete="off">
            <div class="loginCard ">
                <div class="">
                    <div class="cardLeft">
                        <div class='imageArea'>
                            <img src="./assets/images/logo.png" alt="Finanças" >
                        </div>

                        <h4><span>E</span>-Finanças</h4>
                        <h5 class="text-muted">SyntaxWeb</h5>
                    </div>
                </div>
                <div class="ph-fix">
                    <div class="cardRight">
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
                            <div class="text-center">
                                <span>Usuário</span>
                            </div>
                            <input type="text" class="form-control" name="user" required placeholder="usuario">
                        </div>
                        <div class="form-group">
                            <div class="text-center">
                                <span>Senha</span>
                            </div>
                            <input type="password" class="form-control" name="password" required placeholder="senha">
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block">Acessar</button>
                        <div class="bottomInfo d-flex flex-column align-items-center">
                            <a href="login/esqueceuSenha">Esqueceu a senha?</a>
                            <a href="login/criarConta">Criar nova conta</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>