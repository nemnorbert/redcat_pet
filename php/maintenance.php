<?php
header("HTTP/1.1 503 Service Temporarily Unavailable");
header("Status: 503 Service Temporarily Unavailable");
header("Retry-After: 3600");
$url = "http://red-cat.hu/maintenance";
header("Location: ".$url."?site=".$site);
exit;
?>