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
        <title>Registrar - <?= TITLE; ?></title>
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
        <!--DataPicker-->
        <link rel="stylesheet" href="<?= BASEF; ?>/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="<?= BASEF; ?>/assets/vendor/select2/select2.css" />

        <!-- MAIN CSS -->
        <link rel="stylesheet" href="<?= BASED; ?>/assets/css/main.css">
        <link rel="stylesheet" href="<?= BASED; ?>/assets/css/color_skins.css">

        <script>
            window.addEventListener('DOMContentLoaded', () => {
                $('#date').datepicker({
                    todayHighlight: true
                });
                $("#management-table").dataTable();
                $(".select2").select2();
            });
            function moneyMask(input) {
                if (input.value) {
                    // Remove all non-numeric characters from the input
                    const numericInput = input.value.replace(/\D/g, '');
                    // Format the numeric input to a currency format
                    const formattedInput = (parseInt(numericInput) / 100).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'});
                    // Set the input value to the formatted currency string
                    input.value = formattedInput;
                }
            }
        </script>
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
                                    <form method="POST" action="./include/gIncoming.php">
                                        <div class="border-bottom mb-4">
                                            <h5 class="text-muted text-center space-1">Registrar entrada/saída</h5>
                                        </div>
                                        <div class="form-group"> 
                                            <small><b>Valor</b></small>
                                            <input class="form-control" placeholder="R$ 0,00" name="value" onkeyup="moneyMask(this)">
                                        </div>
                                        <!--                                        <div class="form-group"> 
                                                                                    <small> <b> Tipo</b> </small>
                                                                                    <select class="form-control select2">
                                                                                        <option value="entrada">Entrada</option>
                                                                                        <option value="saida">Saída</option>
                                                                                    </select>
                                                                                </div>-->
                                        <div class="form-group"> 
                                            <small> <b> Categoria</b> </small>
                                            <select class="form-control select2" name="category">
                                                <optgroup label="Receita">
                                                    <option value="salary">Salário</option>
                                                </optgroup>
                                                <optgroup label="Despesa">
                                                    <option value="conta">Conta</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="form-group"> 
                                            <small> <b> Data</b> </small>
                                            <input class="form-control" id="date" name="date" value="<?= date('d/m/Y') ?>">
                                        </div>
                                        <div class="form-group"> 
                                            <small> <b> Repetição</b> </small>
                                            <select class="form-control select2" name="recurrence">
                                                <option value="u">Única</option>
                                                <option value="f">Fixa</option>
                                                <option value="p">Parcelada</option>
                                            </select>
                                        </div>

                                        <div class="form-group"> 
                                            <small> <b> Descrição </b> </small>
                                            <textarea class="form-control" name="description"></textarea>
                                        </div>

                                        <div class="text-right">
                                            <button class="btn w-50 btn-success space-1">Gravar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <div class="border-bottom mb-4">
                                        <h5 class="text-muted text-center space-1">Lançamentos</h5>
                                    </div>
                                    <div class='table-responsive'>
                                        <table id="management-table" class="table table-sm table-hover table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Valor</th>
                                                    <th>Categoria</th>
                                                    <th>Descrição</th>
                                                    <th>Repetição</th>
                                                    <th>Data</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

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
        <!--DataPicker-->
        <script src="<?= BASEF; ?>/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    </body>
</html>