<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = "tbl_wallets";

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

}
