<thead>
<tr>
    <th>Tipo</th>
    <th>Descrição</th>
    <th></th>
    <th></th>
</tr>
</thead>
<tbody>
    <?php
    require('../../../required.php');
    include_once '../../config/connMysql.php';
    include_once '../../config/config.php';
    include_once './functions.php';
    $categories = categories();
    foreach ($categories as $category) {
    ?>
        <tr>
            <td><?= $category[1] == 'in' ? 'Receita' : 'Despesa' ?></td>
            <td><?= $category[2] ?></td>
            <td>
                <a onclick="loadCategoryData(<?= $category[0] ?>)" href='#' class='d-block'
                        aria-controls='ocNewRecord' data-bs-toggle='offcanvas' data-bs-target='#ocTemplate' >
                    <i data-feather='edit'></i></a>
            </td>
            <td>
                <!-- <a href='#' class='d-block' onclick="deleteCategory(<?= $category[0] ?>)"> -->
                <a href='./include/dCategory.php?id=<?= $category[0] ?>' class='d-block'>
                    <i class='text-danger' data-feather='trash-2'></i></a>
            </td>
        </tr>
    <?php
    }
    ?>
</tbody>

<!-- FeatherIcons -->
<script src="<?= ICON ?>/feather.js"></script>