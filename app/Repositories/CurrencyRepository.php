<?php

namespace App\Repositories;

use App\Currency;

class CurrencyRepository extends BaseRepository
{
    protected $currency;


    /**
     * CurrencyRepository constructor.
     * @param Currency $currency
     */
    public function __construct(Currency $currency)
    {
        $this->currency = $currency;
        parent::__construct($currency);
    }

    /**
     * @return array
     */
    public function getCurrenciesArray(): array
    {
        return $this->currency::get(['name', 'code'])->toArray();
    }
}
