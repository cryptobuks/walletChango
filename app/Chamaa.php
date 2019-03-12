<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class   Chamaa extends Model
{
    protected $table = "tbl_chamaa";

    protected $fillable = [
        'payment_reference', 'payment_amount', 'user_id', 'project_id', 'chamaa_id',
    ];


    public function users(){
        return $this->hasMany('App\Users','id','');
    }
}
