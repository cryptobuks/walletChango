<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{


    protected $table='tbl_projects';
    protected $fillable = [
        'project_name',
        'project_description',
        'target_group_number',
        'group_id',
        'project_target_amount',
        'project_initiated_by',
        'amount_collected',];
    public function user()
    {
        return $this->belongsTo('App\User','project_initiated_by','id');
    }
    public function payments()
    {
        return $this->hasMany('App\Payments_','id','project_id');
    }
}
