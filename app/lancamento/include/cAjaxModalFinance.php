<?php
include_once '../../config/config.php';
include_once '../../functions/func.php';
include_once '../../config/connMysql.php';
include_once '../include/functions.php';

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

    <div class="modal-body row" id='modal-body'>
        <div class='form-group col-12'>
            <label>Descrição:</label>
            <span class='form-control h-auto'>
                <?= $finance['descricaoFinanca'] ?>
            </span>
        </div>
        <div class='form-group col-3'>
            <label>Pagamento:</label>
            <span class='form-control'>
                <?= $finance['pagamento'] ?>
            </span>
        </div>
        <div class='form-group col-3'>
            <label>Categoria:</label>
            <span class='form-control'>
                <?= $finance['categoria'] ?>
            </span>
        </div>
        <div class='form-group col-3'>
            <label>Período:</label>
            <span class='form-control'>
                <?= $finance['periodo'] ?>
            </span>
        </div>
        <div class='form-group col-3'>
            <label>Recorrência:</label>
            <span class='form-control'>
                <?= $finance['recorrencia'] ?>
            </span>
        </div>
        <div class='form-group col-6'>
            <div class='form-group'>
                <label>Valor das Parcelas:</label>
                <span class='form-control'>
                    <?= $finance['valorParcelas'] ?>
                </span>
            </div>
            <div class='form-group'>
                <label>Quantidade de Parcelas:</label>
                <span class='form-control'>
                    <?= $finance['parcelas'] ?>
                </span>
            </div>
        </div>
        <div class='form-group col-6'>
            <table class='dataTable w-100'>
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

    <div class="modal-footer" id='modal-footer'>
        <button type="button" class="btn btn-tertiary" data-bs-dismiss="modal">Fechar</button>
    </div>
    <!-- <div class='mb-1 pr-1'>
        <?php // include '../../include/footer.php' ?>
    </div> -->

</div>