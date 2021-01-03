<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');

$botman->hears('.*(Hi|Hello|Hey).*', BotManController::class.'@startConversation');
$botman->hears('(login|Login|LOGIN)', BotManController::class.'@login');
$botman->hears('(logout|Logout|LOGOUT)', BotManController::class.'@logout');
$botman->hears('(register|Register|REGISTER)', BotManController::class.'@register');

$botman->hears('Convert {valueFrom} {currencyFrom} to {currencyTo}', 'App\Http\Controllers\CurrencyController@convert');

$botman->hears('Available currencies', 'App\Http\Controllers\CurrencyController@availableCurrencies');

$botman->hears('My currency is {currency}', 'App\Http\Controllers\CurrencyController@setDefaultCurrency');

$botman->hears('Deposit {value}', 'App\Http\Controllers\AccountController@deposit');

$botman->hears('Withdraw {value}', 'App\Http\Controllers\AccountController@withdraw');

$botman->hears('Show account balance', 'App\Http\Controllers\AccountController@accountBalance');

$botman->fallback(function($bot) {
    $bot->reply("Unknown command. Please, try again");
});
