# RESTaurant

A lightweight PHP API router, written in vanilla PHP

Contributions are welcome, feel free to open a PR!

---

## Response Format

By default, all responses are returned as **JSON**.

To receive **plain text** instead, set the `Accept` header to `text/plain` in your request.

| `Accept` header    | Response format    |
|--------------------|--------------------|
| *(not set)*        | `application/json` |
| `text/plain`       | `text/plain`       |

---

## Routing

Routes are defined in `src/routes.php` as a static array. Each entry maps a path to an HTTP method and a handler:

```php
public static $routes = [
    "/api/v1/persons"            => ['GET',  Example::class, 'getPersons'],
    "/api/v1/person/{id}/update" => ['POST', Example::class, 'updateUserName'],
];
```

- `{id}` is a placeholder for any integer segment in the URL. Multiple `{id}` placeholders are supported and are passed to the handler in order.
- If the request method does not match the route's declared method, a `405 Method Not Allowed` is returned.
- If the path does not match any route, a `404 Not Found` is returned.

---

## Authentication

Some endpoints require a valid token. Pass it via a custom request header:

```
token: your_token_here
```

If the header is missing, the token doesn't exist, or it has expired, the API returns:

```
HTTP 401 Unauthorized
```
```json
{"error": "Missing token!"}
{"error": "Token does not exist!"}
{"error": "Token has expired!"}
```

### Token Management

Tokens are stored in `src/tokens/tokens.json`. Each token has a 90-day lifetime from the date of creation.

```json
{
    "token": "trYkfIOniXN76505yVvSRh6RFUdiy0",
    "creation_date": "2026-05-30",
    "expiration_date": "2026-08-28"
}
```

To issue a new token, call `Token::setToken()` from your PHP code.

To protect an endpoint, call `Token::needsToken()` at the start of the handler — it will abort with a `401` if the request is not authenticated.

---

## Example Endpoints

### `GET /api/v1/persons`

Returns a list of all persons.

```bash
curl http://localhost/api/v1/persons
```
```json
{"John": 21, "Boris": 18}
```

```bash
curl http://127.0.0.1/api/v1/persons -H "Accept: text/plain"
```
```
Array
(
    [John] => 21
    [Boris] => 18
)
```

---

### `GET /api/v1/person/{id}`

Returns a single person by ID.

```bash
curl http://127.0.0.1/api/v1/person/42
```
```json
{"John": 21, "id": 42}
```

---

### `GET /api/v1/person/{id}/post/{id}`

Returns a post belonging to a person. Requires a valid token.

```bash
curl http://127.0.0.1/api/v1/person/1/post/5 -H "token: your_token_here"
```
```json
{
    "userId": 1,
    "postId": 5,
    "post": {
        "title": "Welcome to the jungle!",
        "content": "I like turtles!"
    }
}
```

---

### `POST /api/v1/person/{id}/update`

Updates the username of a person.

```bash
curl -X POST http://127.0.0.1/api/v1/person/42/update \
     -d "name=Alice"
```
```
"Username successfully updated to Alice"
```

---

## Unsupported Methods

Only `GET` and `POST` are accepted globally. Any other HTTP method returns:

```
HTTP 405 Method Not Allowed
```
