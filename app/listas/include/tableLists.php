<thead>
    <tr>
        <th>Categoria</th>
        <th>Título</th>
        <th>Descrição</th>
        <th class='text-muted'><i data-feather='eye'></i></th>
        <th class='text-muted'><i data-feather='edit'></i></th>
        <th class='text-muted'><i data-feather='trash-2'></i></th>
    </tr>
</thead>
<tbody>
    <?php
    require('../../../required.php');
    include_once '../../config/connMysql.php';
    include_once '../../config/config.php';
    include_once './functions.php';
    $typeLists = lists();
    foreach ($typeLists as $list) {
    ?>
        <tr>
            <td><?= $list[4] ?></td>
            <td><?= $list[1] ?></td>
            <td><?= $list[2] ?></td>
            <td>
                <form method="GET" action="./info">
                    <input hidden value='<?= $list[0] ?>' name="item">
                    <button class='text-info d-block w-100 bg-transparent'><i data-feather='eye'></i></button>
                </form>
            </td>
            <td>
                <a onclick="loadData(<?= $list[0] ?>, './include/cAjaxEditList.php')" href='#' 
                class='d-block' aria-controls='ocNewRecord' data-bs-toggle='offcanvas' data-bs-target='#ocTemplate'>
                    <i data-feather='edit'></i></a>
                </td>
            </td>
            <td>
                <a onclick="deleteModal(<?= $list[0] ?>, './include/cAjaxDeleteList.php')" href='#' data-bs-toggle='modal' 
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