<?php
class Token {
    /**
     * Check whether a token has been send and whether it is valid.<br>
     * Put this function at the start of every function you want to restrict to token users.
     * @return void
     */
    public static function needsToken() : void {
        $token = $_SERVER['HTTP_TOKEN'] ?? null;
        if (!$token) self::abort("Missing token!");

        $token = $_SERVER['HTTP_TOKEN'];

        $array = json_decode(file_get_contents(__DIR__ . "/tokens.json"));

        for($i = 0; $i < count($array); $i++) {
            if ($array[$i]->token === $token) {
                $object = $array[$i];
                if (strtotime($object->expiration_date) < time()) self::abort("Token has expired!");
                
                return;
            }
        }

        self::abort("Token does not exist!");
    }

    /**
     * Write a new token to tokens.json
     * @return bool|int
     */
    public static function setToken() : bool {
        //Default token life time of 90 days, counting from the day of creation
        $expDate = date("Y-m-d", strtotime("+90 days"));

        $newToken = [
            "token"           => self::generateToken(),
            "creation_date"   => date("Y-m-d"),
            "expiration_date" => $expDate
        ];

        $file = __DIR__ . "/tokens.json";
        $tokens = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
        $tokens[] = $newToken;

        return file_put_contents($file, json_encode($tokens, JSON_PRETTY_PRINT));
    }

    /**
     * Generate a randomly generated 30 long token
     * @return string
     */
    private static function generateToken(): string {
        $charset = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $string = "";

        for ($i = 0; $i < 30; $i++) {
            $string .= $charset[random_int(0, strlen($charset) - 1)];
        }

        return $string;
    }

    /**
     * Abort the connection and show a message
     * @param string $message
     * @return never
     */
    private static function abort(string $message) : never {
        http_response_code(401);
        die(json_encode(["error" => $message]));
    }
}
?>