<?php
class Method {
    public static function rejectEmptyPost() : void {
        if (empty($_POST)) {
            http_response_code(400);
            die("Empty post data!");
        }
    }

    /**
     * Ensures the used method is either GET or POST<br>
     * Other methods are blocked in any case.
     * @return void
     */
    public static function enforceMethod(string $method) : void {
        if ($_SERVER['REQUEST_METHOD'] !== $method) {
            http_response_code(405);
            die("Method not allowed, use $method");
        }
    }
}
?>