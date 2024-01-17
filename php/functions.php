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

function errorHandler($code, $text) {
    $link = $_SERVER['SERVER_NAME'] === 'localhost' ? "/redcat_home/" : "https://red-cat.hu/";
    $link .= "error?id=" . $code;
    header("Location: ".$link);
    exit();
}

function profilePicture($API, $centerpath) {      
    $profile = $API["media"]["profile"] ?? false;
    $image = $API["bio"]["species"] ?? "default";
    $path = 'default';
    if ($profile && isset($API["id"])) {
        $image = $API["id"];
        $path = 'img';
    }
    $result = $centerpath . 'media/pet_'.$path.'/' . $image . '.webp';
    return '<img src="'.$result.'" alt="">';
}

function buildName($pet) {
    $name = $pet["name"];
    $name .= '<i class="bi bi-gender-'.$pet["bio"]["gender"].'"></i>';
    return $name;
}

function navBar($petDB) {
    $owner = $petDB["owner"];
    $result = '<nav>';
    if (isset($owner["phone"]) || isset($owner["email"])) {
    $result .= '<div class="title">'.$petDB["translate"]["owner"].'</div>';
        $result .= '<div class="info">';
        $result .= isset($owner["phone"]) ? '<a href="tel:'.$owner["phone"].'" class="phone"><i class="bi bi-telephone-fill"></i></a>' : '';
        $result .= isset($owner["email"]) ? '<div class="link email"><i class="bi bi-envelope-fill"></i></div>' : '';
        $result .= '<div class="link share"><i class="bi bi-share-fill"></i></div>';
        $result .= '</div>';
    }
    //$result .= isset($petDB["bio"]["lost"]) ? '<div id="notify" class="lost"></div>' : '';
    $result .= '</nav>';
    return $result;
}

function buildWidgets($API) {
    $pet = $API["bio"];
    $translate = $API["translate"];

    function icon($icon) {
        return '<i class="bi bi-'.$icon.'"></i> ';
    }
    function widgets($title) {
        if (!isset($title)) {return null;}
        return '<div class="btn">'.$title.'</div>';
    }

    $bioData = [];
    if (isset($translate["species"])) {
        $icon = 'tag-fill';
        $bioData["species"] = icon($icon).$translate["species"];
    }
    if (isset($translate["gender"])) {
        $icon = 'gender-'.$pet["gender"];
        $bioData["gender"] = icon($icon).$translate["gender"];
    }
    if (isset($pet["steril"]) & $pet["steril"]) {
        $icon = 'check2-circle';
        $bioData["steril"] = icon($icon).$translate["steril"];
    }
    if (isset($translate["age"])) {
        $icon = 'clock-history';
        $bioData["age"] = icon($icon).$translate["age"];
    }
    if (isset($pet["chip"])) {
        $icon = 'upc-scan';
        $bioData["chip"] = icon($icon).'Chip';
    }

    // FINAL BUILD
    $html = '';
    foreach ($bioData as $key => $value) {
        $html .= widgets($value);
    }
    return $html;
}

function buildScript($site, $api) {
    $shareData = array(
        'title' => $api["name"].', REDCAT iD',
        'text' => $api["translate"]["desc"],
        'url' => $api["link"],
    );
    $combinedData = "";

    $data = array('main' => $combinedData, 'api' => $api);

    $shareDataJson = json_encode($shareData, JSON_HEX_QUOT);
    $siteDataJson = json_encode($data, JSON_HEX_QUOT);

    $html = "<script>let shareData = $shareDataJson; let siteData = $siteDataJson;</script>";
    return $html;
}
?>