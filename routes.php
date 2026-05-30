<?php
include_once("handler.php");
include_once("backend/example.php");

class Router {
    public static $routes = [
        "/api/v1/persons"               => [Example::class, 'getPersons'],
        "/api/v1/person/{id}"           => [Example::class, 'getPerson'],
        "/api/v1/person/{id}/post/{id}" => [Example::class, 'getPersonPosts']
    ];
}
?>