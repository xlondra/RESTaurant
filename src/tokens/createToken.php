<?php
include_once(__DIR__ . "/token.php");

if (Token::setToken()) echo "Token set!";
else "Something went wrong!";
?>