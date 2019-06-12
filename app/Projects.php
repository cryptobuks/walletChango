<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
//    public $appends = ["project_payments"];


    protected $table = 'tbl_projects';
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
        return $this->belongsTo('App\User', 'project_initiated_by', 'id');
    }

    public function getProjectMembersAttribute()
    {
        return GroupMembership::with('user')->where("group_id",$this->id)->get();
    }

    public function payments()
    {
        return $this->hasMany('App\Payments_', 'project_id', 'id');
    }

    public function group()
    {
        return $this->belongsTo('App\Group', 'group_id', 'id');
    }
       public function getProjectPaymentsAttribute()
    {
        return Payments_::where('project_id', $this->id)
            ->join('users', 'tbl_payments.user_id', 'users.id')
            ->select('tbl_payments.payment_amount', 'users.name')
            ->get();
    }
}
