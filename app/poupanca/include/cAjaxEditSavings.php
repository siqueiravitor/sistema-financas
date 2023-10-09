<?php

require_once('../../../required.php');
include_once '../../config/config.php';
include_once '../../config/conn.php';
include_once '../../functions/func.php';
include_once './functions.php';

$id = $_GET['id'];
$savings = savings($id)[0];

?>
<div class="offcanvas-header">
    <div class="border-bottom mb-4">
        <h5 class="text-muted text-center space-1">Editar Poupança</h5>
    </div>
    <button type="button" class="btn-close text-reset float-right" data-bs-dismiss="offcanvas"
        aria-label="Close"></button>
</div>
<div class="offcanvas-body">
    <form method="POST" action="./include/uSavings.php" id="formRegister">
        <input name="id" value='<?= $id ?>' hidden>

        <div class="form-group">
            <small> <b> Nome </b> </small>
            <input class="form-control" name="name" value='<?= $savings['name'] ?>'>
        </div>
        <div class="form-group">
            <small> <b> Descrição </b> </small>
            <textarea class="form-control" name="description"><?= $savings['description'] ?></textarea>
        </div>
        <div class="form-group">
            <small> <b> Guardado </b> </small>
            <input class="form-control" disabled value='<?= floatToMoney($savings['reserved']) ?>'>
        </div>
        <div class="form-group">
            <small> <b> Definir meta </b> </small>
            <input class="form-control" placeholder="R$ 0,00" name="goal" 
            onkeyup="moneyBRL(this)" value='<?= floatToMoney($savings['goal']) ?>' required>
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