<?php
include '../config/config.php';
include '../config/func.php';
include '../config/connMysql.php';
//require '../vendor/autoload.php';            
include '../include/icons.php';
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

        <!--Data Table-->
        <link rel="stylesheet" href="<?= BASEF; ?>/assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="<?= BASEF; ?>/assets/vendor/select2/select2.css" />

        <!-- MAIN CSS -->
        <link rel="stylesheet" href="<?= BASED; ?>/assets/css/main.css">
        <link rel="stylesheet" href="<?= BASED; ?>/assets/css/color_skins.css">

        <script>
            window.addEventListener('DOMContentLoaded', () => {
                $("#management-table").dataTable();

                $("#icon-select").select2();
                $("#icon-select").click(function () {
                    mudaIcone(this.value);
                });
            });

            function mudaIcone(icone) {
                $("#icone").removeClass();
                $("#icone").addClass(icone);
            }
        </script>
        <style>
            .input-group>.custom-select:not(:first-child), .input-group>.form-control{
                border-top-right-radius: 4px!important;
                border-bottom-right-radius: 4px!important;
            }
        </style>
    </head>
    <body>
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="m-t-30"><img src="<?= BASE_ICO; ?>" width="48" height="48" alt="<?= TITLE; ?>"></div>
                <p>Carregando...</p>        
            </div>
        </div>
        <div class="overlay" style="display: none;"></div>
        <div id="wrapper">
            <?php
            include '../include/nav-topo.php';
            include '../include/nav-lateral.php';
            ?>
            <div id="main-content">
                <div class="container-fluid">
                    <?php
                    include '../include/breadcrumb.php';
                    ?>

                    <div class="row"> 
                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <form method="POST" action="./include/gModulo.php">
                                        <div class="border-bottom mb-4">
                                            <h5 class="text-muted text-center space-1">Cadastrar novo módulo</h5>
                                        </div>
                                        <div class="form-group"> 
                                            <small> <b> Nome </b> </small>
                                            <input class="form-control" name="name">
                                        </div>
                                        <div class="form-group"> 
                                            <small><b>Ícone</b> <b class="text-danger">*</b></small>
                                            <div class="input-group">
                                                <div class="input-group-prepend" style="height: 35px;">
                                                    <span class="input-group-text"><i id="icone" class=""></i></span>
                                                </div>
                                                <select id="icon-select" class="form-control select2" style="height: 35px;" name="icon" required="true">
                                                    <option></option>
                                                    <?php
                                                    $icones = listaIcones();
                                                    foreach ($icones as $value) {
                                                        ?>
                                                        <option value="<?= trim($value->CLASS) ?>"><?= $value->NOME ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group"> 
                                            <small> <b> Diretório </b> </small>
                                            <input class="form-control" name="directory">
                                        </div>
                                        <div class="form-group"> 
                                            <small> <b> Link </b> </small>
                                            <input class="form-control" name="link">
                                        </div>
                                        <div class="form-group"> 
                                            <small> <b> Descrição </b> </small>
                                            <textarea class="form-control" name="description"></textarea>
                                        </div>

                                        <div class="text-right">
                                            <button class="btn w-50 btn-success space-1">Cadastrar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <div class="border-bottom mb-4">
                                        <h5 class="text-muted text-center space-1">Módulos cadastrados</h5>
                                    </div>
                                    <div class='table-responsive'>
                                        <table id="management-table" class="table table-sm table-hover table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Icone</th>
                                                    <th>Nome</th>
                                                    <th>Descrição</th>
                                                    <th>Diretório</th>
                                                    <th>Status</th>
                                                    <th>Link</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sqlModule = "select 
                                                                id,
                                                                name, 
                                                                description, 
                                                                icon, 
                                                                directory, 
                                                                ordering, 
                                                                status, 
                                                                link
                                                            from module";
                                                $queryModule = mysqli_query($con, $sqlModule);
                                                while ($row = mysqli_fetch_array($queryModule, MYSQLI_ASSOC)) {
                                                    $link = $row['link'] == 's' ? 'Sim' : 'Não';
                                                    $status = $row['status'] == 'a' ? 'Ativo' : 'Inativo';
                                                    echo "<tr>";
                                                    echo "<td class='text-center'>{$row['ordering']}</td>";
                                                    echo "<td class='text-center'><i class='{$row['icon']}'></i></td>";
                                                    echo "<td>{$row['name']}</td>";
                                                    echo "<td style='white-space: normal'>{$row['description']}</td>";
                                                    echo "<td>{$row['directory']}</td>";
                                                    echo "<td class='text-center'>$status</td>";
                                                    echo "<td class='text-center'>$link</td>";
                                                    echo "<td class='text-center p-0'>
                                                            <a href='./screen?id={$row['ordering']}' class='p-2'>
                                                                <i class='fa fa-eye'></i>
                                                            </a>
                                                        </td>";
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>  
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
        <script src="<?= BASED; ?>/assets/bundles/mainscripts.bundle.js"></script>
        <!-- Data Table -->
        <script src="<?= BASED; ?>/assets/bundles/datatablescripts.bundle.js"></script>
        <script src="<?= BASEF; ?>/assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
        <script src="<?= BASEF; ?>/assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
        <!-- Select2 Js -->
        <script src="<?= BASEF; ?>/assets/vendor/select2/select2.min.js"></script>
    </body>
</html>