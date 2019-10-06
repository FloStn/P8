# Project 8 OpenClassrooms
## Improve an existing ToDo & Co application

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/88a2088512e44c929bb462d1c728c941)](https://www.codacy.com/app/FloStn/P8?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=FloStn/P8&amp;utm_campaign=Badge_Grade)
## Context

Student project realized as part of an OpenClassrooms training course.

## Installation

First, make sure that [Composer](https://getcomposer.org) is installed.

**Install project dependencies**

To install the project dependencies, execute the following command :

``` bash
composer install
```

**Configure your database**

Configure the app/config/parameters.yml file :

``` env
parameters:
    database_host:     127.0.0.1
    database_port:     ~
    database_name:     symfony
    database_user:     root
    database_password: ~
    # You should uncomment this if you want use pdo_sqlite
    # database_path: "%kernel.root_dir%/data.db3"

    mailer_transport:  smtp
    mailer_host:       127.0.0.1
    mailer_user:       ~
    mailer_password:   ~

    # A secret key that's used to generate certain security-related tokens
    secret:            ThisTokenIsNotSoSecretChangeIt
```

**Create the database**

``` bash
php bin/console doctrine:database:create
```

**Configure Redis**

The project uses Redis for cache management.  
Configure the app/config/redis.yml file :

``` env
snc_redis:
    clients:
        default:
            type: predis
            alias: default
            dsn: redis://localhost
        doctrine:
            type: predis
            alias: doctrine
            dsn: redis://localhost
    doctrine:
        metadata_cache:
            client: doctrine
            entity_manager: default
            document_manager: default
        result_cache:
            client: doctrine
            entity_manager: default
        query_cache:
            client: doctrine
            entity_manager: default
```

For more informations about Redis, you can refer to the [official documentation](https://redis.io/documentation).

**Load data fixtures (optional)**

The project uses the [hautelook/alice-bundle](https://packagist.org/packages/hautelook/alice-bundle) library to generate data fixtures.  
For generate the data fixtures, execute the following command :

``` bash
php bin/console hautelook:fixtures:load
```
And confirm by pressing the "y" key.
