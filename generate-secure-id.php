<?php
function generate_secure_id($length = 6) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charLen = strlen($characters);
    $id = '';
    
    for ($i = 0; $i < $length; $i++) {
        $byte = random_int(0, $charLen - 1);
        $id .= $characters[$byte];
    }

    return $id;
}