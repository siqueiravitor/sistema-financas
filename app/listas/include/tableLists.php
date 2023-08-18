<thead>
    <tr>
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
            <td><?= $list[1] ?></td>
            <td><?= $list[2] ?></td>
            <td></td>
            <td>
                <a onclick="listData(<?= $list[0] ?>)" href='#' class='d-block' aria-controls='ocNewRecord' data-bs-toggle='offcanvas' data-bs-target='#ocTemplate'>
                    <i data-feather='edit'></i></a>
            </td>
            <td>
                <a href='./include/list.php?id=<?= $list[0] ?>' class='d-block'>
                    <i class='text-danger' data-feather='trash-2'></i></a>
            </td>
        </tr>
    <?php
    }
    ?>
</tbody>

<!-- FeatherIcons -->
<script src="<?= ICON ?>/feather.js"></script>