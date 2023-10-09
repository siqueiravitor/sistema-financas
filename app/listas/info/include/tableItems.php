<thead>
    <tr>
        <th>Descrição</th>
        <th>Valor</th>
        <th class='text-muted'><i data-feather='toggle-right'></i></th>
        <th class='text-muted'><i data-feather='edit'></i></th>
        <th class='text-muted'><i data-feather='trash-2'></i></th>
    </tr>
</thead>
<tbody>
    <?php
    require_once('../../../../required.php');
    include_once '../../../config/conn.php';
    include_once '../../../config/config.php';
    include_once '../../../functions/func.php';
    include_once './functions.php';
    $list = $_GET['list'];
    $items = items($list);
    foreach ($items as $item) {
        $status = $item[4] == 'a' ? 'Ativo' : 'Inativo';
        $btnColor = $item[4] == 'a' ? 'btn-outline-success' : 'btn-outline-danger';

        $ativo = "<span class='badge-btn $btnColor space-1' href='#' 
                        onclick='changeItemStatus({$item[0]})' class='d-block'>$status</span>";
    ?>
        <tr>
            <td><?= $item[1] ?></td>
            <td><?= floatToMoney($item[2]) ?></td>
            <td id='<?= 'item_'.$item[0] ?>'><?= $ativo ?></td>
            <td>
                <a onclick="loadData(<?= $list ?>, './include/cAjaxEditItem.php', <?= $item[0] ?>)" href='#' 
                class='d-block' aria-controls='ocNewRecord' data-bs-toggle='offcanvas' data-bs-target='#ocTemplate'>
                    <i data-feather='edit'></i></a>
                </td>
            </td>
            <td>
                <a onclick="deleteModal(<?= $list ?>, './include/cAjaxDeleteItem.php', <?= $item[0] ?>)" href='#' data-bs-toggle='modal' 
                    data-bs-target='#modalTemplate' class='d-block'>
                    <i class='text-danger' data-feather='trash-2'></i></a>
            </td>
        </tr>
    <?php
    }
    ?>
</tbody>

<!-- FeatherIcons -->
<script src="<?= ICON ?>/feather.js"></script>