<?php

include '../../config/config.php';
include '../../config/connMysql.php';
include '../../functions/func.php';
include './functions.php';

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
                $categorias = categories();
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
            <input class="form-control" id="date" name="date" value="<?= date('d/m/Y') ?>"
                value='<?= $finance['data'] ?>' required>
        </div>
        <div class="form-group">
            <small> <b> Pagamento </b> </small>
            <select class="form-control select2" name="payment">
                <option value="" <?= empty($finance['pagamento']) ? 'selected' : null ?>></option>
                <option value="b" <?= $finance['pagamento'] == 'd' ? 'selected' : null ?>>Dinheiro</option>
                <option value="p" <?= $finance['pagamento'] == 'p' ? 'selected' : null ?>>Pix</option>
                <optgroup label='Cartão'>
                    <option value="c" <?= $finance['pagamento'] == 'cc' ? 'selected' : null ?>>Crédito</option>
                    <option value="d" <?= $finance['pagamento'] == 'cd' ? 'selected' : null ?>>Débito</option>
                </optgroup>
            </select>
        </div>
        <div class="form-group">
            <small> <b> Repetição</b> </small>
            <select class="form-control select2" name="recurrence">
                <option value="u" <?= $finance['recorrente'] == 'u' ? 'selected' : null ?>>Única</option>
                <option value="f" <?= $finance['recorrente'] == 'f' ? 'selected' : null ?>>Fixa</option>
                <option value="p" <?= $finance['recorrente'] == 'p' ? 'selected' : null ?>>Parcelada</option>
            </select>
        </div>


        <div class="form-group">
            <small> <b> Descrição </b> </small>
            <textarea class="form-control" name="description"><?= $finance['descFinanca'] ?></textarea>
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