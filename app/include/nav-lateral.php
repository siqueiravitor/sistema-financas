<div id="leftsidebar" class="sidebar bg-gradient">
    <div class="sidebar-scroll">
        <nav id="leftsidebar-nav" class="sidebar-nav mt-3">
            <ul id="main-menu" class="metismenu">
                <?php
                $nome = ucwords(strtolower($_SESSION['name']));
                $nome = explode(' ', $nome);
                if (count($nome) > 1) {
                    $nome = $nome[0] . " " . array_reverse($nome)[0];
                } else {
                    $nome = $nome[0];
                }

                $active = empty(explode('/', $_SERVER['REQUEST_URI'])[3]) ? 'active' : '';
                ?>
                <li class="<?= $active ?>">
                    <a href="<?= BASED; ?>">
                        <i class='iconColor navIcon' data-feather="bar-chart-2"></i>
                        <span class='ml-2'>Dashboard</span>
                    </a>
                </li>

                <li class="heading">Menu</li>
                <li class="middle" id="navMenuUsuario">
                    <a class="has-arrow">
                        <i class='iconColor navIcon' data-feather="user"></i>
                        <span class='ml-2'><?= $nome ?></span>
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
                <li class="middle <?= explode('/', $_SERVER['REQUEST_URI'])[3] == 'sistema' ? 'active' : '' ?>">
                    <a href="<?= BASED . "/sistema" ?>">
                        <i class='iconColor navIcon' data-feather="cpu"></i>
                        <span class='ml-2'>Sistema</span>
                    </a>
                </li>
                <?php
                $page = explode('/', $_SERVER['REQUEST_URI'])[3] ?? '';
                ?>
                <li class="middle <?= 'lancamentos' == $page ? 'active' : '' ?>">
                    <a href="<?= BASED . "/lancamentos" ?>">
                        <i class='iconColor navIcon' data-feather="edit"></i>
                        <span class='ml-2'>Lançamentos</span>
                    </a>
                </li>
                <li class="middle <?= 'poupanca' == $page ? 'active' : '' ?>">
                    <a href="<?= BASED . "/poupanca" ?>">
                        <i class='iconColor navIcon' data-feather="pocket"></i>
                        <span class='ml-2'>Poupança</span>
                    </a>
                </li>
                <li class="middle <?= 'grupos' == $page ? 'active' : '' ?>">
                    <a href="<?= BASED . "/grupos" ?>">
                        <i class='iconColor navIcon' data-feather="grid"></i>
                        <span class='ml-2'>Grupos</span>
                    </a>
                </li>
                <li class="middle <?= 'listas' == $page ? 'active' : '' ?>">
                    <a href="<?= BASED . "/listas" ?>">
                        <i class='iconColor navIcon' data-feather="list"></i>
                        <span class='ml-2'>Listas</span>
                    </a>
                </li>
                <li class="middle <?= 'categorias' == $page ? 'active' : '' ?>">
                    <a href="<?= BASED . "/categorias" ?>">
                        <i class='iconColor navIcon' data-feather="command"></i>
                        <span class='ml-2'>Categorias</span>
                    </a>
                </li>
                <li class="middle <?= 'tipopagamento' == $page ? 'active' : '' ?>">
                    <a href="<?= BASED . "/tipopagamento" ?>">
                        <i class='iconColor navIcon' data-feather="dollar-sign"></i>
                        <span class='ml-2'>Tipo Pagamento</span>
                    </a>
                </li>
                <li class="middle" id="navDocumentacao">
                    <a href="<?= BASED ?>/sobre">
                        <i class="icon-info"></i>
                        <span>Sobre</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="fixed-bottom">
            <?= VERSION ?>
        </div>
    </div>
</div>