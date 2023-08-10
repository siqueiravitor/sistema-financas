<?php
require('../../required.php');
include_once '../config/config.php';
include_once '../functions/func.php';
include_once '../config/security.php';
include_once '../config/connMysql.php';
include_once './include/functions.php';

?>
<!doctype html>
<html lang="pt-br">

<head>
    <title>Lançamento -
        <?= TITLE; ?>
    </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="icon" href="<?= LOGO; ?>" type="image/x-icon">

    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="<?= BASE; ?>/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE; ?>/assets/vendor/animate-css/animate.min.css">
    <link rel="stylesheet" href="<?= BASE; ?>/assets/vendor/font-awesome/css/font-awesome.min.css">

    <script src="<?= BASED; ?>/include/func.js"></script>

    <!--Data Table-->
    <link rel="stylesheet" href="<?= BASE; ?>/assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css">
    <!--DataPicker-->
    <link rel="stylesheet" href="<?= BASE; ?>/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= BASE; ?>/assets/vendor/select2/select2.css" />

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
                    "targets": [6, 7],
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
    <style>
        #management-table svg {
            width: .9rem !important;
            height: .9rem !important;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <?php
        include '../include/loader.php';
        include '../include/nav-topo.php';
        include '../include/nav-lateral.php';
        ?>
        <div id="main-content">
            <div class="container-fluid">
                <?php
                include '../include/breadcrumb.php';

                if (!empty($_GET["msg"])) {
                    $alert = isset($_GET["alert"]) ? $_GET["alert"] : 0;
                    echo montaAlert($alert, $_GET["msg"]);
                }
                ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <form method="POST" action="./include/rFinance.php" id="formRegister">
                                    <div class="border-bottom mb-4">
                                        <h5 class="text-muted text-center space-1">Registrar entrada/saída</h5>
                                    </div>
                                    <div class="form-group">
                                        <small><b>Valor</b></small>
                                        <input class="form-control" id="value" placeholder="R$ 0,00" name="value"
                                            onkeyup="moneyMask(this)" required>
                                    </div>
                                    <div class="form-group">
                                        <small> <b> Categoria</b> </small>
                                        <select class="form-control select2" name="category">
                                            <?php
                                            $tipo = '';
                                            $categorias = categories();
                                            foreach ($categorias as $categoria) {
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
                                        <input class="form-control" id="date" name="date" value="<?= date('d/m/Y') ?>"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <small> <b> Pagamento </b> </small>
                                        <select class="form-control select2" name="payment">
                                            <option value=""></option>
                                            <option value="b">Dinheiro</option>
                                            <option value="p">Pix</option>
                                            <optgroup label='Cartão'>
                                                <option value="c">Crédito</option>
                                                <option value="d">Débito</option>
                                            </optgroup>
                                        </select>
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
                                    <div class='row mr-0' id='deleteSelected'>
                                        <div style='position: absolute; top: 4rem; right: 0; width: initial!important;'>
                                            <span id='quantity'> 0 </span> Selecionado(s)
                                        </div>
                                        <div class='col-md-12 pr-0'>
                                            <button class='btn btn-outline-tertiary mb-2'
                                                style='border-radius: 4px!important' onclick='checkAll()'>
                                                Selecionar todos
                                            </button>
                                            <button class='btn btn-outline-tertiary btn-checkAll mb-2' disabled
                                                style='border-radius: 4px!important' onclick='checkAll(false)'>
                                                Deselecionar todos
                                            </button>
                                            <div class='d-inline-block float-right'>
                                                <button onclick='deleteSelected()'
                                                    class='btn btn-outline-danger btn-checkAll mb-2' disabled>
                                                    Deletar selecionados
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <table id="management-table"
                                        class="table table-sm table-hover table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Valor</th>
                                                <th>Categoria</th>
                                                <th>Descrição</th>
                                                <th>Pagamento</th>
                                                <th>Recorrente</th>
                                                <th>Data</th>
                                                <th>Gerado</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $userId = $_SESSION['id'];
                                            $finances = dataFinance($userId);
                                            if ($finances[0] > 0) {
                                                array_shift($finances);
                                                foreach ($finances as $finance) {
                                                    $date = dateConvert($finance['data'], '-', '/', true);
                                                    $dategen = dateConvert($finance['datager'], '-', '/', true);
                                                    $recurrence = $finance['recorrente'] == 's' ? "Sim" : "Não";
                                                    $value = floatToMoney($finance['valor']);
                                                    $payment = $finance['pagamento'];
                                                    if ($payment == 'p') {
                                                        $payment = 'Pix';
                                                    }
                                                    if ($payment == 'd') {
                                                        $payment = 'Dinheiro';
                                                    }
                                                    if ($payment == 'cd') {
                                                        $payment = 'Crédito';
                                                    }
                                                    if ($payment == 'cc') {
                                                        $payment = 'Débito';
                                                    }

                                                    echo "<tr>";
                                                    echo "<td class='checkboxArea'><input type='checkbox' value='" . $finance['id'] . "' class='checkRegister' onchange='checkCheckbox()'></td>";
                                                    echo "<td>{$value}</td>";
                                                    echo "<td>{$finance['categoria']}</td>";
                                                    echo "<td style='white-space: normal'>{$finance['descFinanca']}</td>";
                                                    echo "<td>{$payment}</td>";
                                                    echo "<td>{$recurrence}</td>";
                                                    echo "<td>{$date}</td>";
                                                    echo "<td>{$dategen}</td>";
                                                    echo "<td></td>";
                                                    echo "<td class='text-center p-0'><a href='./include/dFinance.php?id={$finance['id']}' class='d-block'>
                                                            <i class='text-danger' data-feather='trash-2'></i></a>
                                                        </td>";
                                                    echo "</tr>";
                                                }
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
            <?php
            include '../include/footer.php';
            ?>
        </div>
    </div>
    <script>
        function deleteSelected() {
            let data = $(".checkRegister");
            let items = [];
            data.each((idx) => {
                if (data[idx].checked === true) {
                    items.push(data[idx].value);
                }
            })
            if (items.length > 0) {
                location.href = './include/dFinance.php?mult=true&id=' + items;
            }
        }
        function checkCheckbox() {
            let data = $(".checkRegister");
            let items = [];
            data.each((idx) => {
                if (data[idx].checked === true) {
                    items.push(data[idx].value);
                }
            })
            if (items.length > 0) {
                $('#quantity').html(items.length);
                $(".btn-checkAll").removeAttr('disabled');
            } else {
                $('#quantity').html(0);
                $(".btn-checkAll").attr('disabled', 'disabled');
            }
        }
        function checkAll(check = true) {
            let data = $(".checkRegister");

            if (check) {
                data.each((idx) => {
                    data[idx].checked = true;
                })
                checkCheckbox();
            } else {
                data.each((idx) => {
                    data[idx].checked = false;
                })
                checkCheckbox();
            }
        }
    </script>
    <!-- FeatherIcons -->
    <script src="<?= ICON ?>/feather.js"></script>
    <!-- Javascript -->
    <script src="<?= BASED; ?>/assets/bundles/libscripts.bundle.js"></script>
    <script src="<?= BASED; ?>/assets/bundles/vendorscripts.bundle.js"></script>
    <script src="<?= BASED; ?>/assets/bundles/mainscripts.bundle.js"></script>
    <!-- Data Table -->
    <script src="<?= BASED; ?>/assets/bundles/datatablescripts.bundle.js"></script>
    <script src="<?= BASE; ?>/assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
    <script src="<?= BASE; ?>/assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
    <!-- Select2 Js -->
    <script src="<?= BASE; ?>/assets/vendor/select2/select2.min.js"></script>
    <!--DataPicker-->
    <script src="<?= BASE; ?>/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
</body>

</html>