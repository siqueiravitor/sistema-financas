<nav class="navbar navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-brand">
            <a href="<?= BASED; ?>">
                <img src="<?= BASE_ICO; ?>" alt="<?= NOME_EMPRESA; ?>" class="img-responsive logo">
                <span class="name"><?= SISTEMA; ?></span>
            </a>
        </div>

        <div class="navbar-right" >
            <ul class="list-unstyled clearfix mb-0 d-flex justify-content-between w-100">
                <li>
                    <div class="navbar-btn btn-toggle-show">
                        <button type="button" class="btn-toggle-offcanvas"><i class="lnr lnr-menu fa fa-bars"></i></button>
                    </div>                        
                    <a href="javascript:void(0);" class="btn-toggle-fullwidth btn-toggle-hide"><i class="fa fa-bars"></i></a>
                </li>
                <li class="d-flex align-self-center flex-grow-1">
                    <div id="navbar-search m-0">
                        <span style="vertical-align: middle;">
                            <?php
                            $usuario = str_replace('.', ' ', $_SESSION['nome']);
                            $nome = ucwords(strtolower($usuario));
                            $horario = date("H");
                            if ($horario >= 12 && $horario < 18) {
                                $salut = "Olá <b>{$nome}</b>, boa tarde!";
                            } else if ($horario >= 0 && $horario < 12) {
                                $salut = "Olá <b>{$nome}</b>, bom dia!";
                            } else {
                                $salut = "Olá <b>{$nome}</b>, boa noite!";
                            }
                            echo "$salut";
                            ?> 
                        </span>
                    </div>
                </li>
                <li>
                    <div id="navbar-menu">
                        <ul class="nav navbar-nav">
                            <?php
//                            include 'nav-notificacao.php';
                            ?>
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                                    <img class="rounded-circle border border-success box" src="<?= $_SESSION['foto'] ?>" width="30" height="30">
                                </a>
                                <div class="dropdown-menu animated flipInY user-profile" id="navProfile">
                                    <div class="d-flex p-3 align-items-center" style="background: #2271b1">
                                        <div class="drop-left m-r-10">
                                            <img src="<?= $_SESSION['foto'] ?>" class="rounded" width="50" alt="">
                                        </div>
                                        <div class="drop-right">
                                            <h4 style="color: #fff;"><?= $_SESSION["nome"] ?></h4>
                                        </div>
                                    </div>
                                    <div class="m-t-10 p-3 drop-list">
                                        <div style="text-align: center;"><?= TITLE ?></div>
                                        <ul class="list-unstyled">
                                            <li class="divider"></li>
                                            <li id="navPerfil"><a href="<?= BASED; ?>/perfil/"><i class="icon-user"></i>Meu Perfil</a></li>
                                            <li><a href="<?= BASED; ?>/sair.php" style='color:red'><i class="icon-power" style='color:red'></i>Sair</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div> 
</nav>