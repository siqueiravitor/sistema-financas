<?php
$sql_notificacao = "select id,
                           datger,
                           title,
                           text,
                           icon,
                           color,
                           created_at
                    from notification
                    where id_user = " . $_SESSION['id'] . "
                    and read = 'n'";
$query_notificacao = mysqlI_query($con, $sql_notificacao);
$qtdnot = mysqlI_num_rows($query_notificacao);
if ($qtdnot > 0) {
    $atvnot = "-dot";
} else {
    $atvnot = null;
}
?>
<li class="dropdown">
    <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown" aria-expanded="false">
        <i class="icon-bell"></i>
        <span class="notification<?= $atvnot ?>"></span>
    </a>
    <ul class="dropdown-menu animated bounceIn notifications">
        <li class="header"><strong>Você possui <?= $qtdnot ?> notificações</strong></li>
        <?php
        while ($row_notificacao = mysqlI_fetch_array($query_notificacao)) {
            $link_notificacao = BASED . "/notificacao?id=" . $row_notificacao[0];
            if ($row_notificacao[5]) {
                $icone_notificacao = $row_notificacao[5];
            } else {
                $icone_notificacao = "icon-info text-warning";
            }
            ?>
            <li>
                <a href="<?= $link_notificacao ?>">
                    <div class="media">
                        <div class="media-left">
                            <i class="<?= $icone_notificacao ?>"></i>
                        </div>
                        <div class="media-body">
                            <p><?= $row_notificacao[4] ?></p>
                            <small><?= 'dataBuscaBanco(explode(" ", $row_notificacao[7])[0])' ?> às <?= 'explode(" ", $row_notificacao[7])[1]' ?></small>
                        </div>
                    </div>
                </a>
            </li>   
            <?php
        }
        ?>
        <li class="footer">
            <a href="<?= BASED ?>/notificacoes.php" class="more">Visualizar todas</a>
        </li>
    </ul>

</li>