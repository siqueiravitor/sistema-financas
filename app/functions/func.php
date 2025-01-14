<?php

function mask($str, $mask){ // mask($cpf,'###.###.###-##');
    $str = str_replace(" ","",$str);
    for($i=0;$i<strlen($str);$i++){
        $mask[strpos($mask,"#")] = $str[$i];
    }
    return $mask;
}

function moneyToFloat($str){
    $value = floatval($str);
    $floatValue = substr_replace($value, '.', -2, 0);
    
    return $floatValue;
}

function moneyToFloatAlt($str){
    $output = preg_replace( '/[^0-9,.]/', '', $str );
    $value = str_replace(',','.', str_replace('.','', $output));
    
    return $value;
}
function floatToMoney($amount, $currency = 'R$ ') {
    $formatted = number_format($amount, 2, ',', '.');
    return $currency . $formatted;
}
function toFloat($amount) {
    $formatted = number_format($amount, 2, '.', '');
    return $formatted;
}

function dateConvert($dt, $separator, $separate, $reverse = true) {
    $data = explode($separator, $dt); //[2019][06][29]
    $reverse ? $data = array_reverse($data) : ''; // [29][06][2019]
    $dt = implode($separate, $data);
    return $dt; // 29/06/2019
}
function dateFormat($date){
    $dateArray = explode('-', $date);      // [2019][06][29]
    $reverse = array_reverse($dateArray); // [29][06][2019]
    $dateFormat = implode('/', $reverse);     // 29/06/2019
    return $dateFormat;
}
function dateText($getMonth = null, $getYear = null){
    $months = getMonths();
    if($getMonth && $getYear){
        $dateMonth = date('n', strtotime(date("Y-$getMonth-d")))-1;
        $year = date('Y', strtotime(date("$getYear-m-d")));
        $dateTxt = $months[$dateMonth] . ' de ' . $year;
    } elseif($getMonth){
        $dateMonth = date('n', strtotime(date("Y-$getMonth-d")))-1;
        $dateTxt = $months[$dateMonth];
    } elseif($getYear){
        $year = date('Y', strtotime(date("$getYear-m-d")));
        $dateTxt = $year;
    } else {
        $dateMonth = date('n', strtotime(date('Y-m-d')));
        $year = date('Y', strtotime(date('Y-m-d')));
        $dateTxt = "Tudo";
    }
    return $dateTxt;
}
function getMonths(){
    $months = [
        'Janeiro',
        'Fevereiro',
        'Março',
        'Abril',
        'Maio',
        'Junho',
        'Julho',
        'Agosto',
        'Setembro',
        'Outubro',
        'Novembro',
        'Dezembro'
    ];
    
    return $months;
}
function getDateType($date){
    $day = date('d', strtotime($date)); //day 01
    $monthNum = date('m', strtotime($date)); //month 01
    $monthTxt = date('F', strtotime($date)); //month January
    $yearShort = date('y', strtotime($date)); //year 01
    $yearLong = date('Y', strtotime($date)); //year 2001

    $dateType = [
        'day'=> $day,
        'monthNum'=> $monthNum,
        'monthTxt'=> $monthTxt,
        'yearShort'=> $yearShort,
        'yearLong'=> $yearLong
    ];

    return $dateType;
}
function getMonthYear($month = null, $year = null){
    $array = array();
    if($month){
        $month = date('Y-m-d', strtotime(date("Y-$month-d")));
        $array = array('month' => $month) + $array;
    }
    if($year){
        $year = date('Y-m-d', strtotime(date("$year-m-d")));
        $array = array('year' => $year) + $array;
    }
    
    return $array;
}

function timestampToDate($timestamp) {
    $date_time = explode(' ', $timestamp); //[2019][06][29]
    $date = explode('-', $date_time[0]); //[2019][06][29]
    $time = $date_time[1]; //09:54:23
    $data_reverse = array_reverse($date); // [29][06][2019]
    $dt = implode('/', $data_reverse);
    return ['date' => $dt, 'time' => $time]; // 29/06/2019
}

function dateChange($date, $period, $recurrence){
    $strtotime = strtotime($date);
    $changeTo = "+" . $period . ' ' . $recurrence;

    $newDate = date('Y-m-d', strtotime("$changeTo", $strtotime));
    return $newDate;
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

