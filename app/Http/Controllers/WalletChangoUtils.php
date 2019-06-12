<?php

namespace App\Http\Controllers;


use App\UserSmsDelivery;
use Illuminate\Support\Facades\Auth;
use PhpParser\Error;
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

    public
    function send_sms($number, $sms)
    {

        /**
         * authentication credentials
         * */
        $username = "sheriatips";
        $apikey = "f5a16c2ad91ca30f762877537f9d3b3e834085b862fd7fcee1722062466e7cdd";
        /** the numbers that you want to send to in a comma-separated list
         **/


        $gateway = new AfricasTalkingGateway($username, $apikey);


        try {
            /**
             *
             *send Message to recipients
             */
            return $results = $gateway->sendMessage($number, $sms);
            foreach ($results as $result) {
                return $result->statusCode;

//                $sms = new UserSmsDelivery();
//                $sms->phone_number = $result->number;
//                $sms->message_id = $result->messageId;
//                $sms->message = $message;
//                $sms->cost = $result->cost;
//                $sms->status_code = $result->statusCode;
//                $sms->created_at = Carbon::now();
//                $sms->save();
            }

        } catch (Error $e) {
            echo "Encountered an error while sending: " . $e->getMessage();
        }
//            return;

    }

    public function generateRandomString($length = 5)
    {
        $characters = '0123456789ABEDCDEFGHASDVWEF';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
