<?php
require('../../../../required.php');
include '../../../config/config.php';
include '../../../config/security.php';
include '../../../functions/func.php';
include '../../../config/connMysql.php';
include './functions.php';

$id = $_GET['id'];
$idItem = $_GET['id_alt'];

$item = items($id,$idItem)[0];
?>
<div class="offcanvas-header">
    <div class="border-bottom mb-4">
        <h5 class="text-muted text-center space-1">Editar registro</h5>
    </div>
    <button type="button" class="btn-close text-reset float-right" data-bs-dismiss="offcanvas"
        aria-label="Close"></button>
</div>
<div class="offcanvas-body">
    <form method="POST" action="./include/uItem.php" id="formRegister">
        <input name="id" value='<?= $idItem ?>' hidden>
        <input name="list" value='<?= $id ?>' hidden>

        <div class="form-group">
            <small> <b> Descrição </b> </small>
            <textarea class="form-control" name="description"><?= $item[1] ?></textarea>
        </div>
        <div class="form-group">
            <small><b>Valor</b></small>
            <input class="form-control" placeholder="R$ 0,00" name="value" onkeyup="moneyBRL(this)"
                value='<?= floatToMoney($item[2]) ?>' required>
        </div>

        <div class="row">
            <div class="col-md-6">
                <button class="btn btn-danger w-100" style='position: unset' type='button' data-bs-dismiss="offcanvas"
                    aria-label="Close">
                    Cancelar
                </button>
            </div>
            <div class="col-md-6">
                <button class="btn btn-success w-100">
                    Salvar
                </button>
            </div>
        </div>
    </form>
</div>