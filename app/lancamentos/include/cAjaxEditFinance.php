<?php

require('../../../required.php');
include_once '../../config/config.php';
include_once '../../config/connMysql.php';
include_once '../../functions/func.php';
include_once './functions.php';


$userId = $_SESSION['id'];
$id = $_GET['id'];

$finance = dataFinance($userId, $id)[1];

?>
<div class="offcanvas-header">
    <div class="border-bottom mb-4">
        <h5 class="text-muted text-center space-1">Editar registro</h5>
    </div>
    <button type="button" class="btn-close text-reset float-right" data-bs-dismiss="offcanvas"
        aria-label="Close"></button>
</div>
<div class="offcanvas-body">
    <form method="POST" action="./include/uFinance.php" id="formRegister">
        <input name="id" value='<?= $id ?>' hidden>
        <div class="form-group">
            <small><b>Valor</b></small>
            <input class="form-control" placeholder="R$ 0,00" name="value" onkeyup="moneyMask(this)"
                value='<?= floatToMoney($finance['valor']) ?>' required>
        </div>
        <div class="form-group">
            <small> <b> Categoria</b> </small>
            <select class="form-control select2" name="category">
                <?php
                $tipo = '';
                $categorias = categories($_SESSION['id']);
                foreach ($categorias as $categoria) {
                    if ($tipo != $categoria[1]) {
                        $tipo = $categoria[1] == 'e' ? 'Receita' : 'Despesa';
                        echo "<optgroup label='$tipo'>";
                        $tipo = $categoria[1];
                    }
                    $selected = $finance['categoria'] == $categoria[2] ? 'selected' : null;

                    echo "<option value='$categoria[0]' $selected>$categoria[2]</option>";

                    if ($tipo != $categoria[1]) {
                        echo "</optgroup>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <small> <b> Data</b> </small>
            <input class="form-control" id="date" name="date" value="<?= dateConvert($finance['data'], '-', '/') ?>"
                value='<?= $finance['data'] ?>' required>
        </div>
        <div class="form-group">
            <small> <b> Pagamento </b> </small>
            <select class="form-control select2" name="payment"> -->
                <option value="" <?= empty($finance['pagamento']) ? 'selected' : null ?>>Pendente</option>
                <option value="b" <?= $finance['pagamento'] == 'Dinheiro' ? 'selected' : null ?>>Dinheiro</option>
                <option value="p" <?= $finance['pagamento'] == 'Pix' ? 'selected' : null ?>>Pix</option>
                <optgroup label='Cartão'>
                    <option value="c" <?= $finance['pagamento'] == 'Crédito' ? 'selected' : null ?>>Crédito</option>
                    <option value="d" <?= $finance['pagamento'] == 'Débito' ? 'selected' : null ?>>Débito</option>
                </optgroup>
            </select>
        </div>

        <div class="form-group">
            <small> <b> Descrição </b> </small>
            <textarea class="form-control" name="description"><?= $finance['descricaoFinanca'] ?></textarea>
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

<div class="offcanvas-footer mr-2">
    <?php include '../../include/footer.php' ?>
</div>