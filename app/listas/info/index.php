<?php
require('../../../required.php');
include_once '../../config/config.php';
include_once '../../functions/func.php';
include_once '../../config/security.php';
include_once '../../config/connMysql.php';
include_once './include/functions.php';

$list = filter_input_array(INPUT_GET, [
    "list" => FILTER_SANITIZE_NUMBER_INT
]);
$idList = $list['list'];
$list = getList($idList)[0];
$listId = $list[0];
$listTitle = $list[1];
$listDesc = $list[2];
$listType = $list[6];
if (empty($list)) {
    exit(header('Location: ../?msg=Erro ao buscar lista&alert=2'));
}
?>
<!doctype html>
<html lang="pt-br">

<head>
    <title>Listas -
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
            $("body").tooltip({
                selector: '[data-toggle=tooltip]'
            });

            $('#date').datepicker({
                todayHighlight: true
            });
            $(".select2").select2();
            loadItem(<?= $listId ?>);
        });
        function registerFinances(listId){
            window.location = './include/cFinance.php?listid='+listId;
        }
    </script>
    <style>
        table td:first-child,
        table th:first-child {
            text-align: center;
            width: 50%;
        }

        table td:nth-last-child(3),
        table th:nth-last-child(3) {
            text-align: center;
            border-left: 1px solid var(--color-border-lighter) !important;
            border-right: 1px solid var(--color-border-lighter) !important;
            width: 10%;
        }

        table td:nth-last-child(1),
        table th:nth-last-child(1),
        table td:nth-last-child(2),
        table th:nth-last-child(2) {
            text-align: center;
            border-left: 1px solid var(--color-border-lighter) !important;
            border-right: 1px solid var(--color-border-lighter) !important;
            width: 5%;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <?php
        include '../../include/loader.php';
        include '../../include/nav-topo.php';
        include '../../include/nav-lateral.php';
        ?>
        <div id="main-content">
            <div class="container-fluid">
                <?php
                include '../../include/breadcrumb.php';

                if (!empty($_GET["msg"])) {
                    $alert = isset($_GET["alert"]) ? $_GET["alert"] : 0;
                    echo montaAlert($alert, $_GET["msg"]);
                }
                ?>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="border-bottom mb-4">
                                    <h5 class="text-muted text-center space-1">Adicionar item</h5>
                                </div>
                                <form method="POST" action="./include/cItem.php">
                                    <input hidden name='idList' value='<?= $idList ?>'>
                                    <input hidden name='list' value='<?= $listId ?>'>
                                    <div class="form-group">
                                        <small><b>Descrição</b></small>
                                        <input class="form-control" name="description" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <small><b>Valor</b></small>
                                        <input class="form-control" id="value" placeholder="R$ 0,00" name="value" onkeyup="moneyMask(this)">
                                    </div>

                                    <div class="text-center mt-4">
                                        <button class="btn w-100 btn-success space-1">Adicionar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="border-bottom mb-4">
                                    <h5 class="text-muted text-center space-1">Lista - <b><?= $listTitle ?></b> </h5>
                                </div>

                                <div class='table-responsive'>
                                    <table class='table table-sm table-hover table-striped text-center dataTable no-footer' id='items_table'></table>
                                </div>
                                <?php
                                if($listType == 'Compras'){
                                    ?>
                                    <div class="text-right mt-4" onclick="registerFinances(<?= $listId ?>)">
                                        <button class="btn btn-success space-1">Realizar lançamento</button>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            include '../../include/footer.php';
            include '../../include/offcanva.php';
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