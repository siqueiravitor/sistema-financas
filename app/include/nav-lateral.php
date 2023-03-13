<div id="leftsidebar" class="sidebar" style="background-color: #212529">
    <div class="sidebar-scroll">
        <nav id="leftsidebar-nav" class="sidebar-nav mt-3">
            <ul id="main-menu" class="metismenu">
                <?php
                $nome = strtolower($_SESSION['nome']);
                $nome = explode(" ", $nome)[0] . isset(explode(" ", $nome)[1]) ?? "." . explode(" ", $nome)[1];
                $active = empty(explode('/', $_SERVER['REQUEST_URI'])[3]) ? 'active' : '';
                ?>
                <li class="<?= $active ?>">
                    <a href="<?= BASED; ?>">
                        <i class="icon-home iconColor"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="heading">Menu</li>
                <li class="middle" id="navMenuUsuario">
                    <a class="has-arrow">
                        <i class="icon-user iconColor"></i>
                        <span><?= $nome ?></span>
                    </a>
                    <ul id="subNavMenuUsuario">
                        <li>
                            <a href="<?= BASED . "/perfil" ?>">
                                <span>Meu perfil</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="divider"></li>
                <li class="middle <?= explode('/', $_SERVER['REQUEST_URI'])[3] == 'sistema' ? 'active' : '' ?>" >
                    <a href="<?= BASED . "/sistema" ?>" >
                        <i class="fa fa-cog iconColor"></i>
                        <span>Sistema</span>
                    </a>
                </li>
                <?php
                $page = explode('/', $_SERVER['REQUEST_URI'])[3] ?? '';
                ?>
                <li class="middle <?= 'lancamento' == $page ? 'active' : '' ?>">
                    <a href="<?= BASED . "/lancamento" ?>" >
                        <i class="icon-wrench iconColor"></i>
                        <span>Lançamento</span>
                    </a>
                </li>
                <li class="middle" id="navDocumentacao">
                    <a href="<?= BASED ?>/sobre">
                        <i class="icon-info" ></i>
                        <span>Sobre</span>
                    </a>
                </li>
            </ul>           
        </nav>
        <div class="fixed-bottom">
            v1.0
        </div>
    </div>
</div>
<style>

</style>