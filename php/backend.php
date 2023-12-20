<?php
date_default_timezone_set('Europe/Budapest');
set_include_path( $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR );
$siteJSON = loadJSON('json/site.json');
$siteINFO = new stdClass();
$siteINFO -> langUser = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : "";
$siteINFO -> langSite = file_exists('json/lang/'.$siteINFO -> langUser.'.json') ? $siteINFO -> langUser : "en";
$siteINFO -> site = $siteJSON["site"];

// Test Server?
if ($_SERVER['HTTP_HOST'] === 'localhost') {
    $preURL = '/'.$siteINFO -> site;
    $siteINFO -> test = true;
    $siteINFO -> mainPath = $siteJSON["mainPath"]["test"];
    $siteINFO -> redcatPath = $siteJSON["redcatPath"]["test"];
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    $preURL = '';
    $siteINFO -> test = false;
    $siteINFO -> mainPath = $siteJSON["mainPath"]["web"];
    $siteINFO -> redcatPath = $siteJSON["redcatPath"]["web"];
}

$requestURI = str_replace($preURL, '', $_SERVER['REQUEST_URI']);
$siteINFO -> requestURI = $requestURI;
$parts = explode("?", $requestURI);
$parts = explode("/", strtolower($parts[0]));
$siteINFO -> page = $parts[1];

// Connect API
try {
    $API = $siteINFO -> test ? 'http://localhost/redcat_api/' : 'https://api.red-cat.hu/';
    $API = $API . 'redcatPet?url='.$siteINFO->page.'&lang='.$siteINFO->langSite;
    $API = loadJSON($API);
    if ($API === null) {errorHandler("error_api", "Error with API");}
    if (!isset($API["id"])) {errorHandler("error_404", "Page not found");}
} catch (\Throwable $th) {
    errorHandler("error_api", $th->getMessage());
}
?>