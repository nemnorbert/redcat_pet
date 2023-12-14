<?php
function loadJSON($filePath) {
    try {
        $json = file_get_contents($filePath);
        if ($json === false) {
            throw new Exception('Error reading JSON file: ' . error_get_last()['message']);
        }
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Error decoding JSON: ' . json_last_error_msg());
        }
        return $data;
    } catch (Exception $e) {
        errorHandler("json_error", $e->getMessage());
        return null;
    }
}

function errorHandler($type, $text) {        
    var_dump($type);
    exit();
}

function buildName($pet) {
    $name = $pet["name"];
    $name .= '<i class="bi bi-gender-'.$pet["bio"]["gender"].'"></i>';
    return $name;
}

function navBar($petDB) {
    $result = '<nav>';
    if (isset($petDB["owner"]["phone"]) || isset($petDB["owner"]["email"]) || isset($petDB["owner"]["redcat_id"])) {
        $result .= '<div class="info">';
        $result .= isset($petDB["owner"]["redcat_id"]) ? '<div class="card"><i class="bi bi-person-circle"></i></div>' : '';
        $result .= isset($petDB["owner"]["phone"]) ? '<div class="phone"><i class="bi bi-telephone-fill"></i></div>' : '';
        $result .= isset($petDB["owner"]["email"]) ? '<div class="email"><i class="bi bi-envelope-fill"></i></div>' : '';
        $result .= '</div>';
    }
    $result .= isset($petDB["bio"]["lost"]) ? '<div id="notify" class="lost"></div>' : '';
    $result .= '</nav>';
    return $result;
}

function bioWidgets($petDB, $icons, $langJSON) {
    $pet = $petDB["bio"];

    function icon($icon) {
        return '<i class="bi bi-'.$icon.'"></i> ';
    }
    function widgets($title) {
        if (!isset($title)) {return null;}
        return '<div class="btn">'.$title.'</div>';
    }

    $bioData = [];
    if (isset($pet["species"])) {
        $icon = 'egg';
        $bioData["species"] = icon($icon).$pet["species"];
    }
    if (isset($pet["gender2"])) {
        $icon = 'gender-'.$pet["gender"];
        $bioData["gender"] = icon($icon).$pet["gender2"];
    }
    if (isset($pet["steril"]) & $pet["steril"]) {
        $icon = 'check2-circle';
        $bioData["steril"] = icon($icon).'Ivartalan';
    }
    if (isset($pet["age"])) {
        $icon = 'clock-history';
        $bioData["age"] = icon($icon).$pet["age"];
    }
    if (isset($pet["birthday"])) {
        $icon = 'cake2';
        $bioData["birthday"] = icon($icon).$pet["birthday"];
    }
    if (isset($pet["chip"])) {
        $icon = 'upc-scan';
        $bioData["chip"] = icon($icon).'Chip: '.$pet["chip"];
    }

/*
    echo "<pre>";
    print_r($bioData);
    echo "<pre>";
    //return null;
*/

    // FINAL BUILD
    $html = '';
    foreach ($bioData as $key => $value) {
        $html .= widgets($value);
    }
    return $html;
}
?>