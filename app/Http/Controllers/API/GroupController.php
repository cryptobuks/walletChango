<?php

namespace App\Http\Controllers\API;

use App\Group;
use App\GroupMembership;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::get();
        foreach ($groups as $group) {
            $group_members = GroupMembership::where('group_id', $group->id)->get();
            $update_members = Group::find($group->id);
            $update_members->members_count = count($group_members);
            $update_members->save();
        }
        return $groups;
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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'group_name' => 'required',
            'members_count' => 'required|integer|max:191',
        ]);
        $new_group = new Group();
        $new_group->group_name = $request->all()['group_name'];
        $new_group->members_count = $request->all()['members_count'];
        $new_group->group_uuid = $request->all()['group_uuid'];
        $new_group->save();
        return response(Group::all());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $groups = Group::where('id', $id)->first();
        $groups->append(['group_payments_total','group_members','group_payments'])->toArray();
        return $groups;
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
