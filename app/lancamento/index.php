<?php
include_once '../config/config.php';
include_once '../functions/func.php';
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
                    "targets": [0, 8, 9],
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

        td:first-child,
        th:first-child {
            text-align: center;
            border-right: 1px solid var(--color-border-lighter) !important;
        }

        td:nth-last-child(2),
        th:nth-last-child(2),
        td:last-child,
        th:last-child {
            text-align: center;
            border-left: 1px solid var(--color-border-lighter) !important;
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
                echo 'PHP version: ' . phpversion();
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="border-bottom mb-4">
                                    <h5 class="text-muted text-center space-1">Lançamentos</h5>
                                </div>
                                <div class='table-responsive'>
                                    <div class='row mr-0' id='deleteSelected'>
                                        <div style='position: absolute; top: 4rem; width: initial!important;'>
                                            <span id='quantity'> 0 </span> Selecionado(s)
                                        </div>
                                        <div class='col-md-12 pr-0'>
                                            <button class='btn btn-outline-tertiary mb-2' onclick='checkAll()'>
                                                Selecionar todos
                                            </button>
                                            <button class='btn btn-outline-tertiary btn-checkAll mb-2' disabled
                                                onclick='checkAll(false)'>
                                                Deselecionar todos
                                            </button>
                                            <button class='btn btn-outline-danger btn-checkAll mb-2' disabled
                                                onclick='deleteSelected()'>
                                                Deletar selecionados
                                            </button>
                                            <div class='d-inline-block float-right'>
                                                <button class="btn btn-info mb-2" type="button"
                                                    aria-controls="ocNewRecord" data-bs-toggle="offcanvas"
                                                    data-bs-target="#ocNewRecord">
                                                    Novo registro
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <table id="management-table"
                                        class="table table-sm table-hover table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Tipo</th>
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
                                                    $tipo = $finance['tipo'] == 'e' ? 'Entrada' : 'Saída ';
                                                    $payment = $finance['pagamento'];
                                                    if ($payment == 'p') {
                                                        $payment = 'Pix';
                                                    } elseif ($payment == 'd') {
                                                        $payment = 'Dinheiro';
                                                    } elseif ($payment == 'cd') {
                                                        $payment = 'Crédito';
                                                    } elseif ($payment == 'cc') {
                                                        $payment = 'Débito';
                                                    }
                                                    // $payment = match($payment){
                                                    //     'p' => "Pix",
                                                    //     'd' => "Dinheiro",
                                                    //     'cd' => "Crédito",
                                                    //     'cc' => "Débito",
                                                    //     default => ""
                                                    // };
                                            
                                                    echo "<tr>";
                                                    echo "<td class='checkboxArea'><input type='checkbox' value='" . $finance['id'] . "' class='checkRegister' onchange='checkCheckbox()'></td>";
                                                    echo "<td>{$tipo}</td>";
                                                    echo "<td>{$value}</td>";
                                                    echo "<td>{$finance['categoria']}</td>";
                                                    echo "<td style='white-space: normal'>{$finance['descFinanca']}</td>";
                                                    echo "<td>{$payment}</td>";
                                                    echo "<td>{$recurrence}</td>";
                                                    echo "<td>{$date}</td>";
                                                    echo "<td>{$dategen}</td>";
                                                    echo "<td><a onclick='loadFinanceData({$finance['id']})' href='#' aria-controls='ocNewRecord' data-bs-toggle='offcanvas' data-bs-target='#ocTemplate' class='d-block'>
                                                                <i data-feather='edit'></i></a>
                                                        </td>";
                                                    echo "<td><a href='./include/dFinance.php?id={$finance['id']}' class='d-block'>
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
            include './include/offcanvaRegisterFinance.php';
            include '../include/footer.php';
            ?>
        </div>
    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="ocTemplate" aria-labelledby="ocTemplate">
        <div class="offcanvas-body offcanvas-loading">
            <i class='fa-spin fa fa-spinner'></i> Carregando...
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
        // A j a x
        function recurrenceOptions(value) {
            let url = './include/offcanvaRegisterUnique.php';
            if (value !== 'u') {
                url = './include/offcanvaRegisterInstallment.php';
            }

            var request = $.ajax({
                url,
                dataType: "html",
                beforeSend: function () {
                    $("#divBodyFinance").html(divLoading);
                }
            });
            request.done(function (data) {
                $("#divBodyFinance").html(data);

                $(".select2").select2('destroy');
                $(".select2").select2();
                $(".date").datepicker('refresh');
            });
            request.fail(function (jqXHR, textStatus) {
                $("#ocNewRecord").html(divError(textStatus));
            });
        }
        function loadFinanceData(id) {
            let url = 'include/cAjaxEditFinance.php';
            var request = $.ajax({
                url,
                data: { id },
                method: "GET",
                dataType: "html",
                beforeSend: function () {
                    $("#ocTemplate").html(divLoading);
                }
            });
            request.done(function (data) {
                $("#ocTemplate").html(data);
                
                $(".select2").select2('destroy');
                $(".select2").select2();
                $(".date").datepicker('refresh');
            });
            request.fail(function (jqXHR, textStatus) {
                $("#ocTemplate").html(divError(textStatus));
            });
        }
        // A j a x End
    </script>
    <!-- FeatherIcons -->
    <script src="<?= ICON ?>/feather.js"></script>
    <!-- Javascript -->
    <script src="<?= BASE; ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
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