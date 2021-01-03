<?php

namespace App\Services;

use App\Repositories\AccountRepository;
use App\Repositories\CurrencyRepository;


class CurrencyService
{
    protected $currencyRepository;
    protected $accountRepository;
    const API_URL = 'https://free.currconv.com/api/v7/convert?q=';


    /**
     * CurrencyService constructor.
     * @param CurrencyRepository $currencyRepository
     * @param AccountRepository $accountRepository
     */
    public function __construct(CurrencyRepository $currencyRepository, AccountRepository $accountRepository)
    {
        $this->currencyRepository = $currencyRepository;
        $this->accountRepository = $accountRepository;
    }

    /**
     * Get all currencies available
     *
     * @return object
     */
    public function getAll(): object
    {
        return $this->currencyRepository->all();
    }

    /**
     * Check if the currency exists on DB.
     *
     * @param string|null $currency
     * @param string|null $user
     * @return bool
     */
    public function validateCurrencyCode(?string $currency = null, ?string $user): bool
    {

        if ($currency === null) {
            $account = $this->accountRepository->findByColumnName('user_id', $user);

            if (count($account) > 0) {
                $currency = $this->currencyRepository->find($account[0]->currency_id)->code;
            } else {
                return false;
            }
        }

        $currencies = $this->currencyRepository->getCurrenciesArray();
        $items = array_column($currencies, 'code');

        if (in_array($currency, $items)) {
            return true;
        }

        return false;
    }

    /**
     * Save currency
     * @param string $currency
     * @param string|null $user
     * @return array
     */
    public function save(string $currency, ?string $user): array
    {
        if (is_null($user)) {
            return [
                'status' => false,
                'message' => 'Please, log in or create an account to perform this action.'
            ];
        }

        $currencyId = $this->currencyRepository->findByColumnName('code', strtoupper($currency))[0]->id;
        $account = $this->accountRepository->findByColumnName('user_id', $user);

        if (count($account) > 0) {
            $currentCurrency = $this->currencyRepository->find($account[0]->currency_id);
            $value = $account[0]->amount;

            if (strtoupper($currency) !== $currentCurrency->code) {
                $result = self::convert($account[0]->amount, $currentCurrency->code, $currency);

                if ($result['success']) {
                    $value = $result['total'];
                }
            }

            return [
                'status' => $this->accountRepository->update($account[0]->id, [
                    'user_id' => $user,
                    'currency_id' => $currencyId,
                    'amount' => round($value, 2)
                ]),
                'message' => 'Currency updated.'
            ];
        } else {
            return [
                'status' => $this->accountRepository->insert([
                    'user_id' => $user,
                    'currency_id' => $currencyId,
                    'amount' => 0
                ]),
                'message' => 'Great. Currency set up.'
            ];
        }
    }

    /**
     * Check if there is a currency code
     * @param string $value
     * @return array
     */
    public function checkCurrencyCode(string $value): array
    {
        $array = explode(' ', $value);
        return [abs($array[0]), count($array) > 1 ? strtoupper($array[1]) : null];
    }

    /**
     * Call the API to convert
     *
     * @param float $valueFrom
     * @param string $currencyFrom
     * @param string $currencyTo
     * @return array
     */
    public static function convert(float $valueFrom, string $currencyFrom, string $currencyTo)
    {
        $params = strtoupper($currencyFrom) ."_". strtoupper($currencyTo);
        $compact = 'compact=ultra';
        $apiKey = "apiKey=".env('API_KEY');

        $fullURL = self::API_URL.$params."&".$compact."&".$apiKey;

        $json = file_get_contents($fullURL);
        $result = json_decode($json, true);

        if ($result[$params]) {
            return [
                'success' => true,
                'total' => $result[$params] * $valueFrom
            ];
        }

        return [
            'success' => false,
            'total' => 0
        ];
    }
}
