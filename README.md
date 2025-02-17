# Composer,PHP,Laravel Version

Composer version 2.8.5 2025-01-21 15:23:40
PHP version 8.4.4 (/usr/bin/php8.4)
Laravel Framework 11.42.1

# How to install and run repositories

## Clone the repositories

https://github.com/jvcayao/bemyguest_techexam.git


## Got to project directory and copy .env.example >> .env

cd "to project location"
cp .env.example .env

## Install Laravel package

composer install

## Migrate the tables using php artisan command

php artisan migrate

## Added Database Seeder

php artisan db:seed


## After installation run php artisan serve for local deployment

php artisan serve

## Application will usually run on 127.0.0.1:8000

## Test the API Endpoint

API endpoint using http://127.0.0.1:8000/api/convert?amount=1 using postman

`Success Response`

```json
{
    "timestamp": "2025-02-18T01:53:35+08:00",
    "success": true,
    "errors": [],
    "data": {
        "sgd_amount": 1,
        "exchange_rate": 2.96,
        "pln_amount": 2.96
    }
}
```

`Validation Response Error`

```json
{
    "timestamp": "2025-02-18T02:17:01+08:00",
    "success": false,
    "errors": [
        {
            "code": 1020,
            "message": "The amount field must be at least 1."
        }
    ],
    "data": []
}
```

## Laravel PHP Unit test

run php artisan test




