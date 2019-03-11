<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payments_ extends Model
{
    protected $table = "tbl_payments";

    protected $fillable = [
        'chamaa_name', 'members_count', 'chamaa_uuid'
    ];
}
