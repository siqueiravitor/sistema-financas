<?php
require('../../../required.php');
include_once '../../config/config.php';
include_once '../../config/connMysql.php';
include_once '../../functions/func.php';
include_once './functions.php';

$userId = $_SESSION['id'];
$id = $_GET['id'];

$typePayment = typePayment($id)[0];
if ($typePayment[0]) {
    ?>
    <div class="modal-content" id='modal-content'>
        <div class="modal-header" id='modal-header'>
            <h5 class="card-title placeholder-glow col-6 my-0" id="modal-title">
                <span class="w-100 text-tertiary">Deletar tipo de pagamento</span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body space-1 mt-2 text-center" id='modal-body'>
            <h4>Deseja deletar esse registro?</h4>
            <div class='row text-left space-2'>
                <div class='form-group col-md-12'>
                    <label>Descrição:</label>
                    <span readonly class='form-control h-auto text-left' ><?= $typePayment[2] ?></span>
                </div>
            </div>
        </div>

        <div class="modal-footer" id='modal-footer'>
            <button type="button" class="btn btn-tertiary" data-bs-dismiss="modal">Fechar</button>
            <form method='POST' action="./include/dTypePayment.php">
                <input value="<?= $typePayment[0] ?>" name='id' hidden>
                <button class="btn btn-danger" data-bs-dismiss="modal">Confirmar</button>
            </form>
        </div>
    </div>
    <?php
} else {
    ?>
    <div class="modal-content" id='modal-content'>
        <div class="modal-header" id='modal-header'>
            <h5 class="card-title placeholder-glow col-6 my-0" id="modal-title">
                <span class="w-100 text-tertiary">Deletar tipo de pagamento</span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body space-1 mt-2 text-center text-danger" id='modal-body'>
            <h4>Erro ao buscar tipo de pagamento</h4>
        </div>

        <div class="modal-footer" id='modal-footer'>
            <button type="button" class="btn btn-tertiary" data-bs-dismiss="modal">Fechar</button>
        </div>
    </div>
<?php
}
?>
