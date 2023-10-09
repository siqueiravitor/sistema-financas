<thead>
    <tr>
        <th>Categoria</th>
        <th>Nome</th>
        <th>Tipo</th>
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
    $lists = lists();
    foreach ($lists as $list) {
    ?>
        <tr>
            <td><?= $list['category'] ?></td>
            <td><?= $list['name'] ?></td>
            <td><?= $list['type'] ?></td>
            <td><?= $list['description'] ?></td>
            <td>
                <form method="GET" action="./info">
                    <input hidden value='<?= $list['list_id'] ?>' name="list">
                    <button class='text-info d-block w-100 bg-transparent'><i data-feather='eye'></i></button>
                </form>
            </td>
            <td>
                <a onclick="loadData(<?= $list['id'] ?>, './include/cAjaxEditList.php')" href='#' 
                class='d-block' aria-controls='ocNewRecord' data-bs-toggle='offcanvas' data-bs-target='#ocTemplate'>
                    <i data-feather='edit'></i></a>
                </td>
            </td>
            <td>
                <a onclick="deleteModal(<?= $list['id'] ?>, './include/cAjaxDeleteList.php')" href='#' data-bs-toggle='modal' 
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