<?php
/**
 * THIS IS AN EXAMPLE FILE.
 */

class Example {
    public static function getPersons() : array {
        return ['John' => 21, 'Boris' => 18];
    }

    public static function getPerson(int $id) : array {
        return ["John" => 21, "id" => $id];
    }

    public static function getPersonPosts(int $userId, int $postId) : array {
        return ['userId' => $userId, 'postId' => $postId, 'post' => [
            'title'   => "Welcome to the jungle!",
            'content' => "I like turtles!"
        ]];
    }
}
?>