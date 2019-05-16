<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Transactions;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Transactions[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return $transactions = Transactions::all();
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
        $this->validate($request, [
            'user_id' => 'required|integer',
            'amount' => 'required',
            'wallet_id' => 'required|integer',
            'transaction_type' => 'required|integer',
        ]);
        $transaction = new Transactions();
        $transaction['user_id'] = $request->user_id;
        $transaction['wallet_id'] = $request->wallet_id;
        $transaction['amount'] = $request->amount;
        $transaction['transaction_type'] = $request->transaction_type;
        $transaction->save();

        return $transaction;


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $transactions = Transactions::where('id', $id)->get();

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
