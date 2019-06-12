<?php

namespace App\Http\Controllers\API;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Controllers\WalletChangoUtils;
use App\Invites;
use App\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InviteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_ivites = Invites::all();
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
        $message = "";
        $validator = Validator::make($request->all(), [
            'phone_no' => 'required',
            'invite_type' => 'required',
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
        $code = " ";
        /*
         * inite to a group
         */
        if ($request->invite_type = 0) {
            $validator = Validator::make($request->all(), [
                'group_id' => 'required',]);
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
            $code = "GR";
        }    /*
         * inite to a project
         */
        if ($request->invite_type = 1) {
            $validator = Validator::make($request->all(), [
                'project_id' => 'required',]);
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
            $code = "PR";

        }
        $check_token = (new WalletChangoUtils())->authenticate_jwt_auth();
        $invite_by = $check_token['data']['id'];

        //generate invite code
        $invite_code = (new WalletChangoUtils())->generateRandomString();
        $phone_no = convert_phone_to_kenyan_format($request->phone_no);

        //check user exist
        $user = \App\User::where('phone_no', $request->phone_no)->first();
        if (isset($user) && $user != "" && !is_null($user)) {
            $user_id = $user->id;
        } else {
            $message .= " You are not registered to WalletChango. Please register";
        }

        // fill the rest of the message
        if (isset($request->project_id)) {
            $project = Projects::find($request->project_id);
            $message .= " You have been invited by " . $check_token['data']['name'] . " to project " .
                $project->project_name . " use code " . $code . $invite_code . " to join";

        }
        if (isset($request->group_id)) {
            $group = Group::find($request->project_id);
            $message .= " You have been invited by " . $check_token['data']['name'] . " to group " .
                $group->group_name . " use code " . $code . $invite_code . " to join";

        }


        $send_sms = (new WalletChangoUtils())->send_sms($phone_no . "0", $message)[0];
        if ($send_sms->status == "success") {
            $response = api_response(true, null, 0, "success",
                "send invite successfully", null);
        } else {
            $response = api_response(true, null, 1, "success",
                $send_sms->status, null);
        }
        if ($response["status_code"] == 0) {
            $invite = new Invites();
            if (isset($user_id) && $user_id != "")
                $invite->user_id = $user_id;
            $invite->phone_no = $phone_no;
            $invite->invite_by = $invite_by;
            $invite->invite_type = $request->invite_type;
            $invite->invite_code = $code . $invite_code;
            if (isset($request->project_id)) {
                $invite->project_id = $request->project_id;
            }
            if (isset($request->project_id)) {
                $invite->group_id = $request->group_id;
            }
            $invite->invite_status = 0;
            $invite->save();
        } else {
            return $response;
        }
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
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
    public
    function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }
}
