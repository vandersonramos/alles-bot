<?php

namespace App\Services;

use App\Repositories\CurrencyRepository;
use App\Repositories\AccountRepository;
use App\Events\Transaction;
use BotMan\BotMan\BotMan;

class AccountService
{
    protected $accountRepository;
    protected $currencyRepository;

    /**
     * AccountService constructor.
     * @param AccountRepository $accountRepository
     * @param CurrencyRepository $currencyRepository
     */
    public function __construct(AccountRepository $accountRepository, CurrencyRepository $currencyRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * Save the data - (deposit / withdraw)
     * @param float $valueFrom
     * @param string|null $currency
     * @param string $transaction
     * @param string|null $user
     * @return array
     * @throws \Exception
     */
    public function save(float $valueFrom, ?string $currency, string $transaction, ?string $user): array
    {
        if (is_null($user)) {
            return [
                'status' => false,
                'message' => 'Please, log in or create an account to perform this action.'
            ];
        }

        $account = $this->accountRepository->findByColumnName('user_id', $user);

        if (count($account) > 0) {
            $currentCurrency = $this->currencyRepository->find($account[0]->currency_id);
            $valueTo = $valueFrom;

            if (!is_null($currency) && strtoupper($currency) !== $currentCurrency->code) {
                $result = CurrencyService::convert($valueFrom, $currency, $currentCurrency->code);

                if ($result['success']) {
                    $valueTo = $result['total'];
                }
            }

            $amount = $transaction === 'deposit' ?  ($account[0]->amount += $valueTo) : ($account[0]->amount -= $valueTo);

            if ($amount >= 0) {

                event(new Transaction([
                    'operation' => $transaction,
                    'user_id' => $user,
                    'currency_from' => $currency !== null ? $currency : $currentCurrency->code,
                    'value_from' => $valueFrom,
                    'currency_to' => $currentCurrency->code,
                    'value_to' => $valueTo,
                    'created_at' => (new \DateTime())->format('Y-m-d H:i:s')
                ]));

                return [
                    'status' => $this->accountRepository->update($account[0]->id, [
                        'amount' => round($amount, 2)
                    ]),
                    'message' => ucfirst($transaction).' completed.'
                ];

            }

            return [
                'status' => false,
                'message' => 'Insufficient funds'
            ];

        }

        return [
            'status' => false,
            'message' => 'Please, set the default currency first.'
        ];
    }

    /**
     * Return the account balance
     * @param BotMan $bot
     * @return array
     */
    public function accountBalance(BotMan $bot): array
    {
        $user = $bot->userStorage()->find('user')->get('user');

        if (is_null($user)) {
            return [
                'status' => false,
                'message' => 'Please, log in or create an account to perform this action.'
            ];
        }

        $account = $this->accountRepository->findByColumnName('user_id', $user);

        if (count($account) > 0) {
            return [
                'status' => true,
                'message' => "Your current account balance is {$account[0]->amount} {$account[0]->currency->code}"
            ];
        }

        return [
            'status' => true,
            'message' => "Please, set your currency."
        ];

    }
}
