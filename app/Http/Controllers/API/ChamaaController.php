<?php

namespace App\Http\Controllers\API;

use App\Chamaa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChamaaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Chamaa::get();
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'chamaa_name' => 'required',
            'members_count' => 'required|integer|max:191',
        ]);
        $new_chamaa = new Chamaa();
        $new_chamaa->chamaa_name = $request->all()['chamaa_name'];
        $new_chamaa->members_count = $request->all()['members_count'];
        $new_chamaa->chamaa_uuid = $request->all()['chamaa_uuid'];
        $new_chamaa->save();
        return response(Chamaa::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
