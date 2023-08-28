<thead>
    <tr>
        <th>Nome</th>
        <th>Descrição</th>
        <th>Guardado</th>
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
    include_once '../../functions/func.php';
    include_once './functions.php';
    $savings = savings();
    foreach ($savings as $save) {
    ?>
        <tr>
            <td><?= $save['name'] ?></td>
            <td><?= $save['description'] ?></td>
            <td><?= floatToMoney($save['reserved']) ?></td>
            <td>
                <a onclick="loadData(<?= $save['id'] ?>, './include/cAjaxInfoSavings.php')"
                class='text-info d-block w-100 bg-transparent' aria-controls='ocNewRecord' data-bs-toggle='offcanvas' data-bs-target='#ocTemplate'>
                    <i data-feather='eye'></i></a>
                </td>
            </td>
            <td>
                <a onclick="loadData(<?= $save['id'] ?>, './include/cAjaxEditSavings.php')"
                class='d-block' aria-controls='ocNewRecord' data-bs-toggle='offcanvas' data-bs-target='#ocTemplate'>
                    <i data-feather='edit'></i></a>
                </td>
            </td>
            <td>
                <a onclick="deleteModal(<?= $save['id'] ?>, './include/cAjaxDeleteSavings.php')" data-bs-toggle='modal' 
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
