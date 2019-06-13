<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\WalletChangoUtils;
use App\Investments;
use App\Transactions;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Wallet::get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**                String wallet_amount = getString(R.string.your_wallet_amount_is);
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if (isset($request->token)) {
            $request->headers->set('Authorization', "Bearer " . $request->token);
        }
        $check_token = (new WalletChangoUtils())->authenticate_jwt_auth();
        if ($check_token["success"] == true) {

            $this->validate($request, [
                'wallet_name' => 'required',
                'wallet_amount' => 'required|integer',
            ]);
            $new_group = new Wallet();
            $new_group->wallet_name = $request->all()['wallet_name'];
            $new_group->user_id = $check_token['data']['id'];
            $new_group->wallet_amount = $request->all()['wallet_amount'];
            $new_group->save();
            return response(wallet::all());
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
        return Wallet::with('user')->where('user_id', $id)->first();

    }

    public function user_invest(Request $request)
    {


        if (isset($request->token)) {
            $request->headers->set('Authorization', "Bearer " . $request->token);
        }
        $check_token = (new WalletChangoUtils())->authenticate_jwt_auth();

        if ($check_token["success"] == true) {

            $validator = $validator = Validator::make($request->all(), [
                'project_id' => 'required',
                'amount' => 'required',
            ]);


            if (!$validator->passes()) {
                return api_response(
                    false,
                    $validator->errors()->all(),
                    1,
                    'failed',
                    "Some entries are missing",
                    null
                );

            }
            $wallet = Wallet::where("user_id", $check_token['data']['id'])->first();

            if ($wallet->wallet_amount > $request->amount) {

                $wallet->wallet_amount = $wallet->wallet_amount - $request->amount;
                $wallet->save();


                $investment = new Investments();
                $investment->user_id = $check_token['data']['id'];
                $investment->project_id = $request->project_id;
                $investment->invest_amount = $request->amount;
                $investment->save();


                $transaction = new Transactions();
                $transaction->user_id = $check_token['data']['id'];
                $transaction->wallet_id = $wallet->id;
                $transaction->amount = $request->amount;
                $transaction->reference = "Wal_" . $request->wallet_id . "inv_" . $investment->id;
                $transaction->transaction_type = 1;
                $transaction->save();

                if ($transaction) {
                    return api_response(true, null, 0, "success", "successful investment", null);
                }
            } else {
                return api_response(0, "Amount less than wallet. You have " . $wallet->wallet_amount, 1, 'success', "You dont have enough money in  your wallet",
                    null);
            }
        }
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


    public function deposit_amount(Request $request)
    {

        $this->validate($request, [
            'user_id' => 'required|integer',
            'amount' => 'required',
            'wallet_id' => 'required|integer',
            'transaction_type' => 'required|integer',
        ]);
        $wallet = Wallet::find($request->wallet_id);
        $wallet['wallet_amount'] = $wallet->wallet_amount + $request->amount;
        $wallet->save();

        $transaction = new TransactionController();
        return $transaction->store($request);
    }
}
