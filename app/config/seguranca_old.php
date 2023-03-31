<?php

$diretorioBase = $_SERVER['SCRIPT_FILENAME'];
$caminhoAtual = str_replace(BASES . "/app/", "", $diretorioBase);

$arrayCaminho = explode("/", $caminhoAtual);
$pastaAtual = $arrayCaminho[0];
$subPastaAtual = str_replace(".php", "", $arrayCaminho[1]);

$sql_seguranca = "select pm.idpermissaomodulo, mo.idmodulo 
                    from permissaomodulo pm
                 inner join modulo mo
                    on mo.idmodulo = pm.idmodulo
                 left join usuariogrupo ug
                    on ug.idgrupo = pm.idgrupo
                 where mo.ativo = 's'
                  and (pm.idusuario = " . $_SESSION['iduser'] . " 
                    or ug.idusuario = " . $_SESSION['iduser'] . ")
                   and mo.url = '/$pastaAtual'";

$mysql_seguranca = mysqli_query($con, $sql_seguranca);
$idpermissaomodulo = mysqli_fetch_array($mysql_seguranca);

/* Possui permisao a pasta */
if ($idpermissaomodulo[0] > 0) {
    /* Possui permisao a pasta */
    if ($subPastaAtual <> '') {
        $sqlTelaExiste = "select idtela from tela where idmodulo = $idpermissaomodulo[1]  and url = '/$subPastaAtual'";
        $query_TelaExiste = mysqli_query($con, $sqlTelaExiste);

        /* Verifica se a Tela Existe  no banco */
        if (mysqli_num_rows($query_TelaExiste)) {
            $telaExiste = mysqli_fetch_array($query_TelaExiste);
            $sqlPermissaoTela = "select idpermissaotela from permissaotela where idpermissaomodulo = $idpermissaomodulo[0] and idtela = $telaExiste[0]";
            $queryPermissaoTela = mysqli_query($con, $sqlPermissaoTela);

            /* Verifica o usuario tem permissao a tela */
            if (!mysqli_num_rows($queryPermissaoTela)) {
                header("location: " . BASED . "/semAcesso ");
            }
        }
    }
} else {
    header("location: " . BASED . "/semAcesso ");
}