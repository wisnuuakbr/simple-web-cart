# Simple Web Cart Laravel

Simple web cart using laravel 11

## Requirements

Simple web cart is currently extended with the following requirements.  
Instructions on how to use them in your own application are linked below.
| Requirement |  Version  |
|-------------|-----------|
| PHP         |  ^8.2     |
| PostgreSQL  |  14.10.x  |

## Installation

Make sure all requirements are installed on the system.
Clone the project and install dependencies:

```bash
$ git clone https://github.com/wisnuuakbr/simple-web-cart.git
$ cd simple-web-cart
$ composer install
```

## Configuration

Copy the .env.example file and rename it to .env  
Change the config for your local server

```bash
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=pcs_test
DB_USERNAME=postgres
DB_PASSWORD=postgres
```

## Generate App Key

Generate the application key using the following command:

```bash
$ php artisan key:generate
```

## Migration & Seeder

Run the migrations table:

```bash
$ php artisan migrate
```

Run the seeder:

```bash
$ php artisan db:seed
```

## Install the npm

Install NPM using the following command:

```bash
$ npm install
```

## Run Application

Run the application:

```bash
$ php artisan serve
```

and run the npm

```bash
$ npm run dev
```
