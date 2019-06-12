<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        Config::set('jwt.user', 'App\User');
        Config::set('auth.providers.users.model', \App\User::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::get();
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


    public function authenticate(Request $request)
    {
        //Validate fields
        $validator = Validator::make($request->all(), ['email' => 'required', 'password' => 'required']);
        if (!$validator->passes()) {
            return api_response(
                false,
                $validator->errors()->all(),
                '1',
                'Failed',
                "Some entries are missing",
                null
            );

        } else {
            //Attempt validation
            $credentials = $request->only(['email', 'password']);

            if (!$token = auth()->attempt($credentials)) {

                return api_response(
                    false,
                    ['error' => 'Incorrect credentials'],
                    1,
                    "Failed",
                    'Your password and user name do no match  ',
                    null
                );
            } else {
                return api_response(
                    true,
                    null,
                    0,
                    "Success",
                    'You have successfully logged in ',
                    ["token" => $token]
                );
            }

        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->get();
        if (count($user) > 0) {
            if (Hash::check($request->password, $user->first()->password)) {
                $walletUser = $user->first();
                $walletUser['status'] = "success";
            } else {
                $walletUser['status'] = "error";
                $walletUser['message'] = "password and email combination is wrong";
            }
        } else {
            $walletUser['status'] = "error";
            $walletUser['message'] = "password and email combination is wrong";

        }
        return $walletUser;

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

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
