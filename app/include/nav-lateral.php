<?php
$pages = [
    [
        'label' => 'Lançamentos',
        'href' => 'lancamentos',
        'icon' => 'edit',
    ],
    [
        'label' => 'Poupanças',
        'href' => 'poupanca',
        'icon' => 'pocket',
    ],
    [
        'label' => 'Listas',
        'href' => 'listas',
        'icon' => 'list',
    ],
    [
        'label' => 'Categorias',
        'href' => 'categorias',
        'icon' => 'command',
    ],
    [
        'label' => 'Tipo Pagamento',
        'href' => 'tipopagamento',
        'icon' => 'dollar-sign',
    ],
];
?>
<div id="leftsidebar" class="sidebar bg-gradient">
    <div id='sidebar-scroll' class="sidebar-scroll">
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
                <li class="middle-sm-hide <?= $active ?>">
                    <a href="<?= BASED; ?>">
                        <i class='iconColor navIcon' data-feather="bar-chart-2"></i>
                        <span class='ml-2'>Dashboard</span>
                    </a>
                </li>

                <?php
                $page = explode('/', $_SERVER['REQUEST_URI'])[3] ?? '';
                $menuUser = [
                    [
                        'url' => 'perfil',
                        'description' => 'Meu perfil',
                    ],
                    [
                        'url' => 'manual',
                        'description' => 'Manual',
                    ],
                ];
                ?>
                <li class="heading">Menu</li>
                <li class="middle submenu-sm-hide" id="navMenuUsuario">
                    <a class="has-arrow">
                        <i class='iconColor navIcon' data-feather="user"></i>
                        <span class='ml-2'><?= $nome ?></span>
                    </a>
                    <ul id="subNavMenuUsuario">
                        <?php
                        foreach ($menuUser as $menu) {
                            $link = $menu['url'] == $page ? '#' : BASED . "/" . $menu['url'];
                        ?>
                            <li>
                                <a href="<?= $link ?>" class=" <?= $menu['url'] == $page ? 'active' : '' ?>">
                                    <span><?= $menu['description'] ?></span>
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </li>
                <li class="divider"></li>
                <?php
                foreach ($pages as $data) {
                ?>
                    <li class="middle middle-sm-hide <?= $data['href'] == $page ? 'active' : '' ?>">
                        <a href="<?= BASED . "/" . $data['href'] ?>">
                            <i class='iconColor navIcon' data-feather="<?= $data['icon'] ?>"></i>
                            <span class='ml-2'><?= $data['label'] ?></span>
                        </a>
                    </li>
                <?php
                }
                ?>
                <li class="middle middle-sm-hide" id="navDocumentacao">
                    <a href="<?= BASED ?>/sobre">
                        <i class="icon-info"></i>
                        <span>Sobre</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="side-bottom">
            <?= VERSION ?>
        </div>
    </div>
</div>