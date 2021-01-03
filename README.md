

## About the project

This is a simple ChatBot using BotMan

## Documentation

You can find the BotMan and BotMan Studio documentation at [http://botman.io](http://botman.io).

## Getting started

-  `git clone git@github.com:vandersonramos/alles-bot.git`
- `cd alles-bot/`
-  `composer install`
- `cp .env.example .env`
- `php artisan migrate`
- `php artisan db:seed --class=CurrencyTableSeeder`

## API KEY

This project uses a service to perform currency conversion. Access the [site](https://free.currencyconverterapi.com/free-api-key) to generate an API KEY, then open the `.env` file and
set the API_KEY value.

## Running the project

`php artisan serve`
