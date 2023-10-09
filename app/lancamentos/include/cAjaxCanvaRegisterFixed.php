<?php
require_once('../../../required.php');
include_once '../../config/config.php';
include_once '../../config/conn.php';
include_once '../../functions/func.php';
include_once './functions.php';

?>
<div class='row'>
    <div class="form-group col-md-6">
        <small> <b>Recorrência</b> </small>
        <select class="form-control select2" name="recurrence">
            <option value='day'>Diário</option>
            <option value='week'>Semanal</option>
            <option value='month'>Mensal</option>
            <option value='year'>Anual</option>
        </select>
    </div>
    <div class="form-group col-md-6">
        <small> <b>Período</b> </small>
        <input class="form-control" type="number" min='1' value='1' name="period">
    </div>
</div>
<div class="form-group">
    <small><b>Valor</b></small>
    <input class="form-control" name="value" placeholder="R$ 0,00" onkeyup="moneyMask(this)">
</div>
<div class="form-group">
    <small> <b> Categoria </b> </small>
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
            echo "<option value='$type[0]'>$type[1]</option>";
        }
        ?>
    </select>
</div>
<div class="form-group">
    <small> <b> Status </b> </small>
    <select class="form-control select2" name="status">
        <option value="pending">A começar</option>
        <option value="ongoing">Atual</option>
        <option value="done">Finalizado</option>
    </select>
</div>
<div class="form-group">
    <small> <b> Descrição </b> </small>
    <textarea class="form-control" name="description"></textarea>
</div>