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

function generateAge($birth) {
    $dateNow = new DateTime();
    $dateBirth = new DateTime($birth);
    $lifeTime = $dateBirth->diff($dateNow);
    if ($lifeTime->y == 0 && $lifeTime->m > 0) {
        return [$lifeTime->m, "m"];
    } else {
        return [$lifeTime->y, "y"];
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

function bioWidgets($petDB, $icons, $langJSON) {
    $pet = $petDB["bio"];

    function widgets($title, $value, $desc) {
        if (!isset($title) & !isset($value) & !isset($desc)) {return null;}
        return '<div class="widget">
                <b>'.$title.'</b>
                <div class="value">'.$value.'</div>
                <div>'.$desc.'</div>
            </div>';
    }


    /*
    $bioData = [];
    if (isset($pet["gender"])) {
        $bioData["gender"] = [
            "title" => "nem",
            "value" => '<i class="bi bi-gender-'.$pet["gender"].'"></i>',
            "desc" => "nőstény",
        ];
    }
    if (isset($pet["steril"]) & $pet["steril"]) {
        $bioData["steril"] = [
            "title" => "ivartalan",
            "value" => '<i class="bi bi-check-circle-fill"></i>',
            "desc" => "igen",
        ];
    }
    if (isset($pet["birth"])) {
        $age = generateAge($pet["birth"]);
        $bioData["age"] = $age[0];
    }
    */

    $bioData = [];
    if (isset($pet["birthday"])) {
        $age = generateAge($pet["birthday"]);
        $bioData["age"] = $age[0];
    }



    echo "<pre>";
    print_r($bioData);
    echo "<pre>";
    return null;

    // FINAL BUILD
    $html = '';
    foreach ($array as $item) {
        $html .= widgets("Kor", "9", "hónapos");
    }
    return $html;
}
?>