<thead>
    <tr>
        <th>Descrição</th>
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
    $typePayments = typePayment();
    foreach ($typePayments as $typePayment) {
    ?>
        <tr>
            <td><?= $typePayment['description'] ?></td>
            <td>
                <?php if ($typePayment['id_user']) { ?>
                    <a onclick="loadData(<?= $typePayment['id'] ?>, './include/cAjaxEditTypePayment.php')"
                                class='d-block' aria-controls='ocNewRecord' data-bs-toggle='offcanvas' data-bs-target='#ocTemplate'>
                        <i data-feather='edit'></i></a>
                <?php } ?>
            </td>
            <td>
                <?php if ($typePayment['id_user']) { ?>
                <a onclick="deleteModal(<?= $typePayment['id'] ?>, './include/cAjaxDeleteTypePayment.php')" data-bs-toggle='modal' 
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