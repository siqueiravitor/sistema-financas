<?php

function mask($str, $mask){ // mask($cpf,'###.###.###-##');
    $str = str_replace(" ","",$str);
    for($i=0;$i<strlen($str);$i++){
        $mask[strpos($mask,"#")] = $str[$i];
    }
    return $mask;
}

function moneyToFloat($str){
    $simbolRemove = explode('R$ ', $str);
    if(!isset($simbolRemove[1])){
        $simbolRemove = str_replace('R$', '', $str);
        $simbolRemove = substr($simbolRemove, 2); // Remove ghost space
    } else {
        $simbolRemove = $simbolRemove[1];
    }
    
    $float = str_replace('.', '', $simbolRemove);
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

function shortenText($text) {
    $ptext = substr($text, 0, 25); //Keep the first 25 chars
    $words = explode(" ", $ptext); // Separate words (10 caracteres)
    $words = array_slice($words, 0, count($words) - 1); //Separate from the first one until the last - 1    
    $shortText = implode(" ", $words); //junta as palavras
    return $shortText . "..."; //Returns Text + ...
}

function montaAlert($status, $text) {
    switch ($status) {
        Case 0://Sucesso
            $icon = "fa fa-check";
            $class = "success";
            break;
        Case 1://Erro
            $icon = "fa fa-exclamation";
            $class = "danger";
            break;
        Case 2://Cuidado
            $icon = "fa fa-warning";
            $class = "warning";
            break;
        Case 3://Info
            $icon = "fa fa-info-circle ";
            $class = "info";
            break;
    }
    return '<div class="alert alert-' . $class . ' alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <i class="' . $icon . '"></i> ' . $text . '
            </div>
            <script type="text/javascript">
                window.setTimeout(function () {
                    $(".alert").fadeTo(1000, 0).slideUp(1000, function () {
                        $(this).remove();
                    });
                }, 9000);
            </script>';
}

function getEnum($var) {
    $var = str_replace("(", "", $var);
    $var = str_replace(")", "", $var);
    $var = str_replace("'", "", $var);
    $enum = explode(",", $var);
    return $enum;
}


function moedaBanco($vlr) {
    return number_format(str_replace(",", ".", str_replace(".", "", $vlr)), 2, '.', '');
}

function logRapido($nomeDir, $user, $text) {
    $log = fopen($nomeDir, "a+");
    fwrite($log, "\nIniciado em: " . date("d/m/Y") . " as " . date("H:i:s"));
    fwrite($log, "\nIniciado Por:" . $user);
    fwrite($log, $text);
    fwrite($log, "\nFinalizado em: " . date("d/m/Y") . " as " . date("H:i:s"));
    fclose($log);
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
