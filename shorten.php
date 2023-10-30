<?php
function shorten($string, $a) {
    $v = "";
    if (strlen($string)>$a) {
        $sstr= str_split($string, "1");
        foreach ($sstr as $i => $value) {
            echo $value;
            $v= $a - 1;
            if($i == $v) {
                break;
            }
        }
        $b = $sstr[$a];
        $b= "...";
        echo $b;
    } else {
        echo $string;
    }
}

function shorten_sentence($string, $a) {
    $v = "";
    $str_array= explode(" ", $string);
    if (count($str_array)>$a) {
        foreach ($str_array as $i => $value) {
            echo $value;
            $v= $a - 1;
            if($i == $v) {
                break;
            }
        }
        $b = $str_array[$a];
        $b= "...";
        echo $b;
    } else {
        echo $string." ";
    }
}