<?php

require('../../../required.php');
include_once '../../config/config.php';
include_once '../../config/connMysql.php';
include_once '../../functions/func.php';
include_once './functions.php';

$id = $_GET['id'];
$savings = savings($id)[0];
$goal = $savings['goal'] != 0.00 ? $savings['goal'] : null;

?>

<div class="offcanvas-header">
    <div class="border-bottom mb-4">
        <h5 class="text-muted text-center space-1">
            <?= $savings['name'] ?>
        </h5>
    </div>
    <button type="button" class="btn-close text-reset float-right" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<?php
if ($goal) {
?>
    <div class="offcanvas-body">
        <form method="POST" action="./include/uInfoSavings.php" id="formRegister">
            <input name="goal" value='true' hidden>
            <input name="id" value='<?= $id ?>' hidden>
            <div class="form-group">
                <small> <b> Descrição </b> </small>
                <span class="form-control form-description" readonly>
                    <?= $savings['description'] ?>
                </span>
            </div>
            <div class="form-group">
                <small> <b> Poupança </b> </small>
                <input class="form-control form-description" readonly value='<?= floatToMoney($savings['reserved']) ?>' id='reserved'>
            </div>
            <div class="form-group">
                <small> <b> Meta definidda </b> </small>
                <input class="form-control form-description" readonly value='<?= floatToMoney($savings['goal']) ?>' id='goal'>
            </div>
            <div class="form-group">
                <small> <b> Valor até atingir a meta </b> </small>
                <span class="form-control form-description" readonly>
                    <?= floatToMoney($savings['missing']) ?>
                </span>
            </div>
            <div class="form-group mb-2">
                <small> <b> Valor </b> </small>
                <input class="form-control" name="value" placeholder="R$ 0,00" id='newValue' onkeyup="changeValue(<?= $savings['reserved'] ?>, <?= $savings['goal'] ?>)" autocomplete="off">
            </div>
            <div class="row mx-0">
                <div class="form-check col-md-6">
                    <input class="form-check-input savings-radio" type="radio" name="savings-radio" onclick="changeRadio('save')" value='save' id="save" checked>
                    <label class="form-check-label" for="save" onclick="changeRadio('save')">
                        Guardar
                    </label>
                </div>
                <div class="form-check col-md-6">
                    <input class="form-check-input savings-radio" type="radio" name="savings-radio" onclick="changeRadio('withdraw')" value='withdraw' id="withdraw">
                    <label class="form-check-label" for="withdraw" onclick="changeRadio('withdraw')">
                        Retirar
                    </label>
                </div>
            </div>
            <div class="form-group">
                <small> <b> Novo montante </b> </small>
                <span class="form-control form-description" readonly id='new-value'>
                    <?= floatToMoney($savings['reserved']) ?>
                </span>
            </div>
            <div class="form-group">
                <small> <b> Faltante </b> </small>
                <span class="form-control form-description" readonly id='missing-value'>
                    <?= floatToMoney($savings['missing']) ?>
                </span>
                <div class="progress" role="progressbar" aria-label="missingvalue" aria-valuenow="<?= $savings['reserved'] ?>" aria-valuemin="0" aria-valuemax="<?= $savings['goal'] ?>">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: <?= ($savings['reserved'] / $savings['goal']) * 100 ?>%" id='missing-value-bar'></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-danger w-100" style='position: unset' type='button' data-bs-dismiss="offcanvas" aria-label="Close">
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
<?php
} else {
?>
    <div class="offcanvas-body">
        <form method="POST" action="./include/uInfoSavings.php" id="formRegister">
            <input name="id" value='<?= $id ?>' hidden>
            <div class="form-group">
                <small> <b> Descrição </b> </small>
                <span class="form-control form-description" readonly>
                    <?= $savings['description'] ?>
                </span>
            </div>
            <div class="form-group">
                <small> <b> Poupança </b> </small>
                <input class="form-control form-description" readonly value='<?= floatToMoney($savings['reserved']) ?>' id='reserved'>
            </div>
            <div class="form-group mb-2">
                <small> <b> Valor </b> </small>
                <input class="form-control" name="value" placeholder="R$ 0,00" id='newValue' onkeyup="changeNewValue(<?= $savings['reserved'] ?>, <?= $savings['goal'] ?>)" autocomplete="off">
            </div>
            <div class="row mx-0">
                <div class="form-check col-md-6">
                    <input class="form-check-input savings-radio" type="radio" name="savings-radio" onclick="changeNewRadio('save')" value='save' id="save" checked>
                    <label class="form-check-label" for="save" onclick="changeNewRadio('save')">
                        Guardar
                    </label>
                </div>
                <div class="form-check col-md-6">
                    <input class="form-check-input savings-radio" type="radio" name="savings-radio" onclick="changeNewRadio('withdraw')" value='withdraw' id="withdraw">
                    <label class="form-check-label" for="withdraw" onclick="changeNewRadio('withdraw')">
                        Retirar
                    </label>
                </div>
            </div>
            <div class="form-group">
                <small> <b> Novo montante </b> </small>
                <span class="form-control form-description" readonly id='new-value'>
                    <?= floatToMoney($savings['reserved']) ?>
                </span>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-danger w-100" style='position: unset' type='button' data-bs-dismiss="offcanvas" aria-label="Close">
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
<?php
}
?>
<script>
    function changeValue(reserved, goal) {
        let value = moneytToFloat($("#newValue").val());
        $("#newValue").val(floatToBRL(value));

        var arr = $(".savings-radio").map(function() {
            if (this.hasAttribute('checked')) {
                checked = this.value;
            }
        }).get();

        let percent, newValue, missingValue;

        if (checked === 'save') {
            newValue = value + reserved;

            diffValue = goal - (newValue);
            missingValue = diffValue > 0 ? diffValue : 0;
            $("#missing-value").html(floatToBRL(missingValue));
        }
        if (checked === 'withdraw') {
            newValue = reserved - value;
            newValue = newValue <= 0 ? 0 : newValue;

            diffValue = goal - (newValue);
            missingValue = value < reserved ? diffValue : goal;

            if (value > reserved) {
                $("#newValue").val(floatToBRL(reserved));
            }
            if (newValue > goal) {
                $("#missing-value").val(floatToBRL(0));
            } else {
                $("#missing-value").html(floatToBRL(missingValue));
            }
        }

        $("#new-value").html(floatToBRL(newValue));

        percent = ((newValue) / goal) * 100
        percent = percent < 100 ? percent : 100;
        percent = percent + '%';
        $("#missing-value-bar").css('width', percent);
    }

    function changeRadio(value) {
        let reserved = moneytToFloat($("#reserved").val());
        let goal = moneytToFloat($("#goal").val());
        if (value === 'save') {
            $("#withdraw").removeAttr('checked')
            $("#save").attr('checked', true)
        } else {
            $("#withdraw").attr('checked', true)
            $("#save").removeAttr('checked')

            let newValue = $("#newValue");
            let value = moneytToFloat(newValue.val());

            if (value > reserved) {
                newValue.val(floatToBRL(reserved));
            }
        }

        changeValue(reserved, goal)
    }

    function changeNewValue(reserved) {
        let value = moneytToFloat($("#newValue").val());
        $("#newValue").val(floatToBRL(value));

        var arr = $(".savings-radio").map(function() {
            if (this.hasAttribute('checked')) {
                checked = this.value;
            }
        }).get();

        let percent, newValue;

        if (checked === 'save') {
            newValue = value + reserved;

        }
        if (checked === 'withdraw') {
            newValue = reserved - value;
            newValue = newValue <= 0 ? 0 : newValue;

            if (value > reserved) {
                $("#newValue").val(floatToBRL(reserved));
            }
        }

        $("#new-value").html(floatToBRL(newValue));
    }

    function changeNewRadio(value) {
        let reserved = moneytToFloat($("#reserved").val());
        if (value === 'save') {
            $("#withdraw").removeAttr('checked')
            $("#save").attr('checked', true)
        } else {
            $("#withdraw").attr('checked', true)
            $("#save").removeAttr('checked')

            let newValue = $("#newValue");
            let value = moneytToFloat(newValue.val());

            if (value > reserved) {
                newValue.val(floatToBRL(reserved));
            }
        }

        changeNewValue(reserved)
    }
</script>
<style>
    .progress {
        background-color: #26947177;
    }

    .form-check {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-check-label,
    .form-check-input {
        margin-top: unset !important;
        margin-bottom: unset !important;
    }

    .form-check-label {
        margin-left: 0.3rem !important;
    }

    .form-group .progress {
        height: 0.6rem;
        margin-top: 0.5rem;
    }
</style>