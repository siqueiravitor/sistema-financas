<?php
include_once '../../config/config.php';
include_once '../../functions/func.php';
include_once '../../config/connMysql.php';
include_once '../include/functions.php';

?>
<div class="form-group">
    <small><b>Valor</b></small>
    <input class="form-control" id="value" placeholder="R$ 0,00" name="value" onkeyup="moneyMask(this)" >
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
            echo "<option value='$categoria[0]'>$categoria[2]</option>";
            if ($tipo != $categoria[1]) {
                echo "</optgroup>";
            }
        }
        ?>
    </select>
</div>
<div class="form-group">
    <small> <b> Data</b> </small>
    <input class="form-control" id="date" name="date" value="<?= date('d/m/Y') ?>" >
</div>
<div class="form-group">
    <small> <b> Pagamento </b> </small>
    <select class="form-control select2" name="payment">
        <option value=""></option>
        <option value="d">Dinheiro</option>
        <option value="p">Pix</option>
        <optgroup label='Cartão'>
            <option value="cc">Crédito</option>
            <option value="cd">Débito</option>
        </optgroup>
    </select>
</div>
<div class="form-group" id='recurrenceDiv' style="display: none">
    <small> <b> Recorrência</b> </small>
    <select class="form-control select2" name="recurrence" id='recurrenceSelect' disabled>
        <?php
        $recurrences = recurrence();
        foreach ($recurrences as $recurrence) {
            echo "<option value='$recurrence[0]'>$recurrence[1]</option>";
        }
        ?>
    </select>
</div>
<div class="form-group">
    <small> <b> Descrição </b> </small>
    <textarea class="form-control" name="description" required></textarea>
</div>