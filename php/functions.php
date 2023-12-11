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

function generateAge($birth, $lang) {
    $dateNow = new DateTime(date("Y-m-d"));
    $dateBirth = new DateTime($birth);
    $lifeTime = $dateBirth->diff($dateNow);
    if ($lifeTime->y < 2) {
        $months = $lifeTime->y * 12 + $lifeTime->m;
        return $months . " " . $lang["month"];
    } else {
        return $lifeTime->y . " " . $lang["year"];
    }
}

function lostAlert($lost) {
    $now = new DateTime(date("Y-m-d"));
    $lost = new DateTime($lost);
    $lostTime = $lost->diff($now);

    if ($lostTime->d < 3) {
        return "Eltünt " . $lostTime->h . " órája";
    } else {
        return "Eltünt " . $lostTime->d . " napja";
    }
}

function petInfo($petDB, $icons, $langJSON) {
    $html = '<div class="bubble">';
    $html .= generateAge($petDB["bio"]["birth"], $langJSON["age"]);
    $html .= "</div>";
    $html .= '<div class="bubble">';
    $html .= $petDB["bio"]["sex"];
    $html .= "</div>";
    return $html;
}
?>