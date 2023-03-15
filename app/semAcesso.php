<?php
include './config/config.php';
include './config/func.php';
include './config/connMysql.php';

?>
<!doctype html>
<html lang="pt-br">
    <head>
        <title>Sem acesso - <?= TITLE; ?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <link rel="icon" href="<?= LOGO; ?>" type="image/x-icon">	  

        <!-- VENDOR CSS -->       
        <link rel="stylesheet" href="<?= BASE; ?>/assets/vendor/bootstrap/css/bootstrap.min.css">        
        <link rel="stylesheet" href="<?= BASE; ?>/assets/vendor/animate-css/animate.min.css">
        <link rel="stylesheet" href="<?= BASE; ?>/assets/vendor/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= BASE; ?>/assets/vendor/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css">
        <link rel="stylesheet" href="<?= BASE; ?>/assets/vendor/chartist/css/chartist.min.css">
        <link rel="stylesheet" href="<?= BASE; ?>/assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css">

        <!-- MAIN CSS -->
        <link rel="stylesheet" href="<?= BASED; ?>/assets/css/main.css">
        <link rel="stylesheet" href="<?= BASED; ?>/assets/css/color_skins.css">
    </head>

    <body>
        <div id="wrapper">
            <?php
            include './include/loader.php';
            include './include/nav-topo.php';
            include './include/nav-lateral.php';
            mysqli_close($con);
            ?>
            <div id="main-content">
                <div class="container-fluid">
                    <div class="block-header">
                        <div class="row">       
                            <div class="col-lg-6">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= BASED; ?>"><i class="icon-home"></i></a></li>                            
                                    <li class="breadcrumb-item active">SyntaxWeb</li>
                                </ul>
                            </div>                      
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="body text-center">                                    
                                    <div class="font-25 mb-2"> Sem acesso </div>
                                    <div class="font-40"> <i class="icon-lock text-danger"></i> </div>
                                </div>
                            </div>
                        </div>
                    </div>                          
                </div>
            </div>
        </div>
        <!-- Javascript -->
        <script src="<?= BASED; ?>/assets/bundles/libscripts.bundle.js"></script>    
        <script src="<?= BASED; ?>/assets/bundles/vendorscripts.bundle.js"></script>
        <script src="<?= BASED; ?>/assets/bundles/chartist.bundle.js"></script>
        <script src="<?= BASED; ?>/assets/bundles/knob.bundle.js"></script> <!-- Jquery Knob-->
        <script src="<?= BASED; ?>/assets/bundles/flotscripts.bundle.js"></script> <!-- flot charts Plugin Js --> 
        <script src="<?= BASED; ?>/assets/bundles/mainscripts.bundle.js"></script>
        <script src="<?= BASED; ?>/assets/js/index.js"></script>
    </body>
</html>