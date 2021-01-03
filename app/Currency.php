<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = ['name', 'code'];

    public function accounts()
    {
        return $this->hasMany('App\Account');
    }
}
