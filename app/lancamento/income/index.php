<?php
include '../../config/config.php';
include '../../config/func.php';
include '../../config/connMysql.php';
//require '../vendor/autoload.php';

$hoje = date('Y-m-d');
$diaSemana = date('w'); // Domingo = 0

?>
<!doctype html>
<html lang="pt-br">
    <head>
        <title>Dashboard - <?= TITLE; ?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <link rel="icon" href="<?= BASE_ICO; ?>" type="image/x-icon">	  

        <!-- VENDOR CSS -->       
        <link rel="stylesheet" href="<?= BASEF; ?>/assets/vendor/bootstrap/css/bootstrap.min.css">        
        <link rel="stylesheet" href="<?= BASEF; ?>/assets/vendor/animate-css/animate.min.css">
        <link rel="stylesheet" href="<?= BASEF; ?>/assets/vendor/font-awesome/css/font-awesome.min.css">

        <!-- Calendar --> 
        <link rel="stylesheet" href="<?= BASEF; ?>/assets/vendor/fullcalendar/fullcalendar.min.css">
        <!--Data Table-->
        <link rel="stylesheet" href="<?= BASEF; ?>/assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css">
        <!--Gráficos-->
        <link rel="stylesheet" href="<?= BASEF; ?>/assets/vendor/chartist/css/chartist.css">
        <link rel="stylesheet" href="<?= BASEF; ?>/assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css">
        
        <!-- MAIN CSS -->
        <link rel="stylesheet" href="<?= BASED; ?>/assets/css/main.css">
        <link rel="stylesheet" href="<?= BASED; ?>/assets/css/color_skins.css">

    </head>
    <body class="theme-<?= $empresa ?>">
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="m-t-30"><img src="<?= BASE_ICO; ?>" width="48" height="48" alt="<?= TITLE; ?>"></div>
                <p>Carregando...</p>        
            </div>
        </div>
        <div class="overlay" style="display: none;"></div>
        <div id="wrapper">
            <?php
            include '../../include/nav-topo.php';
            include '../../include/nav-lateral.php';
            ?>
            <div id="main-content">
                <div class="container-fluid">
                    <?php
                    include '../../include/breadcrumb.php';
                    ?>
                </div>
            </div>                          
        </div>
        <!-- Javascript -->
        <script src="<?= BASED; ?>/assets/bundles/libscripts.bundle.js"></script>    
        <script src="<?= BASED; ?>/assets/bundles/vendorscripts.bundle.js"></script> 
        <script src="<?= BASED; ?>/assets/bundles/mainscripts.bundle.js"></script>
        <!-- Calendar --> 
        <script src="<?= BASED; ?>/assets/bundles/fullcalendarscripts.bundle.js"></script>     
        <!-- Data Table -->
        <script src="<?= BASED; ?>/assets/bundles/datatablescripts.bundle.js"></script>
        <script src="<?= BASEF; ?>/assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
        <script src="<?= BASEF; ?>/assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
        <!--GRAFICOS-->
        <script src="<?= BASEF; ?>/assets/vendor/chartist/js/chartist.js"></script>
        <script src="<?= BASEF; ?>/assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.min.js"></script>
    </body>
</html>