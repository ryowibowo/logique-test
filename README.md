# Introduction
PHP web app using Lumen Framework.

### Setup
```hash
1. Clone this repo
2. composer install
3. cp .env.example .env
4. setup your DB_DATABASE, DB_USERNAME, DB_PASSWORD
5. php artisan migrate
```

### How To Run
```hash
php -S localhost:8000 -t public
```

### How To run API 
Import file "Logique API.postman_collection.json" Collection on Postman

Also, the API has to provide endpoints for four operations:

**GET** `/user` - a list of user, sorting and filtering options.

Available query parameters:
- q - search any text
- ob - Search By  `name`
- sb - one of `ASC` or `DESC`

Add Headers

param : key
Value : HiJhvL$T27@1u^%u86g

Sample response (HTTP 200)

```json
{
    "metaData": {
        "code": 200,
        "message": "Data Found"
    },
    "response": [
        {
            "id": 1,
            "name": "tes1",
            "address": "tes",
            "email": "tes11401@mail.id",
            "created_at": "2023-01-02T07:51:12.000000Z",
            "updated_at": "2023-01-02T07:51:12.000000Z",
            "photo": [
                {
                    "user_id": 1,
                    "photo": "photo_2022-12-30_17-08-53-63b28cf00c7bc.jpg"
                },
                {
                    "user_id": 1,
                    "photo": "photo_2022-12-30_17-08-57-63b28cf00dce2.jpg"
                }
            ],
            "credit": {
                "user_id": 1,
                "creditcard_type": "visa",
                "creditcard_number": "12443545",
                "creditcard_name": "asdf",
                "creditcard_expired": "13 jan",
                "creditcard_cvv": "868"
            }
        },
        {
            "id": 2,
            "name": "update111",
            "address": "update2",
            "email": "update@mail.id",
            "created_at": "2023-01-02T07:52:09.000000Z",
            "updated_at": "2023-01-03T14:54:53.000000Z",
            "photo": [
                {
                    "user_id": 2,
                    "photo": "photo_2022-12-30_17-08-53-63b28d299703f.jpg"
                },
                {
                    "user_id": 2,
                    "photo": "photo_2022-12-30_17-08-57-63b28d2998493.jpg"
                }
            ],
            "credit": {
                "user_id": 2,
                "creditcard_type": "visa",
                "creditcard_number": "12443541",
                "creditcard_name": "asdf",
                "creditcard_expired": "13 jan",
                "creditcard_cvv": "861"
            }
        }
    ]
}
```

In case of an empty key

```json
{
    "error": "API key is missing."
}
```

**POST** `/users/register` - creates a new User.

Access to this endpoint requires authentication with Header key.

Required parameters:
- name - string
- address - string
- password - string
- email - string
- photo[] -  select file mutiple image
- email - string
- creditcard_type - string
- creditcard_number - string
- creditcard_name - string
- creditcard_expired - string
- creditcard_cvv - string

Sample response (HTTP 200)

```json
{
    "metaData": {
        "code": 200,
        "message": "Success Add User"
    },
    "user_id": 8
}
```

In case of an empty key

```json
{
    "error": "API key is missing."
}
```


**GET** `/users/{id}` - Get User Details

Access to this endpoint requires authentication with an key.

Sample response (HTTP 201)

```json
{
    "metaData": {
        "code": 200,
        "message": "Data Found"
    },
    "response": [
        {
            "id": 8,
            "name": "John Doe",
            "address": "jalan majapahit",
            "email": "johndoe@mail.id",
            "created_at": "2023-01-03T15:43:06.000000Z",
            "updated_at": "2023-01-03T15:43:06.000000Z",
            "photo": [
                {
                    "user_id": 8,
                    "photo": "photo_2022-12-30_17-08-53-63b44d0a84e75.jpg"
                },
                {
                    "user_id": 8,
                    "photo": "photo_2022-12-30_17-08-57-63b44d0a86bd1.jpg"
                }
            ],
            "credit": {
                "user_id": 8,
                "creditcard_type": "visa",
                "creditcard_number": "12443545",
                "creditcard_name": "John Doe",
                "creditcard_expired": "13 jan",
                "creditcard_cvv": "868"
            }
        }
    ]
}
```

In case of an empty user_id, Show all users.
In case of an empty key

```json
{
    "error": "API key is missing."
}
```

**PATCH** `/users` - Update User .

Access to this endpoint requires authentication with Header key.

Required parameters:
- user_id - string
- name - string
- address - string
- password - string
- email - string
- email - string
- creditcard_type - string
- creditcard_number - string
- creditcard_name - string
- creditcard_expired - string
- creditcard_cvv - string

Sample response (HTTP 200)

```json
{
    "metaData": {
        "code": 200,
        "message": "Success Add User"
    },
    "user_id": 8
}
```

In case of an empty key

```json
{
    "error": "API key is missing."
}
```
