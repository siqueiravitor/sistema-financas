<?php
include '../config/config.php';
include '../config/func.php';
include '../config/connMysql.php';
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

        <script src="<?= BASED; ?>/include/func.js"></script>

        <!--Data Table-->
        <link rel="stylesheet" href="<?= BASEF; ?>/assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css">
        <!--DataPicker-->
        <link rel="stylesheet" href="<?= BASEF; ?>/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="<?= BASEF; ?>/assets/vendor/select2/select2.css" />

        <!-- MAIN CSS -->
        <link rel="stylesheet" href="<?= BASED; ?>/assets/css/main.css">

        <script>
            window.addEventListener('DOMContentLoaded', () => {
                $('#date').datepicker({
                    todayHighlight: true
                });
                $("#management-table").dataTable({
                    "aaSorting": [],
                    "columnDefs": [{
                            "targets": [6,7],
                            "orderable": false
                        }]
                });
                $(".select2").select2();

                $('#formRegister').on('submit', function (e) {
                    let value = $('#value').val();
                    let date = $('#date').val();
                    if (!value || !date) {
                        e.preventDefault();
                    }
                });
            });
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
                    <?php
                    if (!empty($_GET["msg"])) {
                        $alert = isset($_GET["alert"]) ? $_GET["alert"] : 0;
                        echo montaAlert($alert, $_GET["msg"]);
                    }
                    ?>
                    <div class="row"> 
                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <form method="POST" action="./include/gIncoming.php" id="formRegister">
                                        <div class="border-bottom mb-4">
                                            <h5 class="text-muted text-center space-1">Registrar entrada/saída</h5>
                                        </div>
                                        <div class="form-group"> 
                                            <small><b>Valor</b></small>
                                            <input class="form-control" id="value" placeholder="R$ 0,00" name="value" onkeyup="moneyMask(this)" required>
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
                                                <?php
                                                $sqlCategoria = "select
                                                                id,
                                                                tipo,
                                                                descricao
                                                            from categoria
                                                            order by tipo";
                                                $queryCategoria = mysqli_query($con, $sqlCategoria);
                                                $tipo = '';
                                                while ($categoria = mysqli_fetch_array($queryCategoria, MYSQLI_NUM)) {
                                                    if ($tipo != $categoria[1]) {
                                                        $tipo = $categoria[1] == 'e' ? 'Receita' : 'Despesa';
                                                        echo "<optgroup label='$tipo'>";
                                                        $tipo = $categoria[1];
                                                    }

                                                    echo "<option value='$categoria[0]'>$categoria[2]</option>";

                                                    if ($tipo != $categoria[1]) {
                                                        echo "</optgroup>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group"> 
                                            <small> <b> Data</b> </small>
                                            <input class="form-control" id="date" name="date" value="<?= date('d/m/Y') ?>" required>
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
                                                    <!--<th>#</th>-->
                                                    <th>Valor</th>
                                                    <th>Categoria</th>
                                                    <th>Descrição</th>
                                                    <th>Recorrente</th>
                                                    <th>Data</th>
                                                    <th>Gerado às</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sqlFinance = "select
                                                                f.id,
                                                                c.descricao as categoria,
                                                                f.valor,
                                                                f.descricao as descFinanca,
                                                                f.recorrente,
                                                                f.data,
                                                                f.datager
                                                            from financa f
                                                            inner join categoria c on (c.id = f.idcategoria)
                                                            where idusuario = {$_SESSION['id']}";
                                                $queryFinance = mysqli_query($con, $sqlFinance);
                                                while ($finance = mysqli_fetch_array($queryFinance, MYSQLI_ASSOC)) {
                                                    $data = dateConvert($finance['data'], '-', '/', true);
                                                    $datager = dateConvert($finance['datager'], '-', '/', true);
                                                    $recorrente = $finance['recorrente'] == 's' ? "Sim" : "Não";
                                                    $valor = floatToMoney($finance['valor']);

                                                    echo "<tr>";
                                                    echo "<td>{$valor}</td>";
                                                    echo "<td>{$finance['categoria']}</td>";
                                                    echo "<td>{$finance['descFinanca']}</td>";
                                                    echo "<td>{$recorrente}</td>";
                                                    echo "<td>{$data}</td>";
                                                    echo "<td>{$datager}</td>";
                                                    echo "<td></td>";
                                                    echo "<td class='text-center p-0'><a href='./include/rIncoming.php?id={$finance['id']}' class='d-block'><i class='text-danger fa fa-trash'></i></a></td>";
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
        <!--DataPicker-->
        <script src="<?= BASEF; ?>/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    </body>
</html>