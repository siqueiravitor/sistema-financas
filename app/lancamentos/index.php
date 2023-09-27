<?php
require('../../required.php');
include_once '../config/config.php';
include_once '../functions/func.php';
include_once '../config/security.php';
include_once '../config/connMysql.php';
include_once './include/functions.php';

$month = isset($_GET['month']) ? $_GET['month'] : date('m');
$getYear = isset($_GET['year']) ? $_GET['year'] : date('Y');
$get_date = getMonthYear($month, $getYear);
$date = $get_date ? $get_date : null;

$financeValues = financeValues($date);

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
            let month = $("#month").val();
            let year = $("#year").val();
            loadFinances(month, year)
            canvaContent()
            $('#date').datepicker({ todayHighlight: true });
            $(".select2").select2();

            $("#date-year").datepicker({altFormat: "yy-mm-dd"});
        });
    </script>
    <style>
        #management-table svg {
            width: .9rem !important;
            height: .9rem !important;
        }

        #management-table td:first-child,
        #management-table th:first-child {
            text-align: center;
            border-right: 1px solid var(--color-border-lighter) !important;
        }

        #management-table td:nth-last-child(3),
        #management-table th:nth-last-child(3),
        #management-table td:nth-last-child(2),
        #management-table th:nth-last-child(2) {
            text-align: center;
            border-left: 1px solid var(--color-border-lighter) !important;
            border-right: 1px solid var(--color-border-lighter) !important;
        }

        td a {
            color: var(--color-info)
        }

        .card-info {
            color: var(--color-light);
            border-radius: 4px;
        }

        .moneyLabel {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .btn-hover{
            color: #777;
            border: 1px solid #999;
            transition: .3s padding-right;
            cursor: pointer;
        }
        .btn-hover:hover{
            border-color: transparent;
            padding-right: 0;
        }
        .icon-btn-hover{
            display:none;
            width: 1rem; 
            height: 1rem;
            margin-bottom: .3rem;
        }
        .btn-hover:hover .icon-btn-hover{
            display: unset;
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
                <input id='month' value='<?=$month?>' hidden>
                <input id='year' value='<?=$getYear?>' hidden>
                <?php
                include '../include/breadcrumb.php';

                if (!empty($_GET["msg"])) {
                    $alert = isset($_GET["alert"]) ? $_GET["alert"] : 0;
                    echo montaAlert($alert, $_GET["msg"]);
                }
                ?>
                <div class='top-menu-right'>
                    <small class='font-12 btn-hover btn btn-sm' aria-controls='ocNewRecord' 
                            data-bs-toggle='offcanvas' data-bs-target='#filterPeriod' class='d-block'>
                        <i data-feather='filter' class='icon-btn-hover'></i></a>
                        Ver Filtros
                    </small>
                </div>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="filterPeriod" aria-labelledby="filterPeriod">
                    <div class="offcanvas-header">
                        <div class="border-bottom mb-4">
                            <h5 class="text-muted text-center space-1">Filtros</h5>
                        </div>
                        <button type="button" class="btn-close text-reset float-right" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <form method='GET' action='./'>
                            <div class="form-group">
                                <small> <b> Mês </b> </small>
                                <select class='form-control select2' name='month'>
                                    <option value=''>Todo o período</option>
                                    <?php
                                        foreach(getMonths() as $idx=>$months){
                                            $index = $idx+1;
                                            $selected = $index == $month ? 'selected' : null;
                                            echo "<option value='$index' $selected>$months</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <small> <b> Ano </b> </small>
                                <input class='form-control' type="number" min="1900" max="2099" step="1" value="<?= date('Y') ?>" />
                            </div>
                            
                            <div class="text-center">
                                <button class="btn w-100 btn-success space-1">Aplicar</button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="offcanvas-footer mr-2">
                        <?php include '../include/footer.php' ?>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-2 col-md-6">
                        <div class="card card-info">
                            <div class="card-body card-body-info card-border-left card-border-success shadow-sm">
                                Entrada (R$)
                                <div class='moneyLabel'>
                                    <?= floatToMoney($financeValues['recebido'], null) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="card card-info">
                            <div class="card-body card-body-info card-border-right card-border-success shadow-sm">
                                A receber (R$)
                                <div class='moneyLabel'>
                                    <?= floatToMoney($financeValues['receber'], null) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <div class="card card-info">
                            <div class="card-body card-body-info card-border-left card-border-right card-border-info shadow-sm">
                                Saldo Geral | Previsão(R$)
                                <div class='moneyLabel'>
                                    <?= floatToMoney($financeValues['totalRecebido'], null) . ' |<wbr> ' . floatToMoney($financeValues['total'], null)  ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="card card-info">
                            <div class="card-body card-body-info card-border-left card-border-danger shadow-sm">
                                Saída (R$)
                                <div class='moneyLabel'>
                                    <?= floatToMoney($financeValues['pago'], null) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="card card-info">
                            <div class="card-body card-body-info card-border-right card-border-danger shadow-sm">
                                A pagar (R$)
                                <div class='moneyLabel'>
                                    <?= floatToMoney($financeValues['pagar'], null) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="border-bottom mb-4 d-flex">
                                    <div class='flex-6 text-right'>
                                        <h5 class="text-muted space-1">Lançamentos</h5>
                                    </div>
                                    <div class='flex-5 text-right'>
                                        <h5 class="text-muted space-1"><?= dateText($month, $getYear) ?></h5>
                                    </div>
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
                                            <button class='btn btn-outline-danger btn-checkAll mb-2' disabled onclick='deleteSelected()' 
                                                data-bs-toggle='modal' data-bs-target='#modalTemplate' class='d-block'>
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
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            include './include/canvaRegisterFinance.php';
            include '../include/footer.php';
            include '../include/offcanva.php';
            ?>
        </div>
    </div>
    <!-- FeatherIcons -->
    <script src="<?= ICON ?>/feather.js"></script>
    <!-- Javascript -->
    <script src="./include/functions.js"></script>
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