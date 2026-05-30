<?php
include_once("routes.php");
include_once("backend/example.php");
include_once("path.php");

class Handler {
    public static function getData(string $path) : string|bool {
        $params = [];

        if (Path::contains_integer($path)) {
            $params = Path::extract_integers($path);
            $path = Path::replace_integer_with_id($path);
        }

        if (!array_key_exists($path, Router::$routes)) return false;

        $handler = Router::$routes[$path];

        return self::handle($handler, $params);
    }

    /**
     * Handle different return types
     * @param array $handler
     * @param array $params
     * @return bool|string
     */
    private static function handle(array $handler, array $params = []) : bool|string {
        $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
        $data = call_user_func_array($handler, $params);

        if (str_contains($accept, 'text/plain')) {
            header('Content-Type: text/plain');
            return print_r($data, true);
        }

        //JSON is currently the default
        header("Content-Type: application/json");
        return json_encode($data);
    }
}
?>