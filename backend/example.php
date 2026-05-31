<?php
include_once(__DIR__ . "/../src/tokens/token.php");
include_once(__DIR__ . "/../src/method.php");
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
        Token::needsToken();

        return ['userId' => $userId, 'postId' => $postId, 'post' => [
            'title'   => "Welcome to the jungle!",
            'content' => "I like turtles!"
        ]];
    }

    /**
     * Demonstration of a POST request
     * @param int $userId
     * @return void
     */
    public static function updateUserName(int $userId) : string {
        Token::needsToken();
        Method::rejectEmptyPost();

        $name = $_POST['name'];

        http_response_code(200);
        return "User's name with id: $userId, successfully updated to " . htmlspecialchars($name);
    }
}
?>