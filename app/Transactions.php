<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = "tbl_transactions";
    protected $appends = ['transaction_type', 'transaction_at'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }


    public function getTransactionTypeAttribute()
    {
        return $this->transaction_type = 1 ? "Debit" : "Credit";
    }

    public function getTransactionAtAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
