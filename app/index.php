<?php
require('../required.php');
include './config/config.php';
include './config/security.php';
include './config/connMysql.php';

$hoje = date('Y-m-d');
$diaSemana = date('w'); // Domingo = 0

?>
<!doctype html>
<html lang="pt-br">

<head>
    <title>
        <?= SYSTEM . " - " . TITLE; ?>
    </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="icon" href="<?= LOGO; ?>" type="image/x-icon">

    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="<?= BASE; ?>/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE; ?>/assets/vendor/animate-css/animate.min.css">
    <link rel="stylesheet" href="<?= BASE; ?>/assets/vendor/font-awesome/css/font-awesome.min.css">

    <!-- Calendar -->
    <link rel="stylesheet" href="<?= BASE; ?>/assets/vendor/fullcalendar/fullcalendar.min.css">
    <!--Data Table-->
    <link rel="stylesheet" href="<?= BASE; ?>/assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css">
    <!--Gráficos-->
    <link rel="stylesheet" href="<?= BASE; ?>/assets/vendor/chartist/css/chartist.css">
    <link rel="stylesheet" href="<?= BASE; ?>/assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="<?= BASED; ?>/assets/css/main.css">
</head>

<body>
    <div id="wrapper">
        <?php
        include './include/loader.php';
        include './include/nav-topo.php';
        include './include/nav-lateral.php';
        ?>
        <div id="main-content">
            <div class="container-fluid">
                <div class="block-header">
                    <div class="row">
                        <div class="col-md-4">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= BASED; ?>/index"><i class="icon-home"></i></a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <?= COMPANY ?>
                                </li>
                            </ul>
                        </div>
                        <div class='col-md-12'>
                            <?= 'PHP version: ' . phpversion() ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class='d-flex justify-content-center mb-2'>
                <?php
                include './include/footer.php';
                ?>
            </div>
        </div>
    </div>

    <!-- FeatherIcons -->
    <script src="<?= ICON ?>/feather.js"></script>
    <!-- Javascript -->
    <script src="<?= BASED; ?>/assets/bundles/libscripts.bundle.js"></script>
    <script src="<?= BASED; ?>/assets/bundles/vendorscripts.bundle.js"></script>
    <script src="<?= BASED; ?>/assets/bundles/mainscripts.bundle.js"></script>
    <!-- Calendar -->
    <script src="<?= BASED; ?>/assets/bundles/fullcalendarscripts.bundle.js"></script>
    <!-- Data Table -->
    <script src="<?= BASED; ?>/assets/bundles/datatablescripts.bundle.js"></script>
    <script src="<?= BASE; ?>/assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
    <script src="<?= BASE; ?>/assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
    <!--GRAFICOS-->
    <script src="<?= BASE; ?>/assets/vendor/chartist/js/chartist.js"></script>
    <script src="<?= BASE; ?>/assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.min.js"></script>
</body>

</html>