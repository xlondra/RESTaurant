<?php
$allowedMethods = ['GET', 'POST'];

if (!in_array($_SERVER['REQUEST_METHOD'], $allowedMethods)) {
    http_response_code(405);
    exit;
}

include_once(__DIR__ . "/../src/handler.php");

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

echo Handler::getData($path);
?>