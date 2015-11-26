# emojinaija

[![Build Status](https://travis-ci.org/andela-iadeniyi/emojinaija.svg)](https://travis-ci.org/andela-iadeniyi/emojinaija)
[![License](http://img.shields.io/:license-mit-blue.svg)](https://github.com/andela-iadeniyi/emojinaija/blob/master/LICENCE)
[![Quality Score](https://img.shields.io/scrutinizer/g/andela-iadeniyi/emojinaija.svg?style=flat-square)](https://scrutinizer-ci.com/g/andela-iadeniyi/emojinaija)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/andela-iadeniyi/emojinaija/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/andela-iadeniyi/emojinaija/?branch=master)
[![Code Climate](https://codeclimate.com/github/andela-iadeniyi/emojinaija/badges/gpa.svg)](https://codeclimate.com/github/andela-iadeniyi/emojinaija)
[![Test Coverage](https://codeclimate.com/github/andela-iadeniyi/emojinaija/badges/coverage.svg)](https://codeclimate.com/github/andela-iadeniyi/emojinaija/coverage)


Emojinaija is a restful API service that provide access for emoji management. Just link to the [emojinaija](https://emojinaija.herokuapp.com/).

## Installation

[PHP](https://php.net) 5.5+ and [Composer](https://getcomposer.org) are required.

Via Composer

``` bash
$ composer require ibonly/naija-emoji
$ composer install
```

## Usage

### API ENDPOINT
```
        EndPoint                        Public Access
    POST /auth/Login                        TRUE
    GET /auth/Logout                        FALSE
    POST /emojis                            FALSE
    GET /emojis/                            TRUE
    GET /emojis/{id}                        TRUE
    POST /emojis/{id}                       FALSE
    PATCH /emojis/{id}                      FALSE
    PUT /emojis/{id}                        FALSE
    DELETE /emojis/{id}                      FALSE
```

### API FUNCTIONALITY
```
        EndPoint                            Functionality
    POST /auth/login                   Logs a user in
    GET /auth/logout                   Logs a user out
    GET /emojis                        List all the created emojis.
    GET /emojis/{id}                   Gets a single emoji
    POST /emojis                       Create a new emoji
    PUT /emojis/{id}                   Updates an emoji
    PATCH /emojis/{id}                 Partially updates an emoji
    DELETE /emojis/{id}                Deletes a single emoji
```


## Methods accessible to the public

####Single emoji retrieval

REQUEST:
``` bash
    GET https://emojinaija.herokuapp.com/emoji/1
    HEADER: {"Content-Type": "application/json"}
```
RESPONSE MESSAGE: If emoji with id of 1 exist:
``` bash
    HEADER: {"status": 200}
    BODY:
    [
        {
          "id": 1,
          "name": "lips",
          "char": "�"
          "keyword": [
            "lips",
            "parts",
            "body",
            "kiss"
          ],
          "category": "human",
          "date_created": "2015-11-19 22:37:08",
          "date_modified": "2015-10-19 22:37:08",
          "created_by": "foo"
        }
    ]
```
RESPONSE MESSAGE: If emoji of id 1 is not found
``` bash
    HEADER: {"status": 404}
    BODY:
    {
      "message": "Not Found"
    }
```

* Retrieve all emoji

REQUEST:
``` bash
    HEADER: GET https://emojinaija.herokuapp.com/emojis
    HEADER: {"Content-Type": "application/json"}
```
RESPONSE MESSAGE: Get all emoji:
``` php
    HEADER: {"status": 200}
    BODY: If there are saved resources
    [
        {
            "id": 3,
            "name": "Olopa",
            "char": "👮",
            "keywords": [
              "man",
              "police",
              "human"
            ],
            "category": "Peoples",
            "date_created": "2015-11-25 09:30:19",
            "date_modified": "2015-11-25 09:35:00",
            "created_by": "foo"
          },
          {
            "id": 4,
            "name": "nose",
            "char": "👃",
            "keywords": [
              "human parts",
              "nose",
              "body"
            ],
            "category": "human",
            "date_created": "2015-11-26 09:09:46",
            "date_modified": "2015-11-26 09:09:46",
            "created_by": "foo"
          },
          {
            "id": 5,
            "name": "Prof",
            "char": "👴",
            "keywords": [
              "Human",
              "People"
            ],
            "category": "Human",
            "date_created": "2015-11-26 15:32:19",
            "date_modified": "2015-11-26 15:32:19",
            "created_by": "foo"
        }
    ]
```
RESPONSE MESSAGE: If no emoji found:
``` bash
    HEADER: {"status": 404}
    BODY:
    {
      "message": "Not Found"
    }
```
* In order to access private methods, Registration is required and a token will be generated for the registered user when logged in. The token generated will be used to access private API.

* Registration

REQUEST:
``` bash
    POST https://emojinaija.herokuapp.com/register
    HEADER: {"Content-Type": "application/json"}
    BODY:
    {
      "username": your_preferred_username,
      "password": your_preferred_password
    }
```
RESPONSE MESSAGE:
``` bash
    HEADER: {"status": 200}
    BODY:
    {
      "username": "ogeni",
      "message": "Registration Successful. Please Login to generate your token"
    }
```

* Login authentication

REQUEST:
``` bash
    POST https://emojinaija.herokuapp.com/auth/login
    HEADER: {"Content-Type": "application/json"}
    BODY:
    {
      "username": your_username,
      "password": your_password
    }
```
RESPONSE MESSAGE:
``` bash
    HEADER: {"status": 200}
    BODY:
    {
      "username": "user",
      "Authorization": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9eyJpc3"
    }
```

* Logout

REQUEST:
``` bash
    GET https://emojinaija.herokuapp.com/auth/logout
    HEADER:
    {
      "Content-Type": "application/json",
      "Authorization": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9eyJpc3"
    }
```
RESPONSE MESSAGE:
``` bash
    HEADER: {"status": 200}
    BODY:
    {
      "message": "Logged out Successfully"
    }
```

* Creating new emoji

REQUEST:
``` bash
    POST https://emojinaija.herokuapp.com/emojis
    HEADER:
    {
      "Content-Type": "application/json",
      "Authorization": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9eyJpc3"
    }

    BODY:
    {
      "name": "Horse",
      "char" : "🐎"
      "keyword": "Animal, Horse, Farm, Esin",
      "category": "Animal"
    }
```
RESPONSE MESSAGE:
```bash
    HEADER: {"status": 200}
    BODY:
    {
      "id": 9,
      "name": "Horse",
      "char" : "🐎"
      "keyword": [
        "Animal",
        "Horse",
        "Farm",
        "Esin"
      ],
      "category": "Animal",
      "date_created": "2015-11-26 15:32:19",
      "date_modified": "2015-11-26 15:32:19",
      "created_by": "foo"
    }
```

* Updating emojis

REQUEST:
``` bash
    PUT https://emojinaija.herokuapp.com/emojis/9
    PATCH https://emojinaija.herokuapp.com/emojis/9
    HEADER:
    {
      "Content-Type": "application/json",
      "Authorization": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9eyJpc3"
    }
    BODY:
    {
          "keyword": "Animal, Horse, Farm, Esin, Zoo",
    }
```
RESPONSE MESSAGE:
```bash
    HEADER: {"status": 200}
    BODY:
    {
      "Message" => "Emoji Updated Successfully"
    }
```

* Delete an emojis

REQUEST:
```bash
    DELETE https://emojinaija.herokuapp.com/emojis/9
    HEADER:
    {
      "Content-Type": "application/json",
      "Authorization": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9eyJpc3"
    }
```
RESPONSE MESSAGE:
``` bash
    HEADER: {"status": 200}
    BODY:
    {
      "Message" => "Emoji Deleted"
    }
```

## Testing

```
$ vendor/bin/phpunit test
```

## Contributing

To contribute and extend the scope of this package,
Please check out [CONTRIBUTING](CONTRIBUTING.md) file for detailed contribution guidelines.

## Credits

Emojinaija is created and maintained by `Ibraheem ADENIYI`.
