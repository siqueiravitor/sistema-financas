<thead>
    <tr>
        <th>Tipo</th>
        <th>Descrição</th>
        <th class='text-muted'><i data-feather='edit'></i></th>
        <th class='text-muted'><i data-feather='trash-2'></i></th>
    </tr>
</thead>
<tbody>
    <?php
    require_once('../../../required.php');
    include_once '../../config/conn.php';
    include_once '../../config/config.php';
    include_once './functions.php';
    $categories = categories();
    foreach ($categories as $category) {
    ?>
        <tr>
            <td><?= $category['type'] == 'in' ? 'Receita' : 'Despesa' ?></td>
            <td><?= $category['description'] ?></td>
            <td>
                <?php if ($category['id_user']) { ?>
                <a onclick="loadData(<?= $category['id'] ?>, './include/cAjaxEditCategory.php')" href='#' 
                class='d-block' aria-controls='ocNewRecord' data-bs-toggle='offcanvas' data-bs-target='#ocTemplate'>
                <i data-feather='edit'></i></a>
                <?php } ?>
            </td>
            </td>
            <td>
                <?php if ($category['id_user']) { ?>
                <a onclick="deleteModal(<?= $category['id'] ?>, './include/cAjaxDeleteCategory.php')" href='#' data-bs-toggle='modal' 
                    data-bs-target='#modalTemplate' class='d-block'>
                    <i class='text-danger' data-feather='trash-2'></i></a>
                <?php } ?>
            </td>
        </tr>
    <?php
    }
    ?>
</tbody>

<!-- FeatherIcons -->
<script src="<?= ICON ?>/feather.js"></script>