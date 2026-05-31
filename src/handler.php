<?php
include_once(__DIR__ . "/routes.php");
include_once(__DIR__ . "/../backend/example.php");
include_once(__DIR__ . "/path.php");
include_once(__DIR__ . "/method.php");

class Handler {
    public static function getData(string $path) : string|bool {
        $params = [];

        if (Path::contains_integer($path)) {
            $params = Path::extract_integers($path);
            $path = Path::replace_integer_with_id($path);
        }

        if (!array_key_exists($path, Router::$routes)) {
            http_response_code(404);
            return "Not found!";
        }

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
        Method::enforceMethod($handler[0]);

        $data = call_user_func_array(array_slice($handler, 1), $params);

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