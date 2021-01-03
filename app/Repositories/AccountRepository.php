<?php

namespace App\Repositories;

use App\Account;

class AccountRepository extends BaseRepository
{
    protected $account;

    /**
     * AccountRepository constructor.
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        parent::__construct($account);
    }
}
