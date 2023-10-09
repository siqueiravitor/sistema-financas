<?php
require_once('../../../required.php');
include_once '../../config/config.php';
include_once '../../config/conn.php';
include_once '../../functions/func.php';
include_once './functions.php';

$userId = $_SESSION['id'];
$id = $_GET['id'];

$finance = dataFinance($userId, $id)[1];
?>
<div class="modal-header" id='modal-header'>
    <h5 class="card-title rounded col-6 my-0 text-tertiary">
        Registrar pagamento
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form method="POST" action="./include/cPayment.php">
    <div class="modal-body" id='modal-body'>
        <input name="id" value='<?= $id ?>' hidden>
        <div class="form-group">
            <small><b>Valor</b></small>
            <input class="form-control" placeholder="R$ 0,00" name="value" 
            onkeyup="moneyBRL(this)" value='<?= floatToMoney($finance['valor']) ?>' required>
        </div>
        <div class="form-group">
            <small> <b> Categoria</b> </small>
            <select class="form-control select2" name="category">
                <?php
                $categoryDesc = $finance['categoria'];
                $categoryId = $finance['idCategory'];
                echo "<option value='{$categoryId}' selected>$categoryDesc</option>";
                ?>
            </select>
        </div>
        
        <div class="form-group">
            <small> <b> Pagamento </b> </small>
            <select class="form-control select2" name="payment">
                <?php
                $paymentType = paymentType($_SESSION['id']);
                foreach ($paymentType as $type) {
                    echo "<option value='{$type[0]}'>$type[1]</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <small> <b> Descrição </b> </small>
            <textarea class="form-control" name="description"><?= $finance['descricaoFinanca'] ?></textarea>
        </div>
    </div>
    <div class="modal-footer" id='modal-footer'>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-success" data-bs-dismiss="modal">Confirmar</button>
    </div>
</form>