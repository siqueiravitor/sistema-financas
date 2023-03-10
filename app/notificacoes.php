<?php
include './config/config.php';
include './config/func.php';
include './config/connMysql.php';

$sql = "update notificacao set lido = 's', datleitura = now() where idusuario = " . $_SESSION['iduser'] . " and lido = 'n'";
mysqlI_query($con, $sql);
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <title>Notificações - <?= TITLE; ?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <link rel="icon" href="<?= BASE_ICO; ?>" type="image/x-icon">	  

        <!-- VENDOR CSS -->       
        <link rel="stylesheet" href="<?= BASEF; ?>/assets/vendor/bootstrap/css/bootstrap.min.css">        
        <link rel="stylesheet" href="<?= BASEF; ?>/assets/vendor/animate-css/animate.min.css">
        <link rel="stylesheet" href="<?= BASEF; ?>/assets/vendor/font-awesome/css/font-awesome.min.css">

        <!--CSS'S-->

        <!-- MAIN CSS -->
        <link rel="stylesheet" href="<?= BASED; ?>/assets/css/main.css">
        <link rel="stylesheet" href="<?= BASED; ?>/assets/css/color_skins.css">
    </head>

    <body class="theme-<?= $_SESSION['empresa'] ?>">

        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="m-t-30"><img src="<?= BASE_ICO; ?>" width="48" height="48" alt="<?= TITLE; ?>"></div>
                <p>Carregando...</p>        
            </div>
        </div>
        <div class="overlay" style="display: none;"></div>
        <div id="wrapper">
            <?php
            include './include/nav-topo.php';
            include './include/nav-lateral.php';
            ?>
            <div id="main-content">
                <div class="container-fluid">
                    <div class="block-header">
                        <div class="row">       
                            <div class="col-lg-6">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= BASED; ?>/index"><i class="icon-home"></i></a></li>                            
                                    <li class="breadcrumb-item active">Notificação</li>
                                </ul>
                            </div>                      
                        </div>
                    </div>
                    <div class=" clearfix  middle shadow-lg bg-white rounded">
                        <div class="card">
                            <div class="body">
                                <?php
                                $sql2 = "select n.idnotificacao,
                                                u.nome,
                                                n.datger,
                                                n.titulo,
                                                n.texto,
                                                n.icone,
                                                n.cor,
                                                n.datger,
                                                n.lido,
                                                n.datleitura
                                        from notificacao n
                                        left join usuario u
                                        on u.idusuario = n.idusuario
                                        where n.idusuario = " . $_SESSION['iduser'] .
                                        " order by n.datger desc";
                                $query2 = mysqlI_query($con, $sql2);
                                while ($row2 = mysqlI_fetch_array($query2)) {
                                    if ($row2[3]) {
                                        $titulo = $row2[3];
                                    } else {
                                        $titulo = $row2[0];
                                    }
                                    ?>
                                    <div class="timeline-item <?= $row2[6] ?>" date-is="<?= dataBuscaBanco(explode(" ", $row2[7])[0]) ?> às <?= explode(" ", $row2[7])[1] ?>">
                                        <h5><?= $titulo ?></h5>
                                        <div class="msg">
                                            <p><?= $row2[4] ?></p>
                                            <small>Lido no dia <?= dataBuscaBanco(explode(" ", $row2[9])[0]) ?> às <?= explode(" ", $row2[9])[1] ?></small>
                                        </div>                                
                                    </div>
                                    <?php
                                }
                                mysqli_close($con);
                                ?>
                            </div>
                        </div>
                    </div>                 
                </div>
            </div>
        </div>
        <!-- Javascript -->
        <script src="<?= BASED; ?>/assets/bundles/libscripts.bundle.js"></script>    
        <script src="<?= BASED; ?>/assets/bundles/vendorscripts.bundle.js"></script> 
        <script src="<?= BASED; ?>/assets/bundles/mainscripts.bundle.js"></script>
    </body>
</html>