<?php
class Path {
    public static function contains_integer(string $path) : bool {
        $split = explode("/", $path);

        foreach($split as $part) if (is_numeric($part)) return true;

        return false;
    }

    public static function replace_integer_with_id(string $path) : string {
        $split = explode("/", $path);

        $result = array_map(fn($part) => is_numeric($part) ? "{id}" : $part, $split);

        return implode("/", $result);
    }

    public static function extract_integers(string $path) : array {
        return array_values(array_filter(
            explode("/", $path),
            fn($part) => is_numeric($part)
        ));
    }
}
?>