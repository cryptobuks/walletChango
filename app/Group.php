<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class   Group extends Model
{
    protected $table = "tbl_group";
//    protected $appends = ['group_members' , 'group_payments'];

    protected $fillable = [
        'payment_reference', 'payment_amount', 'user_id', 'project_id', 'group_id',
    ];


    public function getGroupMembersAttribute()
    {

        $user = GroupMembership::with(['user'])->where('group_id', $this->id)
            ->get();
        return $user;
    }

    public function getGroupPaymentsAttribute()
    {

        $payments = Payments_::with(['project', 'user'])->where('group_id', $this->id)->get();
        return $payments;
    }

    public function getGroupPaymentsTotalAttribute()
    {

        $payments = Payments_::with(['project'])->select('payment_amount')->where('group_id', $this->id)->get();
        $total_payments = 0;
        foreach ($payments as $payment) {
            $total_payments += $payment->payment_amount;
        }
        return $total_payments;
    }
}
