<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\WalletChangoUtils;
use App\Projects;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $projects = Projects::with('user', 'group', 'payments')->get()->take(15);
        return $projects;
    }

    public function chart_payments($id)
    {
        $projects = Projects::with(['payments', 'user', 'group'])->where('id', $id)->get();
        $month_array = array();

        $_01_month = array();
        $_01_month['month'] = "January";
        $amount_01 = 0;

        $_02_month['month'] = "February";
        $amount_02 = 0;

        $_03_month['month'] = "March";
        $amount_03 = 0;

        $_04_month['month'] = "April";
        $amount_04 = 0;

        $_05_month['month'] = "May";
        $amount_05 = 0;


        $_06_month['month'] = "June";
        $amount_06 = 0;

        $_07_month['month'] = "July";
        $amount_07 = 0;

        $_08_month['month'] = "August";
        $amount_08 = 0;

        $_09_month['month'] = "September";
        $amount_09 = 0;

        $_10_month['month'] = "October";
        $amount_10 = 0;

        $_11_month['month'] = "November";
        $amount_11 = 0;

        $_12_month['month'] = "December";
        $amount_12 = 0;

        foreach ($projects as $project) {
            $payments = $project->payments;
            foreach ($payments as $date_payment) {
                $month = date('m', strtotime($date_payment->created_at));
                if ($month == '01') {
                    $amount_01 += $date_payment->payment_amount;
                }
                if ($month == '02') {
                    $amount_02 += $date_payment->payment_amount;
                }
                if ($month == '03') {
                    $amount_03 += $date_payment->payment_amount;
                }
                if ($month == '04') {
                    $amount_04 += $date_payment->payment_amount;
                }
                if ($month == '05') {
                    $amount_05 += $date_payment->payment_amount;
                }
                if ($month == '06') {
                    $amount_06 += $date_payment->payment_amount;
                }
                if ($month == '07') {
                    $amount_07 += $date_payment->payment_amount;
                }
                if ($month == '08') {
                    $amount_08 += $date_payment->payment_amount;
                }
                if ($month == '09') {
                    $amount_09 += $date_payment->payment_amount;
                }
                if ($month == '10') {
                    $amount_10 += $date_payment->payment_amount;
                }
                if ($month == '11') {
                    $amount_11 += $date_payment->payment_amount;
                }
                if ($month == '12') {
                    $amount_12 += $date_payment->payment_amount;
                }
            }
        }
        $_01_month['payment_amount'] = $amount_01;
        $_02_month['payment_amount'] = $amount_02;
        $_03_month['payment_amount'] = $amount_03;
        $_04_month['payment_amount'] = $amount_04;
        $_05_month['payment_amount'] = $amount_05;
        $_06_month['payment_amount'] = $amount_06;
        $_07_month['payment_amount'] = $amount_07;
        $_08_month['payment_amount'] = $amount_08;
        $_09_month['payment_amount'] = $amount_09;
        $_10_month['payment_amount'] = $amount_10;
        $_11_month['payment_amount'] = $amount_11;
        $_12_month['payment_amount'] = $amount_12;
        array_push($month_array, $_01_month);
        array_push($month_array, $_02_month);
        array_push($month_array, $_03_month);
        array_push($month_array, $_04_month);
        array_push($month_array, $_05_month);
        array_push($month_array, $_06_month);
        array_push($month_array, $_07_month);
        array_push($month_array, $_08_month);
        array_push($month_array, $_09_month);
        array_push($month_array, $_10_month);
        array_push($month_array, $_11_month);
        array_push($month_array, $_12_month);
        return $month_array;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        if (isset($request->token)) {
            $request->headers->set('Authorization', "Bearer " . $request->token);
        }
        $check_token = (new WalletChangoUtils())->authenticate_jwt_auth();
        if ($check_token["success"] == true) {
            $user_id = $check_token['data']['id'];
            $validator = Validator::make($request->all(), [
                'project_name' => 'required',
                'project_description' => 'required',
                'project_details' => 'required',
                'target_group_number' => 'required|integer|max:20',
                'project_target_amount' => 'required|integer|max:10000'
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
            $new_project = new Projects();
            $new_project->project_name = $request->project_name;
            $new_project->project_description = $request->project_description;
            $new_project->project_details = $request->project_details;
            $new_project->target_group_number = $request->target_group_numbert;
            $new_project->project_target_amount = $request->project_target_amount;
            $new_project->project_initiated_by = $user_id;
            $new_project->save();
            return response(Projects::all());
        } else {
            return $check_token;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id, Request $request = null)
    {
        $projects = Projects::with('user', 'payments')->where('id', $id)->first();

        if (isset($request->token)) {
            $request->headers->set('Authorization', "Bearer " . $request->token);
        }
        $check_token = (new WalletChangoUtils())->authenticate_jwt_auth();
        $group_member_ship = \App\ProjectMembership::where('user_id', $check_token['data']['id'])->where('group_id', $id)->get();

        if (count($group_member_ship) > 0) {
            $projects["member"] = true;
        } else {
            $projects["member"] = false;
        }
        $projects->append('project_members')->toArray();
        return $projects;

//        return Projects::with('user')->join('tbl_payments', 'tbl_projects.id', '=', 'tbl_payments.project_id')
//            ->where('tbl_projects.id', $id)->get();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
