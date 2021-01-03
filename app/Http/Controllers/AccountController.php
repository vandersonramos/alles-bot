<?php

namespace App\Http\Controllers;

use App\Services\CurrencyService;
use App\Services\AccountService;
use BotMan\BotMan\BotMan;

class AccountController extends Controller
{
    protected $accountService;
    protected $currencyService;


    /**
     * AccountController constructor.
     * @param AccountService $accountService
     * @param CurrencyService $currencyService
     */
    public function __construct(AccountService $accountService, CurrencyService $currencyService)
    {
        $this->accountService = $accountService;
        $this->currencyService = $currencyService;
    }

    /** Make a deposit
     *
     * @param BotMan $bot
     * @param string $value
     * @throws \Exception
     */
    public function deposit(BotMan $bot, string $value)
    {
        list($number, $currency) = $this->currencyService->checkCurrencyCode($value);

        $user = $bot->userStorage()->find('user')->get('user');

        if ($this->currencyService->validateCurrencyCode($currency, $user) && is_numeric($number)) {
            $result = $this->accountService->save(floatval($number), $currency, 'deposit', $user);
            $bot->reply($result['message']);
        } else {
            $bot->reply("Invalid parameters");
        }
    }

    /**
     * List the account balance
     * @param BotMan $bot
     */
    public function accountBalance(Botman $bot)
    {
        $accountBalance = $this->accountService->accountBalance($bot);
        $bot->reply($accountBalance['message']);
    }

    /**
     * Make a Withdraw
     *
     * @param BotMan $bot
     * @param string $value
     * @throws \Exception
     */
    public function withdraw(Botman $bot, string $value)
    {
        list($number, $currency) = $this->currencyService->checkCurrencyCode($value);

        $user = $bot->userStorage()->find('user')->get('user');

        if ($this->currencyService->validateCurrencyCode($currency, $user) && is_numeric($number)) {
            $result = $this->accountService->save(floatval($number), $currency, 'withdraw', $user);
            $bot->reply($result['message']);
        } else {
            $bot->reply("Invalid parameters");
        }
    }

}
