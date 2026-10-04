<?php

// Cleaning string from html sprcial caracters
function clean($input) {
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

// Date formating
const NUM_TO_MONTH = [
    '1' => 'Январь', '2' => 'Февраль', '3' => 'Март', '4' => 'Апрель',
    '5' => 'Май', '6' => 'Июнь', '7' => 'Июль', '8' => 'Август',
    '9' => 'Сентябрь', '10' => 'Октябрь', '11' => 'Ноябрь', '12' => 'Декабрь'
];
function dateToRussianStr($datestr) {
    $date = getdate(strtotime($datestr));
    return NUM_TO_MONTH[$date['mon']].' '.$date['mday'].', '.$date['year'];
}