# Nearby shops

Nearby shop is a web application that list the shops by distance.

## Requirements

- PHP 7 or later
- Mysql 

## Getting Started
Clone this project using the following commands:

$ git clone https://github.com/Black-skyliner/nearby-shops.git

$ cd nearby-shops

### Set up the Backend
Use the package manager [composer](https://getcomposer.org/) to install the project dependencies.

$ composer install

#### Configure .env file
Copy and edit the .env file and enter the db details there:

$ cd nearby-shops/

$ cp .env.local .env

> DATABASE_URL=mysql://your_user:your_password@127.0.0.1:3306/nearby-shops

#### Create database
Create the database and table.

$ php bin/console doctrine:database:create

$ php bin/console doctrine:schema:update --force

#### Generate fake data
Generates fake data.

$ php bin/console doctrine:fixtures:load --append

###### Run server
Start the server interne of php.

$ php -S 127.0.0.1:8000 -t public/