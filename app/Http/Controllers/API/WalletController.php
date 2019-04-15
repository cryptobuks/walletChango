<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Wallet;
use Illuminate\Http\Request;

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
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'user_id' => 'required|integer',
            'wallet_name' => 'required',
            'wallet_amount' => 'required|integer',
        ]);
        $new_group = new Wallet();
        $new_group->wallet_name = $request->all()['wallet_name'];
        $new_group->user_id = $request->all()['user_id'];
        $new_group->wallet_amount = $request->all()['wallet_amount'];
        $new_group->save();
        return response(wallet::all());
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
        $wallet['wallet_amount'] =$wallet->wallet_amount+ $request->amount;
        $wallet->save();

        $transaction = new TransactionController();
        return $transaction->store($request);
    }
}
