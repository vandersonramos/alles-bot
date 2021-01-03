<?php

namespace App\Http\Controllers;

use App\Services\CurrencyService;
use BotMan\BotMan\BotMan;

class CurrencyController extends Controller
{
    protected $currencyService;

    /**
     * CurrencyController constructor.
     * @param CurrencyService $currencyService
     */
    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Returns the available currencies
     * @param BotMan $bot
     */
    public function availableCurrencies(BotMan $bot)
    {
        $currencies = $this->currencyService->getAll();
        $bot->reply('These are the currencies available');

        foreach($currencies as $currency) {
            $bot->reply($currency['code']." (".$currency['name'].")");
        }
    }

    /**
     * Save the default currency to perform transactions
     * @param BotMan $bot
     * @param string $currency
     */
    public function setDefaultCurrency(Botman $bot, string $currency)
    {
        $currency = strtoupper($currency);
        $user = $bot->userStorage()->find('user')->get('user');

        if ($this->currencyService->validateCurrencyCode($currency, $user)) {
            $result = $this->currencyService->save($currency, $user);
            $bot->reply($result['message']);

        } else {
            $bot->reply("Error, please try again.");
        }
    }

    /**
     * Call the service to convert
     * @param BotMan $bot
     * @param string $valueFrom
     * @param string $currencyFrom
     * @param string $currencyTo
     */
    public function convert(BotMan $bot, string $valueFrom, string $currencyFrom, string $currencyTo)
    {
        $result = $this->currencyService->convert($valueFrom, $currencyFrom, $currencyTo);

        if ($result['success']) {
            $message = sprintf('%.2f %s to %s is: %.2f', $valueFrom,
                strtoupper($currencyFrom), strtoupper($currencyTo), $result['total']);

        } else {
            $message = 'There is an error, please try again.';
        }

        $bot->reply($message);
    }
}
