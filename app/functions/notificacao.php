<?php

function gerarNotificacao($con, $empresa, $aplicacao, $identificador, $parametros) {
    $sql = "select ug.idusuario,
                   nu.idusuario
            from cadnotificacao cn
            inner join notificacaousuario nu
            on cn.idcadnotificacao = nu.idcadnotificacao
            left join usuariogrupo ug
            on ug.idgrupo = nu.idgrupo
            where cn.ativo = 's'
            and cn.identificador = '$identificador'
            and cn.idempresa = $empresa";
    $query = mysqlI_query($con, $sql);
    while ($row = mysqlI_fetch_array($query)) {
        if ($row[0] > 0) {
            $iduser = $row[0];
        } else {
            $iduser = $row[1];
        }
        $insert = "insert into notificacao values(null,
                                                  $iduser,
                                                  $aplicacao,
                                                  now(),
                                                  '" . $parametros['titulo'] . "',
                                                  '" . $parametros['text'] . "',
                                                  '" . $parametros['icone'] . "',
                                                  '" . $parametros['cor'] . "',
                                                  null,
                                                  'n')";
        mysqlI_query($con, $insert);
    }
}
