<?php
require './vendor/autoload.php';
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <title>Finanças</title>
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
            /* 2271b1 - primary   */
            /* 606270 - secondary */
            /* 269471 - success   */
            /* 0dcaf0 - info      */
            /* ffcc33 - warning   */
            /* f32013 - danger    */

            /*
                0dcaf0 - blue cyan
                212529 - dark gray
                6c757d - gray
            */
            *{
                margin: 0;
                padding: 0;

                --color-primary: #2271b1;
                --color-secondary: #0dcaf0;
                --color-tertiary: #606270;
                --color-success: #269471;
                --color-warning: #ffcc33;
                --color-danger: #f32013;
                --color-dark: #212529;
                --color-text-ligh: #6c757d;
            }
            body{
                width: 100%;
                height: 100vh;
                background-color: #000; 
                display:flex;
                justify-content: center;
                align-items: center;
            }

            .loginArea{
                background-color: var(--color-dark);
                padding: 2rem;
                border-radius: 4px;
                border: 1px solid var(--color-secondary);
                width: 25rem;
                box-shadow: 0 0px 5px #0dcaf077;
                text-align: center;
            }
            h5{
                color: var(--color-secondary);
                margin-bottom: 1rem;
                letter-spacing: 1px
            }
            .btn-primary{
                background: var(--color-primary);
                letter-spacing: 1px;
                border-color: var(--color-primary);
                margin-top: 1.5rem;
            }
            .input-group-text{
                color: #0dcaf0;
                background-color: transparent;
                border: 1px solid var(--color-primary);
                margin-right: .3rem;
                width: 2.5rem;
                display: flex;
                justify-content: center;
            }
            .form-control{
                background-color: transparent!important;
                border: none;
                border: 1px solid var(--color-primary);
                color: #ccc;
            }
            .form-control:focus {
                border: 1px solid var(--color-secondary);
                color: #fff
            }
            .alert-danger{
                color: var(--color-danger);
                background: none;
            }
            .password:hover {
                background: var(--color-primary);
                color: #fff;
                cursor: pointer
            }
            .password:active {
                background: var(--color-tertiary);
                color: #fff;
                cursor: pointer
            }
        </style>
        <script>
            function passwordVisibility(){
                let passwordElement = document.getElementById('password');
                let passwordType = passwordElement.getAttribute('type');
                
                let passwordIcon = document.getElementById('password-icon');
                
                if(passwordType === 'password'){
                    passwordElement.setAttribute('type', 'text');
                    passwordIcon.classList.add('fa-unlock-alt');
                } else {
                    passwordElement.setAttribute('type', 'password');
                    passwordIcon.classList.remove('fa-unlock-alt');
                }
            }
        </script>
    </head>
    <body>
        <div class="loginArea">
            <h5>Login</h5>
            <?php
            if (!empty($_GET["msg"])) {
                $msg = $_GET["msg"];
                echo "<span class='alert-danger'>" . $msg . "</span>";
            }
            ?>
            <form class="form-auth-small" method="post" action="./login/verLogin.php" autocomplete="off">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="usuario" name="user" required placeholder="User">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text password" onclick="passwordVisibility()">
                            <i id="password-icon" class="fa fa-lock"></i>
                        </span>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" required placeholder="Password">
                </div>                                        
                <button type="submit" class="btn btn-primary btn-lg btn-block">Acessar</button>
            </form>

        </div>
    </body>

</html>