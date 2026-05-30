<?php
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    exit;
}

include_once("handler.php");

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

echo Handler::getData($path);
?>