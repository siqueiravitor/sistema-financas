<?php
include './config/config.php';
include './config/func.php';
include './config/connMysql.php';
$idmodulo = $_GET['id'];

//if (empty($_GET['id']) || !is_numeric($_GET['id']) || !defined('ID_SISTEMA')) {
//    $msg = "Sem acesso! <br> =)";
//    header("location: ./semAcesso?msg=" . $msg);
//}
//$id = (int) $_GET['id'];
//$sql = "select nome, 
//               icone, 
//               diretorio, 
//               descricao 
//        from mslogin.modulo 
//        where id = $id 
//        and idsistema = " . ID_SISTEMA;
//$result = mysqli_query($con, $sql);
//if (!mysqli_num_rows($result)) {
//    $msg = "Sem acesso! <br> =)";
//    header("location: ./semAcesso?msg=" . $msg);
//}
//$row = mysqli_fetch_array($result);
//$diretorioModuloSistema = $row[2];

$id = (int) $_GET['id'];
$sqlMenu = "select 
                name,
                icon,
                directory
            from module
            where id = $id
            and status = 'a' 
            and idsystems = " . ID_SISTEMA;
$resultMenu = mysqli_query($con, $sqlMenu);
if (mysqli_num_rows($resultMenu) > 0) {
    $rowMenu = mysqli_fetch_array($resultMenu);
//} else {
//    header("location: semAcesso");
}
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <title><?= $rowMenu[0] ?> - <?= TITLE; ?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <link rel="icon" href="<?= BASE_ICO; ?>" type="image/x-icon">	  

        <!-- VENDOR CSS -->       
        <link rel="stylesheet" href="<?= BASEF; ?>/assets/vendor/bootstrap/css/bootstrap.min.css">        
        <link rel="stylesheet" href="<?= BASEF; ?>/assets/vendor/animate-css/animate.min.css">
        <link rel="stylesheet" href="<?= BASEF; ?>/assets/vendor/font-awesome/css/font-awesome.min.css">

        <!-- MAIN CSS -->
        <link rel="stylesheet" href="<?= BASED; ?>/assets/css/main.css">
        <link rel="stylesheet" href="<?= BASED; ?>/assets/css/color_skins.css">

        <style>
            .card{
                border: 0; 
                border-radius: 8px;
                border-left: 6px solid var(--color-tertiary);
                box-shadow: 0 0 3px #7777;
            }
            .card:hover{
                transform: translateY(-.4rem);
                box-shadow: 0 5px 10px #7777;
                border-color: var(--color-primary)!important;
                color: var(--color-primary)!important;
            }
            .card:hover * {
                cursor: pointer!important;
            }
                
            div > a{
                color: var(--color-tertiary)!important;
            }
        </style>
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
                                    <li class="breadcrumb-item active">Ambiente</li>
                                </ul>
                            </div>                      
                        </div>
                    </div>
                    <div class="row clearfix">
                        <?php
                        $sqlTela = "select 
                                        name, 
                                        icon, 
                                        directory, 
                                        description
                                    from screen
                                    where idmodule = $id
                                    and status = 'a'
                                    order by ordering asc";
                        $resultTela = mysqli_query($con, $sqlTela);
                        if (mysqli_num_rows($resultTela)) {
                            while ($rowTela = mysqli_fetch_array($resultTela)) {
                                $link = BASED . "/$rowMenu[2]/$rowTela[2]";
                                ?>
                                <div class="col-lg-3 cool-md-6 col-sm-12" >
                                    <a href="<?= $link ?>" class="card d-flex flex-row py-2">
                                        <div class="icon align-self-center mx-3">
                                            <i class="<?= $rowTela[1] ?>"></i>
                                        </div>
                                        <div>
                                            <h4> <?= $rowTela[0] ?> </h4>
                                            <label class="clique"><?= $rowTela[3] ?></label>
                                        </div>
                                    </a>
                                </div>

                                <?php
                            }
                        }
                        ?>
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