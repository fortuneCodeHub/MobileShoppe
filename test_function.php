<?php 
function test_input($data) 
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function old_value($name) {
    if (!empty($_POST)) {
        if (isset($_POST[$name])) {
            return $_POST[$name];
        }
    }
}