<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payments_ extends Model
{
    protected $table = "tbl_payments";

    protected $fillable = [
        'group_name', 'members_count', 'group_uuid'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function project()
    {
        return $this->belongsToMany('App\Projects');
    }

}
