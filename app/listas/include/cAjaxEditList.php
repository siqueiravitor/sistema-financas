<?php

require('../../../required.php');
include_once '../../config/config.php';
include_once '../../config/connMysql.php';
include_once '../../functions/func.php';
include_once './functions.php';

$id = $_GET['id'];

$list = lists($id)[0];
?>
<div class="offcanvas-header">
    <div class="border-bottom mb-4">
        <h5 class="text-muted text-center space-1">Editar registro</h5>
    </div>
    <button type="button" class="btn-close text-reset float-right" data-bs-dismiss="offcanvas"
        aria-label="Close"></button>
</div>
<div class="offcanvas-body">
    <form method="POST" action="./include/uList.php" id="formRegister">
        <input name="id" value='<?= $id ?>' hidden>

        <div class="form-group">
            <small> <b> Título </b> </small>
            <input class="form-control" name='title' value='<?= $list[1] ?>'>
        </div>
        <div class="form-group">
            <small> <b> Descrição </b> </small>
            <textarea class="form-control" name="description"><?= $list[2] ?></textarea>
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