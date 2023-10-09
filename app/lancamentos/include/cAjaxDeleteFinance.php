<?php
require_once('../../../required.php');
include_once '../../config/config.php';
include_once '../../config/conn.php';
include_once '../../functions/func.php';
include_once './functions.php';

$userId = $_SESSION['id'];
$id = $_GET['id'];
$mult = isset($_GET['mult']) ? $_GET['mult'] : null;

if (!$mult) {
    $dataFinance = dataFinance($userId, $id);
    if ($dataFinance[0]) {
        $finance = $dataFinance[1];
?>
        <div class="modal-content" id='modal-content'>

            <div class="modal-header" id='modal-header'>
                <h5 class="card-title placeholder-glow col-6 my-0" id="modal-title">
                    <span class="w-100 text-tertiary">Deletar registro</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body space-1 mt-2 text-center" id='modal-body'>
                <h4>Deseja deletar esse registro?</h4>
                <div class='row text-left'>
                    <div class='form-group col-md-6'>
                        <label>Categoria:</label>
                        <span class='form-control' readonly>
                            <?= $finance['categoria'] ?>
                        </span>
                    </div>
                    <div class='form-group col-md-6'>
                        <label>Valor:</label>
                        <span class='form-control' readonly>
                            <?= floatToMoney($finance['valor']) ?>
                        </span>
                    </div>
                    <div class='form-group col-md-12 space-2'>
                        <label>Descrição:</label>
                        <textarea readonly class='form-control h-auto text-left' style='resize: none' rows='3'><?= $finance['descricaoFinanca'] ?></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer" id='modal-footer'>
                <button type="button" class="btn btn-tertiary" data-bs-dismiss="modal">Fechar</button>
                <form method='POST' action="./include/dFinance.php">
                    <input value="<?= $finance['id'] ?>" name='finance' hidden>
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
                    <span class="w-100 text-tertiary">Deletar registro</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body space-1 mt-2 text-center text-danger" id='modal-body'>
                <h4>Erro ao buscar registro</h4>
            </div>

            <div class="modal-footer" id='modal-footer'>
                <button type="button" class="btn btn-tertiary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    <?php
    }
} else {
    $quantity = count($id);
    $finances = implode(',', $id);
    ?>
    <div class="modal-content" id='modal-content'>

        <div class="modal-header" id='modal-header'>
            <h5 class="card-title placeholder-glow col-6 my-0" id="modal-title">
                <span class="w-100 text-tertiary">Deletar registros</span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body space-1 mt-2 text-center" id='modal-body'>
            <h4>Deseja deletar <?= $quantity ?> registros?</h4>
        </div>

        <div class="modal-footer" id='modal-footer'>
            <button type="button" class="btn btn-tertiary" data-bs-dismiss="modal">Fechar</button>

            <form method='POST' action="./include/dFinance.php">
                <input value="<?= $finances ?>" name='finance' hidden>
                <button class="btn btn-danger" data-bs-dismiss="modal">Confirmar</button>
            </form>
        </div>
    </div>
<?php
}
?>

<style>
    #divTableModalFinance::target-text,
    #divTableModalFinance {
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