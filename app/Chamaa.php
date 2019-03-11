<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class   Chamaa extends Model
{
    protected $table = "tbl_chamaa";

    protected $fillable = [
        'chamaa_name', 'members_count', 'chamaa_uuid',
    ];
}
