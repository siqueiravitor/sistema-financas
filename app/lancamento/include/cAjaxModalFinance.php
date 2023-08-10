<?php
require('../../../required.php');
include_once '../../config/config.php';
include_once '../../config/connMysql.php';
include_once '../../functions/func.php';
include_once './functions.php';

$userId = $_SESSION['id'];
$id = $_GET['id'];

$finance = recurrence($userId, $id)[0];
?>

<div class="modal-content" id='modal-content'>

    <div class="modal-header" id='modal-header'>
        <h5 class="card-title placeholder-glow col-6 my-0" id="modal-title">
            <span class="w-100 text-tertiary">Visualizar finança</span>
        </h5>

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body row space-1" id='modal-body'>
        <div class='form-group col-md-4'>
            <label>Valor das Parcelas:</label>
            <span class='form-control'>
                <?= $finance['valorParcelas'] ?>
            </span>
        </div>
        <div class='form-group col-md-3'>
            <label>Parcelas:</label>
            <span class='form-control'>
                <?= $finance['parcelas'] ?>
            </span>
        </div>
        <div class='form-group col-md-5'>
            <label>Pagamento:</label>
            <span class='form-control'>
                <?= $finance['pagamento'] ?>
            </span>
        </div>
        <div class='form-group col-md-5'>
            <label>Categoria:</label>
            <span class='form-control'>
                <?= $finance['categoria'] ?>
            </span>
        </div>
        <div class='form-group col-md-4'>
            <label>Período:</label>
            <span class='form-control'>
                <?= $finance['periodo'] ?>
            </span>
        </div>
        <div class='form-group col-md-3'>
            <label>Recorrência:</label>
            <span class='form-control'>
                <?= $finance['recorrencia'] ?>
            </span>
        </div>
        <div class='form-group col-md-12 row pr-0'>
            <div class='form-group col-md-6 space-2 text-center'>
                <label>Descrição:</label>
                <textarea readonly class='form-control h-auto text-left' style='resize: none'
                    rows='8'><?= $finance['descricaoFinanca'] ?></textarea>
            </div>
            <div class='col-md-6 border rounded p-0' id='divTableModalFinance'>
                <table class='dataTable text-center w-100'>
                    <thead>
                        <tr>
                            <th class='w-25'>Parcelas</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class='w-25'>1</td>
                            <td>R$ 510,00</td>
                        </tr>
                        <tr>
                            <td class='w-25'>2</td>
                            <td>R$ 510,00</td>
                        </tr>
                        <tr>
                            <td class='w-25'>1</td>
                            <td>R$ 510,00</td>
                        </tr>
                        <tr>
                            <td class='w-25'>2</td>
                            <td>R$ 510,00</td>
                        </tr>
                        <tr>
                            <td class='w-25'>1</td>
                            <td>R$ 510,00</td>
                        </tr>
                        <tr>
                            <td class='w-25'>2</td>
                            <td>R$ 510,00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal-footer" id='modal-footer'>
        <button type="button" class="btn btn-tertiary" data-bs-dismiss="modal">Fechar</button>
    </div>
    <!-- <div class='mb-1 pr-1'>
        <?php // include '../../include/footer.php' ?>
    </div> -->

</div>

<style>
    #divTableModalFinance::target-text,
    #divTableModalFinance: {
        border-color: var(--color-primary) !important;
    }
    #divTableModalFinance {
        max-height: 210px;
        min-height: 140px;
        overflow: auto;
    }

    #divTableModalFinance table {
        margin-top: 0 !important;
        position: relative;
    }

    #divTableModalFinance thead {
        border: none !important;
        position: sticky;
        top: 0;
        background: var(--color-tertiary);
        color: var(--color-light);
    }

    #divTableModalFinance tbody {
        border: none !important;
    }
</style>