# Nearby shops

Nearby shop is a web application that list the shops by distance.


## Requirements

- PHP 7 or later
- Mysql 

## Getting Started

### Set up the Backend



$ git clone https://github.com/Black-skyliner/shopping.git

Use the package manager [composer](https://getcomposer.org/) to install all dependencies.

$ composer install






###### Configure .env file
Replace the following elements in your .env file by the correct parameters :
- your_user
- your_password
- database_name .

> DATABASE_URL=mysql://your_user:your_password@127.0.0.1:3306/database_name

###### Create database
Create the database using doctrine ORM bundle.

$ php bin/console doctrine:database:create

###### Create tables
create tables and relationships between the tables.

$ php bin/console doctrine:schema:update --force

###### Generate fake data
Fill the database for test.

$ php bin/console doctrine:fixtures:load --append

###### Run server

$ php -S 127.0.0.1:8000 -t public/