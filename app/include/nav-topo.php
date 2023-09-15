<nav class="navbar navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-brand" style="overflow: hidden;">
            <a href="<?= BASED; ?>">
                <img src="<?= LOGOALT; ?>" alt="<?= COMPANY; ?>" class="img-responsive logo">
                <span class="name">
                    <?= SYSTEM; ?>
                </span>
            </a>
        </div>

        <div class="navbar-right">
            <ul class="list-unstyled clearfix mb-0 d-flex justify-content-between w-100">
                <li>
                    <div class="navbar-btn btn-toggle-show">
                        <button type="button" class="btn-toggle-offcanvas"><i
                                class="lnr lnr-menu fa fa-bars"></i></button>
                    </div>
                    <a href="javascript:void(0);" class="btn-toggle-fullwidth btn-toggle-hide"><i
                            class="fa fa-bars"></i></a>
                </li>
                <li class="d-flex align-self-center flex-grow-1">
                    <div id="navbar-search m-0">
                        <span style="vertical-align: middle;">
                            <?php
                            $user = str_replace('.', ' ', $_SESSION['name']);
                            $name = ucwords(strtolower($user));
                            $hour = date("H");
                            if ($hour >= 12 && $hour < 18) {
                                $salut = "Olá <b>{$name}</b>, boa tarde!";
                            } else if ($hour >= 0 && $hour < 12) {
                                $salut = "Olá <b>{$name}</b>, bom dia!";
                            } else {
                                $salut = "Olá <b>{$name}</b>, boa noite!";
                            }
                            echo "$salut";
                            ?>
                        </span>
                    </div>
                </li>
                <li class="d-flex align-self-center">
                    <div id="navbar-menu">
                        <ul class="nav navbar-nav">
                            <?php
                            //                            include 'nav-notificacao.php';
                            ?>
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                                    <?php
                                            if(isset($_SESSION['foto'])){
                                                echo "<img src='{$_SESSION['foto']}' class='rounded-circle border border-success box' width='30' height='30' alt='profilephoto'>";
                                            } else {
                                                echo "<img src='". BASED."/assets/images/perfil/003.png' class='rounded' width='30' height='30' alt='profilephoto'>";
                                            }
                                        ?>    
                                </a>
                                <div class="dropdown-menu animated fadeIn user-profile" id="navProfile">
                                    <div class="d-flex p-3 align-items-center bg-gradient-dark-gray">
                                        <div class="drop-left m-r-10">
                                            <?php
                                                if(isset($_SESSION['foto'])){
                                                    echo "<img src='{$_SESSION['foto']}' class='rounded' width='50' alt='profilephoto'>";
                                                } else {
                                                    echo "<img src='". BASED."/assets/images/perfil/001.png' class='rounded' width='50' alt='profilephoto'>";
                                                }
                                            ?>
                                        </div>
                                        <div class="drop-right text-center space-1">
                                            <h4 style="color: var(--color-light)">
                                                <?= $_SESSION["name"] ?>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="p-3 drop-list">
                                        <div class="text-center">
                                            <?= TITLE ?>
                                        </div>
                                        <ul class="list-unstyled pl-0">
                                            <li class="divider"></li>
                                            <li id="navPerfil"><a href="<?= BASED; ?>/perfil/"><i
                                                        class="icon-user"></i>Meu Perfil</a></li>
                                            <li class="divider"></li>
                                            <li id='logoff' class='text-center'><a href="<?= BASED; ?>/sair.php"><i
                                                        class='powerIcon' data-feather="power"></i>Sair</a></li>
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