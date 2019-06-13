<?php

namespace App\Http\Controllers;


use App\MpesaCall;
use App\Transactions;
use App\UserSmsDelivery;
use App\Wallet;
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

    //C2B Functions ############################################### START
    //Lipa na M-Pesa Online Payment - Resource URL
    public function stkPush($phone_number, $amount, $user_id) //From AJAX call/android side, etc....start USSD pay request
    {


        //remove 07 for those that come with it
        if ($this->startsWith($phone_number, "07")) {
            $pos = strpos($phone_number, "07");
            if ($pos !== false) {
                $phone_number = substr_replace($phone_number, "254", $pos, 2);
            }
        }
        if ($this->startsWith($phone_number, "+")) {
            $pos = strpos($phone_number, "+");
            if ($pos !== false) {
                $phone_number = substr_replace($phone_number, "", $pos, 1);
            }
        }
        //Validate the inputs
        if ($amount === "" || $phone_number === "" || !$this->startsWith($phone_number, "2547") ||
            $amount < 1 || $amount > 70000 ||
            filter_var($amount, FILTER_VALIDATE_INT) === false) {
            return json_encode(["success" => 0, "message" => "Wrong input"]);
        }

        //Variables specific to this application
        $merchant_id = "413392"; //C2B Shortcode/Paybill
        $callback_url = "https://mykenyaconstitution.com/api/v1/mpesa/c2b/callback";
        $passkey = "a91018f1edf681187fc7600c13e5def2ec7b849545717fe71cede4d4cb6a16d6"; //Ask from Safaricom guys..
        $account_reference = $user_id; //like account number while paying via paybill
        $transaction_description = 'Pay for User:' . $user_id;

        //LOG the Request. This is done just to keep a record of the online payment calls you have made
        $call = new MpesaCall();
        $caller = "C2B_Online";
        $content = "Phone: " . $phone_number . " | Amount: " . $amount;
        $call->content = $content;
        $call->caller = $caller;
        $call->save();

        //Initiate PUSH
        $timestamp = date("YmdHis");
        $password = base64_encode($merchant_id . $passkey . $timestamp); //No more Hashing like before. this is a guideline from Saf
        $access_token = $this->getAccessToken();

        $curl = curl_init();
        $endpoint_url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        curl_setopt($curl, CURLOPT_URL, $endpoint_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $access_token)); //setting custom header

        $curl_post_data = array(
            'BusinessShortCode' => $merchant_id,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phone_number,
            'PartyB' => $merchant_id,
            'PhoneNumber' => $phone_number,
            'CallBackURL' => $callback_url,
            'AccountReference' => $account_reference,
            'TransactionDesc' => $transaction_description
        );

        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        $curl_response = curl_exec($curl);
        $result = json_decode($curl_response);

        $wallet = Wallet::where('user_id', $user_id)->first();
        $wallet->wallet_amount = $wallet->wallet_amount + $amount;
        $wallet->save();

        $transactions = new Transactions();
        $transactions->user_id = $user_id;
        $transactions->wallet_id = $wallet->id;
        $transactions->amount = $amount;
        $transactions->reference = $caller;
        //1 is a deposit
        $transactions->transaction_type = 1;
        $transactions->save();

        if (array_key_exists("errorCode", $result)) { //Error
            return json_encode(["success" => 0, "message" => "Request Failed"]);
        } else if (array_key_exists("ResponseCode", $result)) { //Success
            return json_encode(["success" => 1, "message" => "Request Sent Successfully"]);
        } else {
            return json_encode(["success" => 0, "message" => "Unknown Error, Please Retry"]);
        }
    }

    public function getAccessToken()
    {
        //Variables specific to this application
        $consumer_key = "oAAHi95H21d0xtu2EM30bR4fPRL2WFKg"; //Get these two from DARAJA Platform
        $consumer_secret = "6hBxtu1JMn2JU1Mk";

        //START CURL
        $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $credentials = base64_encode($consumer_key . ":" . $consumer_secret);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
        curl_setopt($curl, CURLOPT_HEADER, 0);//Make it not return headers...true retirns header
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//MAGIC..

        $curl_response = curl_exec($curl);
        $access_token = json_decode($curl_response);
        return $access_token->access_token;
    }

    function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }


}
