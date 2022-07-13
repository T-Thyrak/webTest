# Web Application Lab Project

# Table of Contents
- [Web Application Lab Project](#web-application-lab-project)
- [Table of Contents](#table-of-contents)
- [Description](#description)
- [Dependencies](#dependencies)
- [Installation](#installation)
- [Screenshots](#screenshots)
    - [Initial Login Page](#initial-login-page)
    - [Registration Form](#registration-form)
    - [Main Application Page](#main-application-page)
    - [Add Product](#add-product)
    - [Confirming to add product](#confirming-to-add-product)
    - [Saved addition of product](#saved-addition-of-product)
    - [Change Language](#change-language)
    - [Main Application Page (in Chinese)](#main-application-page-in-chinese)
    - [Delete Product](#delete-product)
- [Contributions](#contributions)

# Description
This project is a lab assignment for the Web Application Lab Assignment.

The purpose of this project is to create a web application using [envms/FluentPDO](https://packagist.org/packages/envms/fluentpdo).

# Dependencies
- [XAMPP](https://www.apachefriends.org/index.html)
- [Composer](https://getcomposer.org/)
- [envms/FluentPDO](https://packagist.org/packages/envms/fluentpdo)
- [symfony/Dotenv](https://packagist.org/packages/symfony/dotenv)

# Installation
To install this project, first clone the repository to your machine.
```bash
git clone https://github.com/seavmouy/webTest.git && cd webTest
```

Then, install the dependencies.
```bash
composer install
```

After that, we have to import the sample database into phpMyAdmin. I use XAMPP, so I can import graphically, and saves me a lot of trouble.

The sample database file is located at `sampleDatabase.sql`.

Remember the name of the database that you imported, because we're going to create the .env file next.

`.env:`
```
DRIVER=mysql
DB_HOST=localhost
DB_PORT=<your phpMyAdmin/mySQL port>
DB_NAME=<your database name>
DB_USER=<your database username>
DB_PASS=<your database user password>
LOCALHOST_PORT=<your localhost port>
```

And then, we'll run a little SQL script to get us the event loop for regular cleaning of the `tokens` table.
```sql
DELIMITER //
CREATE DEFINER=`username`@`localhost`
EVENT rm_tokens
ON SCHEDULE EVERY 5 MINUTE
ON COMPLETION PRESERVE ENABLE
DO
    DELETE
        FROM `tokens`
        WHERE DATE_SUB(NOW(), INTERVAL 40 MINUTE) > `last_updated`;
//
DELIMITER ;
```

Then we're gonna enable it with
```sql
SET GLOBAL event_scheduler=ON;
```

After that, we should be good to go.

P.S: This is a little trick I use to run the project with XAMPP's built-in PHP server.

First, run XAMPP, and turn on Apache and MySQL services.
Then, open a terminal window using the `shell` button.
And then, run the following command:
```bash
cd /path/to/webTest
php -S localhost:<your localhost port>
```

P.P.S: There is a test user in the sample database.

Username = `usertest` and password = `Usertest#012#`

# Screenshots
### Initial Login Page
![Initial Login Page](/src/assets/img/Image%201.png)
### Registration Form
![Registration Form](/src/assets/img/Image%204.png)
### Main Application Page
![Main Application Page](/src/assets/img/Image%205.png)
### Add Product
![Add Product](/src/assets/img/Image%206.png)
### Confirming to add product
![Confirming to add product](/src/assets/img/Image%207.png)
### Saved addition of product
![Saved addition of product](/src/assets/img/Image%208.png)
### Change Language
![Change Language](/src/assets/img/Image%209.png)
### Main Application Page (in Chinese)
![Main Application Page (in Chinese)](/src/assets/img/Image%2011.png)
### Delete Product
![Delete Product](/src/assets/img/Image%2015.png)

# Contributions
- [TENG Thaisothyrak, the one that wrote this](https://github.com/t-thyrak)
- [SUO Seavmouy, the repository holder](https://github.com/seavmouy)
- [VUTHY Panha](https://github.com/panhaGKP)