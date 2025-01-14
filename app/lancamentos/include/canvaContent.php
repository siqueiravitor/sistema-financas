<?php
require('../../../required.php');
include_once '../../config/config.php';
include_once '../../config/connMysql.php';
include_once '../../functions/func.php';
include_once './functions.php';
?>
<div class="form-group">
    <small><b>Valor</b></small>
    <input class="form-control" id="value" placeholder="R$ 0,00" name="value" onkeyup="moneyMask(this)">
</div>
<div class="form-group">
    <small> <b> Categoria</b> </small>
    <select class="form-control select2" name="category">
        <?php
        $tipo = '';
        $categorias = categories($_SESSION['id']);
        foreach ($categorias as $categoria) {
            if ($tipo != $categoria[1]) {
                $tipo = $categoria[1] == 'in' ? 'Receita' : 'Despesa';
                echo "<optgroup label='$tipo'>";
                $tipo = $categoria[1];
            }
            echo "<option value='$categoria[0]'>$categoria[2]</option>";
            if ($tipo != $categoria[1]) {
                echo "</optgroup>";
            }
        }
        ?>
    </select>
</div>
<div class="form-group">
    <small> <b> Data </b> </small>
    <input class="form-control date" id="date" name="date" value="<?= date('d/m/Y') ?>">
</div>
<div class="form-group">
    <small> <b> Pagamento </b> </small>
    <select class="form-control select2" name="payment">
        <option value=''>Pendente</option>
        <?php
        $paymentType = paymentType($_SESSION['id']);
        foreach ($paymentType as $type) {
            echo "<option value='{$type[0]}'>$type[1]</option>";
        }
        ?>
    </select>
</div>
<div class="form-group" id='recurrenceDiv' style="display: none">
    <small> <b> Recorrência</b> </small>
    <select class="form-control select2" name="recurrence" id='recurrenceSelect' disabled>
        <option value=''>N/A</option>
        <option value='day'>Diário</option>
        <option value='week'>Semanal</option>
        <option value='month'>Mensal</option>
        <option value='year'>Anual</option>
    </select>
</div>
<div class="form-group">
    <small> <b> Descrição </b> </small>
    <textarea class="form-control" name="description"></textarea>
</div>