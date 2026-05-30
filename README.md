# RESTaurant

A lightweight PHP API router that serves your endpoints like a fine dining experience.

---

## Response Format

By default, all responses are returned as **JSON**.

To receive **plain text** instead, set the `Accept` header to `text/plain` in your request.

| `Accept` header | Response format |
|-----------------|-----------------|
| *(not set)*     | `application/json` |
| `application/json` | `application/json` |
| `text/plain`    | `text/plain` |

---

## Endpoints

### `GET /api/v1/persons`

Returns a list of all persons.

**JSON (default)**
```
GET /api/v1/persons
```
```json
{"John":21,"Boris":18}
```

**Plain text**
```
GET /api/v1/persons
Accept: text/plain
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

**JSON (default)**
```
GET /api/v1/person/42
```
```json
{"John":21,"id":42}
```

**Plain text**
```
GET /api/v1/person/42
Accept: text/plain
```
```
Array
(
    [John] => 21
    [id] => 42
)
```

---

## Unsupported Methods

Only `GET` requests are currently accepted. Any other HTTP method returns:

```
HTTP 405 Method Not Allowed
```
