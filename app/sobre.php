<?php
include './config/config.php';
include './config/func.php';
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <title>Sobre - <?= TITLE; ?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <link rel="icon" href="<?= BASE_ICO; ?>" type="image/x-icon">	  

        <!-- VENDOR CSS -->       
        <link rel="stylesheet" href="<?= BASEF; ?>/assets/vendor/bootstrap/css/bootstrap.min.css">        
        <link rel="stylesheet" href="<?= BASEF; ?>/assets/vendor/animate-css/animate.min.css">
        <link rel="stylesheet" href="<?= BASEF; ?>/assets/vendor/font-awesome/css/font-awesome.min.css">

        <style>
            ul {list-style-type: none;}
            li {list-style-type: none;}
            .icon-action-redo{
                text-decoration: none;
                transition: all 0.2s linear 0s;
                font-size: 10px;
            }
            .icon-action-redo:hover {
                color: red;
                transition: all 0.2s linear 0s;
            }
            .fa-circle{
                color: #777777; 
                font-size: 2px;
            }
            .card-columns {
                column-count: 2;
            }
        </style>

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
            include './config/connMysql.php';
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
                                    <li class="breadcrumb-item active">Sobre</li>
                                </ul>
                            </div>                      
                        </div>
                    </div>
                    <div class=" clearfix  middle shadow-lg bg-white rounded">
                        <div class="card">
                            <div class="header">
                                <h2>Sobre</h2>
                            </div>
                            <div class="body">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Javascript-->
        <script src = "<?= BASED; ?>/assets/bundles/libscripts.bundle.js"></script>    
        <script src="<?= BASED; ?>/assets/bundles/vendorscripts.bundle.js"></script> 
        <script src="<?= BASED; ?>/assets/bundles/mainscripts.bundle.js"></script>
    </body>
</html>