# Nearby shops

Nearby shop is a web application that list the shops by distance.

## Requirements

- PHP 7 or later
- Mysql 

## Getting Started
Clone this project using the following commands:

```
$ git clone https://github.com/Black-skyliner/nearby-shops.git

$ cd nearby-shops
```

### Set up the Backend
Use the package manager [composer](https://getcomposer.org/) to install the project dependencies.

```
$ cd symfony4

$ composer install
```

#### Configure .env file
Copy and edit the .env file and enter the credentials (Mysql User and password) there:

```
$ cp .env.local .env
```

> DATABASE_URL=mysql://your_user:your_password@127.0.0.1:3306/nearby-shops

#### Create database
Create the database and tables.

```
$ php bin/console doctrine:database:create

$ php bin/console doctrine:schema:update --force
```
#### Generate fake data

```
$ php bin/console doctrine:fixtures:load --append
```

#### Run server
Start the internal server of PHP.

```
$ php -S 127.0.0.1:8000 -t public/
```

## Usage
To get the token use the following request.

```
CURL --header "Content-Type: application/json" --request POST --data {\"security\":{\"credentials\":{\"email\":\"demo@unitedremote.com\",\"password\":\"demo\"}},\"location\":{\"latitude\":\"-71.918303\",\"longitude\":\"30.897918\"}} http://127.0.0.1:8000/auth/login
```

Then use the token value in the following requests to get:

The list of nearby shops.

```
CURL --header "X-AUTH-TOKEN: Your_token" --request GET 127.0.0.1:8000/api/shop/list
```

The list preferred shops.

```
CURL --header "X-AUTH-TOKEN: Your_token" --request GET 127.0.0.1:8000/api/shop/preferredList
```

Like shop (ex. id = 1).

```
CURL --header "X-AUTH-TOKEN: Your_token" --request GET 127.0.0.1:8000/api/shop/1/like/
```

Remove shop from the preferred list (ex. id = 1).

```
CURL --header "X-AUTH-TOKEN: Your_token" --request DELETE 127.0.0.1:8000/api/shop/1/remove

Dislike shop (ex. id = 2).

```
CURL --header "X-AUTH-TOKEN: Your_token" --request GET 127.0.0.1:8000/api/shop/2/dislike
```