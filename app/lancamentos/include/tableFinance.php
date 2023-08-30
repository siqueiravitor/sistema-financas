<thead>
    <tr>
        <th></th>
        <th>Tipo</th>
        <th>Valor</th>
        <th>Categoria</th>
        <th>Descrição</th>
        <th>Pagamento</th>
        <th>Recorrente</th>
        <th>D. Pagamento</th>
        <th class='text-muted'><i data-feather='dollar-sign'></i></th>
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

    $userId = $_SESSION['id'];
    $date = isset($get_date) ? $get_date : date('Y-m-d');
    $finances = dataFinance($userId, null, $date);
    if ($finances[0] > 0) {
        array_shift($finances);
        foreach ($finances as $finance) {
            $dataPagamento = $finance['dataPagamento'] ? timestampToDate($finance['dataPagamento'])['date'] : '-';
            $value = floatToMoney($finance['valor']);

            $recurrentInfo = "";
            if ($finance['recorrente'] == 'Sim') {
                $recurrentInfo = "<a onclick='infoFinance({$finance['id']})' href='#' data-bs-toggle='modal' 
                data-bs-target='#modalTemplate' class='d-block'>
                <i data-feather='eye'></i></a>";
            }
            $pagamento = '-';
            if($finance['pagamento'] == '-' && $finance['idCategory'] != 1){
                $pag = $finance['tipo'] == 'Entrada' ? 'Receber' : 'Pagar';
                $pagamento = "<span class='badge-btn btn-outline-primary space-1' href='#' 
                                onclick='loadFinancePayment({$finance['id']})' data-bs-toggle='modal' 
                                data-bs-target='#modalTemplate' class='d-block'>$pag</span>";
            }

            $checkBox = '';
            if($finance['idCategory'] != 1){
                $checkBox = "<input type='checkbox' value='" . $finance['id'] . "' class='checkRegister' onchange='checkCheckbox()'>";
            }

            // $payment = match($payment){
            //     'p' => "Pix",
            //     'd' => "Dinheiro",
            //     'cd' => "Crédito",
            //     'cc' => "Débito",
            //     default => ""
            // };
            echo "<tr>";
            echo "<td class='checkboxArea'>$checkBox</td>";
            echo "<td>{$finance['tipo']}</td>";
            echo "<td>{$value}</td>";
            echo "<td>{$finance['categoria']}</td>";
            echo "<td class='text-left' style='white-space: normal'>{$finance['descricaoFinanca']}</td>";
            echo "<td>{$finance['pagamento']}</td>";
            echo "<td>{$finance['recorrente']}</td>";
            echo "<td>{$dataPagamento}</td>";
            echo "<td width='7%'>{$pagamento}</td>";
            if($finance['idCategory'] != 1){
                echo "<td><a onclick='loadFinanceData({$finance['id']})' href='#' aria-controls='ocNewRecord' 
                            data-bs-toggle='offcanvas' data-bs-target='#ocTemplate' class='d-block'>
                            <i data-feather='edit'></i></a>
                    </td>";
                echo "<td><a onclick='deleteFinance({$finance['id']})' href='#' data-bs-toggle='modal' 
                                data-bs-target='#modalTemplate' class='d-block'>
                        <i class='text-danger' data-feather='trash-2'></i></a>
                    </td>";
            } else {
                echo "<td></td>";
                echo "<td></td>";
            }
            echo "</tr>";
        }
    }
    ?>
</tbody>

<!-- FeatherIcons -->
<script src="<?= ICON ?>/feather.js"></script>