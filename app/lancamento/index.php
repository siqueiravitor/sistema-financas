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
                    "targets": [0, 9, 10, 11],
                    "orderable": false
                }]
            });
            $(".select2").select2();
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

        td:nth-last-child(3),
        th:nth-last-child(3),
        td:nth-last-child(2),
        th:nth-last-child(2) {
            text-align: center;
            border-left: 1px solid var(--color-border-lighter) !important;
            border-right: 1px solid var(--color-border-lighter) !important;
        }

        td a {
            color: var(--color-info)
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
                                        <?php include './include/tableFinance.php' ?>
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
            let url = './include/cAjaxCanvaRegisterUnique.php';
            if (value === 'f') {
                url = './include/cAjaxCanvaRegisterFixed.php';
            } else if (value === 'i') {
                url = './include/cAjaxCanvaRegisterInstallment.php';
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
            let url = './include/cAjaxEditFinance.php';
            const request = $.ajax({
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
        function infoFinance(id) {
            let url = './include/cAjaxFinance.php';

            const request = $.ajax({
                url,
                data: { id },
                method: "GET",
                dataType: "html",
                beforeSend: function () {
                    $("#modal-content").html(divLoading);
                }
            });
            request.done(function (data) {
                console.log(data)
                $("#modal-content").html(data);
            });
            request.fail(function (jqXHR, textStatus) {
                $("#modal-content").html(divError(textStatus));
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