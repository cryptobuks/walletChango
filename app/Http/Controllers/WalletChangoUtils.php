<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class WalletChangoUtils extends Controller
{
    public function authenticate_jwt_auth()
    {

        try {
            JWTAuth::parseToken()->authenticate();

            $user = Auth::user();
            $error = null;
            $success = true;
            $status_code = 0;
            $status_msg = "success";
            $data = $user;
            $msg = "successfully retrieved token";
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            $error = "token expired";
            $success = false;
            $status_code = 1;
            $status_msg = "token expired";
            $data = null;
            $msg = "token expired ";
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            $error = "Invalid Token";
            $success = false;
            $status_code = 1;
            $status_msg = "Invalid token";
            $data = null;
            $msg = "Invalid token ";
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            $error = "Incorrect Token";
            $success = false;
            $status_code = 1;
            $status_msg = "Incorrect token";
            $data = null;
            $msg = "Incorrect token ";
        }
        return api_response(
            $success,
            $error,
            $status_code,
            $status_msg,
            $msg,
            $data
        );
    }

}
