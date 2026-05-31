<?php
include_once(__DIR__ . "/handler.php");
include_once(__DIR__ . "/../backend/example.php");

class Router {
    public static $routes = [
        "/api/v1/persons"                => ['GET', Example::class, 'getPersons'],
        "/api/v1/person/{id}"            => ['GET', Example::class, 'getPerson'],
        "/api/v1/person/{id}/post/{id}"  => ['GET', Example::class, 'getPersonPosts'],
        "/api/v1/person/{id}/update"     => ['POST', Example::class, 'updateUserName']
    ];
}
?>