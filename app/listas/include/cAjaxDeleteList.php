<?php
require('../../../required.php');
include_once '../../config/config.php';
include_once '../../config/connMysql.php';
include_once '../../functions/func.php';
include_once './functions.php';

$userId = $_SESSION['id'];
$id = $_GET['id'];

$list = lists($id)[0];

if ($list['id']) {
    ?>
    <div class="modal-content" id='modal-content'>

        <div class="modal-header" id='modal-header'>
            <h5 class="card-title placeholder-glow col-6 my-0" id="modal-title">
                <span class="w-100 text-tertiary">Deletar Lista</span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body space-1 mt-2 text-center" id='modal-body'>
            <h4>Deseja deletar esse registro?</h4>
            <div class='row text-left space-2'>
                <div class='form-group col-md-12'>
                    <label>Título:</label>
                    <span class='form-control' readonly>
                        <?= $list['name'] ?>
                    </span>
                </div>
                <div class='form-group col-md-12'>
                    <label>Descrição:</label>
                    <textarea readonly class='form-control h-auto text-left' style='resize: none'
                        rows='3'><?= $list['description'] ?></textarea>
                </div>
            </div>
        </div>

        <div class="modal-footer" id='modal-footer'>
            <button type="button" class="btn btn-tertiary" data-bs-dismiss="modal">Fechar</button>
            <form method='POST' action="./include/dList.php">
                <input value="<?= $list['id'] ?>" name='id' hidden>
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
                <span class="w-100 text-tertiary">Deletar lista</span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body space-1 mt-2 text-center text-danger" id='modal-body'>
            <h4>Erro ao buscar lista</h4>
        </div>

        <div class="modal-footer" id='modal-footer'>
            <button type="button" class="btn btn-tertiary" data-bs-dismiss="modal">Fechar</button>
        </div>
    </div>
<?php
}
?>
