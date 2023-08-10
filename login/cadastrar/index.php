<!doctype html>
<html lang="pt-br">

<head>
    <title>Money Motion</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <link rel="icon" href="../img/favicon.png" />
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="../../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/vendor/animate-css/animate.min.css">
    <link rel="stylesheet" href="../../assets/vendor/font-awesome/css/font-awesome.min.css">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="../../assets/css/main.css">
    <link rel="stylesheet" href="../../assets/css/login.css">
    <script src="../validaSenha.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.getElementById('name').focus();
        })
    </script>
    <style>
        .alertError {
            border: 1px solid #dc3545 !important;
            background: #cd5c5c22 !important;
            color: #000 !important;
        }

        #msgAlert {
            color: #dc3545;
        }

        .alertSuccess {
            color: green !important;
        }
    </style>
</head>

<body>
    <form class="areaSignup" method="post" action="./createaccount.php" autocomplete="off" id='formSignUp'>
        <div class="loginCard ">
            <div class="">
                <div class="cardLeft">
                    <div class='imageArea'>
                        <img src="../../assets/images/logo.png" alt="Finanças">
                    </div>
                    <div class='text-center'>
                        <h4><span>Money</span>$Motion</h4>
                        <h5 class="text-muted">Finance-Manager</h5>
                    </div>
                </div>
            </div>
            <div class="ph-fix">
                <div class="cardRight">
                    <div class="text-center">
                        <h4>Cadastrar nova conta</h4>
                    </div>
                    <?php
                    if (!empty($_GET["msg"])) {
                        $msg = $_GET["msg"];
                        echo "<div class='text-center'><span class='alert-danger'>" . $msg . "</span></div>";
                    }
                    ?>
                    <div class="form-group">
                        <div class="text-center">
                            <span>Nome</span>
                        </div>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="Nome Sobrenome">
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <span>Email</span>
                        </div>
                        <input type="email" class="form-control" name="email" required placeholder="email@dominio.com">
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <span>Login</span>
                        </div>
                        <input type="text" class="form-control" name="user" required placeholder="usuario">
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <span>Senha</span>
                        </div>
                        <input type="password" class="form-control" name="password" id='password' required
                            placeholder="senha" onkeyup="verifyPassword()">
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <span>Repetir Senha</span>
                        </div>
                        <input type="password" class="form-control" id="repeatPassword" required 
                            placeholder="senha" onkeyup="verifyRepeatPassword()">
                    </div>
                    
                    <div class='text-center' id='msgAlert'></div>

                    <button type="submit" class="btn btn-primary btn-lg btn-block">Cadastrar</button>
                    <div class="bottomInfo d-flex flex-column align-items-center">
                        <a href="../../">Já possui conta?</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div id="footer">
        <div id="bottomSection">
            <small>
                <div class='text-center'>
                    ©
                    <?= date("Y") . " | Money Motion | Desenvolvido por " ?><a
                        href='https://www.linkedin.com/in/siqueira-vitor/' target="_blank">Vitor Siqueira</a>
                </div>
            </small>
        </div>
    </div>
</body>

</html>