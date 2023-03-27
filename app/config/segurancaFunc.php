<?php

function verificaPermissaoTela($con, $modulo, $tela, $user) {
    $sql_seguranca = "select te.idtela		
                  from tela te
                  inner join permissaotela pt 
                    on te.idtela = pt.idtela
                  inner join permissaomodulo pm
                    on pm.idpermissaomodulo = pt.idpermissaomodulo
                  inner join modulo mo
                    on mo.idmodulo = pm.idmodulo
                  left join usuariogrupo ug
                    on ug.idgrupo = pm.idgrupo
                  where 
                       (pm.idusuario = $user or (ug.idusuario = $user ))
                    and mo.url = '$modulo'
                    and te.url = '$tela'
                    and mo.ativo = 's'";

    $mysql_seguranca = mysqli_query($con, $sql_seguranca);

    if (mysqli_num_rows($mysql_seguranca) > 0) {
        return true;
    } else {
        return false;
    }
}
