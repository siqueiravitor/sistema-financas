<div id="leftsidebar" class="sidebar" style="background-color: #212529">
    <div class="sidebar-scroll">
        <nav id="leftsidebar-nav" class="sidebar-nav mt-3">
            <ul id="main-menu" class="metismenu">
                <?php
                $nome = strtolower($_SESSION['nome']);
                $nome = explode(" ", $nome)[0] . "." . explode(" ", $nome)[1];
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

//                $sqlModuloMenu = "select 
//                                    id, 
//                                    name, 
//                                    icon, 
//                                    directory,
//                                    link
//                                from module 
//                                where status = 'a' 
//                                and idsystems = " . ID_SISTEMA
//                                . " order by ordering ";
//                $resultModuloMenu = mysqli_query($con, $sqlModuloMenu);
//                if (mysqli_num_rows($resultModuloMenu)) {
//                    while ($rowModuloMenu = mysqli_fetch_array($resultModuloMenu)) {
//                        $link = $rowModuloMenu[4] == 'y' ? BASED . "/$rowModuloMenu[3]" : BASED . "/menu.php?id=" . $rowModuloMenu[0];
//                        $moduloAtivo = "";
//                        if ((explode('.php', $page)[0] == 'menu' && isset($_GET['id']) && $_GET['id'] == $rowModuloMenu[0]) || $rowModuloMenu[3] == $page) {
//                            $moduloAtivo = "active";
//                            $active = '';
//                        }
//                        ?>
<!--                        <li class="middle <?= $moduloAtivo ?>" >
                            <a href="<?= $link ?>" >
                                <i class="<?= $rowModuloMenu[2] ?> iconColor"></i>
                                <span><?= $rowModuloMenu[1] ?></span>
                            </a>
                        </li>-->
                        <?php
//                    }
//                }
                ?>
                <?php
                $page = explode('/', $_SERVER['REQUEST_URI'])[2] ?? '';
                ?>
                <li class="middle <?= 'ambiente' == explode('/', $_SERVER['REQUEST_URI'])[2] ?? '' ? 'active' : '' ?>">
                    <a href="<?= BASED . "/ambiente" ?>" >
                        <i class="icon-wrench iconColor"></i>
                        <span>Ambiente</span>
                    </a>
                </li>
                <li class="middle <?= 'cadastro' == $page ? 'active' : '' ?>">
                    <a href="<?= BASED . "/cadastro" ?>" >
                        <i class="icon-note iconColor"></i>
                        <span>Cadastros</span>
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