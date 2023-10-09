<?php
include '../config/func.php';
include '../config/conn.php';
$acao = $_GET['parametro'];
?>
<div class="modal-body"> 
    <div class="table-responsive">
        <table class="table table-sm table-bordered table-striped table-hover dataTable" id="tabelaHistorico">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descrição</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // $sqllog = "select id,
                //                   text,
                //                   created_at
                //           from log
                //           where acao like '%{$acao}%'
                //           order by idlogmanutencao desc";
                // $querylog = mysqli_query($con, $sqllog);
                // while ($row = mysqli_fetch_array($querylog)) {
                //     $data = dataBuscaBanco($row[2]);
                //     $hora = $row[3];
                    ?>
                    <!-- <tr>
                        <td><small><?= $row[0] ?></small></td>
                        <td style="white-space: pre-wrap;"><small><?= $row[1] ?></small></td>
                        <td><small><?= $data ." às ". $hora ?></small></td>
                    </tr> -->
                    <?php
                // }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
</div>