<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\WalletChangoUtils;
use App\Payments_;
use App\User;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Payments_[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Payments_::with(['user'])->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (isset($request->token)) {
            $request->headers->set('Authorization', "Bearer " . $request->token);
        }
        $check_token = (new WalletChangoUtils())->authenticate_jwt_auth();

        if ($check_token["success"] == true) {
            $validator = Validator::make($request->all(), [
                "wallet_id" => "required",
                "payment_amount" => "required",
                "transaction_type" => "required",
            ]);
            if ($validator->fails()) {
                return $validator->errors();
            } else {

                $user = User::where('id', $check_token['data']['id'])->first();
                $check_pay = (new WalletChangoUtils())->stkPush($user->phone_no, $request->payment_amount, $user->id);

                return Wallet::find($request->wallet_id);
//                $payment = new Payments_();
//                $payment->payment_reference = $request->reference;
//                $payment->payment_amount = $request->payment_amount;
//                $payment->user_id = $check_token['data']['id'];
//                $payment->project_id = $request->project_id;
//                $payment->group_id = $request->group_id;
//                $payment->save();


//                $transaction = new Transactions();
//                $transaction->user_id = $request->user_id;
//                $transaction->wallet_id = $request->wallet_id;
//                $transaction->amount = $request->payment_amount;
//                $transaction->reference = $request->reference;
//                $transaction->transaction_type = $request->transaction_type;
//                $transaction->save();

            }
        } else {
            return $check_token;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Payments_::with(['user', 'project'])->where('group_id', $id)->take(5)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
