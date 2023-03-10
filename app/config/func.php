<?php
/* Mascara */
function Mask($str, $mask){
    $str = str_replace(" ","",$str);
    for($i=0;$i<strlen($str);$i++){
        $mask[strpos($mask,"#")] = $str[$i];
    }
    return $mask;
}


//function mask($val, $mask) {
//    $maskared = '';
//    $k = 0;
//    for ($i = 0; $i <= strlen($mask) - 1; $i++) {
//        if ($mask[$i] == '#') {
//            if (isset($val[$k]))
//                $maskared .= $val[$k++];
//        } else {
//            if (isset($mask[$i]))
//                $maskared .= $mask[$i];
//        }
//    }
//    return $maskared;
//}

/* Exemplo 
  echo mask($cnpj,'##.###.###/####-##');
  echo mask($cpf,'###.###.###-##');
  echo mask($cep,'#####-###');
  echo mask($data,'##/##/####');
 */

function databanco($dt) {
    $data = explode("/", $dt); //[29][06][2019]
    $data = array_reverse($data); // [2019][06][29]
    $dt = implode("-", $data);
    return $dt; //2019-06-29
}

function dataBuscaBanco($dt) {
    $data = explode("-", $dt); //[2019][06][29]
    $data = array_reverse($data); // [29][06][2019]
    $dt = implode("/", $data);
    return $dt; // 29/06/2019
}

function dataMesAno($dt) {
    //2013-06-29
    $data = explode("-", $dt);  //[2019][06][29]
    $data = array_reverse($data); // [29][06][2019]
    list( $dia, $mes, $ano) = $data; //[29][06][2019]
    $dt = $mes . '/' . $ano;
    return $dt; // 06/2019
}

function ptexto($texto) {
    $ptexto = substr($texto, 0, 25); //guarda os primeiros 25 caracteres
    $palavras = explode(" ", $ptexto); // separa as palavras (10 caracteres)
    $palavras = array_slice($palavras, 0, count($palavras) - 1); //separa da primeira até o total - 1    
    $ptexto = implode(" ", $palavras); //junta as palavras
    return $ptexto . ""; //retorna o texto com (...)
}

function logRapido($nomeDir, $user, $text) {
    $log = fopen($nomeDir, "a+");
    fwrite($log, "\nIniciado em: " . date("d/m/Y") . " as " . date("H:i:s"));
    fwrite($log, "\nIniciado Por:" . $user);
    fwrite($log, $text);
    fwrite($log, "\nFinalizado em: " . date("d/m/Y") . " as " . date("H:i:s"));
    fclose($log);
}

function getEnum($var) {
    $var = str_replace("(", "", $var);
    $var = str_replace(")", "", $var);
    $var = str_replace("'", "", $var);
    $enum = explode(",", $var);
    return $enum;
}

function montaAlert($status, $texto) {
    switch ($status) {
        Case 0://Sucesso
            $icone = "fa fa-check-circle";
            $classe = "success";
            break;
        Case 1://Erro
            $icone = "fa fa-times-circle";
            $classe = "danger";
            break;
        Case 2://Cuidado
            $icone = "fa fa-warning";
            $classe = "warning";
            break;
        Case 3://Info
            $icone = "fa fa-info-circle ";
            $classe = "info";
            break;
    }
    return '<div class="alert alert-' . $classe . ' alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <i class="' . $icone . '"></i> ' . $texto . '
            </div>
            <script type="text/javascript">
                window.setTimeout(function () {
                    $(".alert").fadeTo(1000, 0).slideUp(1000, function () {
                        $(this).remove();
                    });
                }, 9000);
            </script>';
}

function moedaBanco($vlr) {
    return number_format(str_replace(",", ".", str_replace(".", "", $vlr)), 2, '.', '');
}

function gravaLogBanco($con, $tabela, $chatab, $user, $tipo) {
    $hoje = date('Y-m-d H:m:s');
    $chatab = json_encode($chatab);
    $insert = "insert into logalteracao values(null,'$tabela','$chatab',$user,'$hoje','$tipo')";
    if (mysqli_query($con, $insert)) {
        return true;
    } else {
        return false;
    }
}

function nomeSistemaOrgiem($text) {
    switch ($text) {
        case "oracleERPM":
            $retorno = "ERP Milano";
            break;
        case "oracleERPA":
            $retorno = "ERP Agile";
            break;
        default:
            $retorno = $text;
    }
    return $retorno;
}
