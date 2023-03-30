<?php
include_once '../../config/config.php';
include_once '../../functions/func.php';
include_once '../../config/connMysql.php';
include_once '../include/functions.php';

$userId = $_SESSION['id'];
$id = $_GET['id'];

$finance = dataFinance($userId, $id)[1];
?>

<div class="modal-content" id='modal-content'>

    <div class="modal-header" id='modal-header'>
        <h5 class="card-title placeholder-glow col-6 my-0" id="modal-title">
            <span class="w-100 text-tertiary"><?= $finance['descFinanca'] ?></span>
        </h5>

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body" id='modal-body'>
        <h5 class="placeholder-glow rounded col-12 my-0">
            <span class="placeholder placeholder-sm rounded w-100 bg-tertiary"></span>
        </h5>
        <h5 class="placeholder-glow rounded col-6 my-0">
            <span class="placeholder placeholder-sm rounded w-100 bg-tertiary"></span>
        </h5>
    </div>

    <div class="modal-footer" id='modal-footer'>
        <button type="button" class="btn btn-tertiary" data-bs-dismiss="modal">Fechar</button>
        <a href="#" tabindex="-1" class="btn btn-success disabled placeholder col-2"></a>
    </div>
    <div class='mb-1 pr-1'>
        <?php include '../../include/footer.php' ?>
    </div>

</div>