<div class="offcanvas offcanvas-end" tabindex="-1" id="ocNewRecord" aria-labelledby="ocNewRecord">
    <div class="offcanvas-header">
        <div class="border-bottom mb-4">
            <h5 class="text-muted text-center space-1">Registrar entrada/saída</h5>
        </div>
        <button type="button" class="btn-close text-reset float-right" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form method="POST" action="./include/rFinance.php" id="formRegister">
            <div class="form-group">
                <small> <b> Repetição</b> </small>
                <select class="form-control select2" name="recurrence" onchange='recurrenceOptions(this.value)'>
                    <option value="u">Única</option>
                    <option value="f">Fixa</option>
                    <option value="p">Parcelada</option>
                </select>
            </div>

            <div id='divBodyFinance'>
                <div class="form-group">
                    <small><b>Valor</b></small>
                    <input class="form-control" id="value" placeholder="R$ 0,00" name="value" onkeyup="moneyMask(this)"
                        required>
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
                    <input class="form-control date" id="date" name="date" value="<?= date('d/m/Y') ?>" required>
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
                    <textarea class="form-control" name="description"></textarea>
                </div>


                <div class="text-center">
                    <button class="btn w-100 btn-success space-1">Registrar</button>
                </div>
            </div>
        </form>
    </div>
    <div class="offcanvas-footer mr-2">
        <?php include '../include/footer.php' ?>
    </div>
</div>