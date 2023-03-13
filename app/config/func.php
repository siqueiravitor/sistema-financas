<?php
/* Mascara */
function mask($str, $mask){ // mask($cpf,'###.###.###-##');
    $str = str_replace(" ","",$str);
    for($i=0;$i<strlen($str);$i++){
        $mask[strpos($mask,"#")] = $str[$i];
    }
    return $mask;
}

function moneyToFloat($str){
    $simbolRemove = str_replace('R$', '', $str);
    $spaceRemove = substr($simbolRemove, 2); // Remove ghost space
    $float = str_replace('.', '', $spaceRemove);
    $floatValue = str_replace(',', '.', $float);
    
    return $floatValue;
}
function floatToMoney($amount, $currency = 'R$') {
    $formatted = number_format($amount, 2, ',', '.');
    return $currency . ' ' . $formatted;
}


function dateConvert($dt, $separator, $separate, $reverse = false) {
    $data = explode($separator, $dt); //[2019][06][29]
    $reverse ? $data = array_reverse($data) : ''; // [29][06][2019]
    $dt = implode($separate, $data);
    return $dt; // 29/06/2019
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
            $icone = "fa fa-check";
            $classe = "success";
            break;
        Case 1://Erro
            $icone = "fa fa-exclamation";
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

