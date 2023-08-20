<thead>
    <tr>
        <th>Descrição</th>
        <th>Valor</th>
        <th class='text-muted'><i data-feather='edit'></i></th>
        <th class='text-muted'><i data-feather='trash-2'></i></th>
    </tr>
</thead>
<tbody>
    <?php
    require('../../../../required.php');
    include_once '../../../config/connMysql.php';
    include_once '../../../config/config.php';
    include_once '../../../functions/func.php';
    include_once './functions.php';
    $list = $_GET['list'];
    $items = items($list);
    foreach ($items as $item) {
    ?>
        <tr>
            <td><?= $item[1] ?></td>
            <td><?= floatToMoney($item[2]) ?></td>
            <td>
                <a onclick="listData(<?= $item[0] ?>)" href='#' class='d-block' aria-controls='ocNewRecord' data-bs-toggle='offcanvas' data-bs-target='#ocTemplate'>
                    <i data-feather='edit'></i></a>
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