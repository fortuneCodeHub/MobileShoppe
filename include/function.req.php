<?php 
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function shorten($string, $num) {
    if (strlen($string)>$num) {
        $sstr= str_split($string, "1");
        foreach ($sstr as $i => $value) {
            echo $value;
            $sub_num = $num - 1;
            if($i == $sub_num) {
                break;
            }
        }
        $b = $sstr[$num];
        $b= "...";
        echo $b . "<br>";
    } else {
        echo $string. "<br>";
    }
}

function old_value($name) {
    if (!empty($_POST)) {
        if (isset($_POST[$name])) {
            return $_POST[$name];
        }
    }
}