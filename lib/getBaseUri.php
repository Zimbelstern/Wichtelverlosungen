<?php
function getBaseUri() {
    $url=strtok($_SERVER["REQUEST_URI"],'?');
    return $url;
}

function getExtendedBaseUri() {
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    return $url;
}

?>