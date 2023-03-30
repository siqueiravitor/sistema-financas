<thead>
    <tr>
        <th></th>
        <th>Tipo</th>
        <th>Valor</th>
        <th>Categoria</th>
        <th>Descrição</th>
        <th>Pagamento</th>
        <th>Recorrente</th>
        <th>Data</th>
        <th>Gerado</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
</thead>
<tbody>
    <?php
    $userId = $_SESSION['id'];
    $finances = dataFinance($userId);
    if ($finances[0] > 0) {
        array_shift($finances);
        foreach ($finances as $finance) {
            $date = dateConvert($finance['data'], '-', '/', true);
            $dategen = dateConvert($finance['datager'], '-', '/', true);
            $value = floatToMoney($finance['valor']);
            $tipo = $finance['tipo'] == 'e' ? 'Entrada' : 'Saída ';

            $recurrence = "Não";
            $recurrentInfo = "";
            if($finance['recorrente'] == 's'){
                $recurrence = "Sim";
                $recurrentInfo = "<a onclick='infoFinance({$finance['id']})' href='#' data-bs-toggle='modal' 
                data-bs-target='#modalTemplate' class='d-block'>
                <i data-feather='eye'></i></a>";
            }
            
            $payment = $finance['pagamento'];
            if ($payment == 'p') {
                $payment = 'Pix';
            } elseif ($payment == 'd') {
                $payment = 'Dinheiro';
            } elseif ($payment == 'cd') {
                $payment = 'Crédito';
            } elseif ($payment == 'cc') {
                $payment = 'Débito';
            }
            // $payment = match($payment){
            //     'p' => "Pix",
            //     'd' => "Dinheiro",
            //     'cd' => "Crédito",
            //     'cc' => "Débito",
            //     default => ""
            // };
    
            echo "<tr>";
            echo "<td class='checkboxArea'><input type='checkbox' value='" . $finance['id'] . "' class='checkRegister' onchange='checkCheckbox()'></td>";
            echo "<td>{$tipo}</td>";
            echo "<td>{$value}</td>";
            echo "<td>{$finance['categoria']}</td>";
            echo "<td style='white-space: normal'>{$finance['descFinanca']}</td>";
            echo "<td>{$payment}</td>";
            echo "<td>{$recurrence}</td>";
            echo "<td>{$date}</td>";
            echo "<td>{$dategen}</td>";
            echo "<td>{$recurrentInfo}</td>";
            echo "<td><a onclick='loadFinanceData({$finance['id']})' href='#' aria-controls='ocNewRecord' 
                        data-bs-toggle='offcanvas' data-bs-target='#ocTemplate' class='d-block'>
                        <i data-feather='edit'></i></a>
                </td>";
            echo "<td><a href='./include/dFinance.php?id={$finance['id']}' class='d-block'>
                    <i class='text-danger' data-feather='trash-2'></i></a>
                </td>";
            echo "</tr>";
        }
    }
    ?>
</tbody>