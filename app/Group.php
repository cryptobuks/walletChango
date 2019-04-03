<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class   Group extends Model
{
    protected $table = "tbl_group";

    protected $fillable = [
        'payment_reference', 'payment_amount', 'user_id', 'project_id', 'group_id',
    ];


    public function users(){
        return $this->hasMany('App\Users','id','');
    }
}
