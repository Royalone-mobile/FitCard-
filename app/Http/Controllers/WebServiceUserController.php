<?php

namespace App\Http\Controllers;

use App\Model\Admin;
use App\Model\Gym;
use App\Model\ClassModel;
use App\Model\Company;
use App\Model\Book;
use App\Model\Review;
use App\Model\Plan;
use App\Model\Category;
use App\Model\Activity;
use App\Model\Studio;
use App\Model\Location;
use App\Model\BookGym;
use App\Model\Consumer;
use App\Model\Amenity;
use App\Model\CategoryClass;
use App\Model\City;
use App\Model\GymActivity;
use App\Model\GymAmenity;
use App\Model\GymCategory;
use App\Model\GymLocation;
use App\Model\GymStudio;
use App\Model\Payment;
use App\Model\Coupon;
use App\Engine\EngineClass;
use App\Engine\ServiceEngine;
use Illuminate\Http\Request;

class WebServiceUserController extends WebServiceClassController
{

    private $engine;

    public function __construct()
    {
        $this->middleware('guest');
        $this->engine = new ServiceEngine();
    }

    public function serviceChargeWithToken($id, $pid)
    {
        $this->engine->getChargeFromToken($id, $pid);

        return response()->json(
            [
                "result" => 0
            ]
        );
    }
    public function serviceProfile($id)
    {
        $userInfos = Consumer::where('id', $id)->first();
        return response()->json(
            [
              "user" => $userInfos
            ]
        );
    }
    public function serviceCleanCard($id)
    {
        Consumer::where('id', $id)->update(
            [
                'card_token' => ''
            ]
        );

        return response()->json(
            [
                "result" => 0
            ]
        );
    }

    public function serviceCouponCode($couponCode, $consumerId)
    {
        $couponInfo = Coupon::where('code', $couponCode)->where('use', 0)->get();
        $result     = $this->engine->couponProcess($couponInfo, $consumerId);
        if ($result == 0) {
            return response()->json(
                [
                    "result" => 0
                ]
            );
        }

        return response()->json(
            [
                "result" => 1,
                "credit" => $couponInfo[0]->credit
            ]
        );
    }

    public function serviceLogin($user, $password)
    {
        $userInfos = Consumer::where('email', $user)->where('password', $password)->first();
        if (count($userInfos) > 0) {
            if ($userInfos->plan != 4) {
                $this->engine->getCheckChargeMembership($userInfos);
            }
        }

        return response()->json(
            [
                "user" => $userInfos
            ]
        );
    }

    public function serviceContactUs(Reqeust $request)
    {
        $message = strip_tags($request->input('message'));
        $this->engine->setEmail("info@fitcard.fi", "Contact From User", $message);
    }

    public function serviceRegister(Request $request)
    {
        $user     = strip_tags($request->input('user'));
        $password = strip_tags($request->input('password'));
        $email    = strip_tags($request->input('email'));
        $result   = $this->engine->getRegisterConsumer($user, $password, $email);
        if ($result == "fail") {
            return response()->json(
                [
                    "result" => "fail"
                ]
            );
        }

        return response()->json(
            [
                "result" => "success",
                "id"     => $result
            ]
        );
    }

    public function serviceChargeFund($amount)
    {
        $response = $this->engine->setRequestCharge($amount);
        if ($response != "") {
            return response()->json(
                [
                    "token"       => $response->token,
                    "payment_url" => \Paybyway\Paybyway::API_URL . "/charge",
                    "currency"    => "EUR",
                    "amount"      => $amount
                ]
            );
        }

        return "";
    }

    public function serviceFundCheck($token)
    {
        $chargeResult = $this->engine->fundCheck($token);

        return response()->json($chargeResult);
    }

    public function serviceAfterPayment($consumerId, $pid, $token)
    {
        $this->engine->setUpdateUserCredit($consumerId, $pid, $token);

        return response()->json(["result" => "1"]);
    }

    public function updateProfile($consumerId, $email, $phone, $city, $address, Request $request)
    {
        $image   = strip_tags($request->input('image'));
        $city    = strip_tags($request->input('city'));
        $address = strip_tags($request->input('address'));
        $phone   = strip_tags($request->input('phone'));
        $email   = strip_tags($request->input('name'));
        Consumer::where('id', $consumerId)->update(
            [
                'phone'     => $phone
                , 'name'    => $email
                , 'city'    => $city
                , 'image'   => $image
                , 'address' => $address
            ]
        );

        return response()->json(["result" => "1"]);
    }

    public function serviceUploadLogo(Request $request)
    {
        $file          = $request->file('uploaded_file');//$_FILES['uploaded_file'];
        $nName         = $file->getClientOriginalName();
        $nName         = pathinfo($nName, PATHINFO_FILENAME); // file
        $thumbFilename = $this->engine->setUploadFile($file, $nName, "/uploads/consumer/");

        return response()->json(["path" => $thumbFilename]);
    }

    public function serviceGetCode(Request $request)
    {
        $email  = $request->input('email');
        $result = Consumer::where('email', $email)->get();
        $code   = "0000";
        if (count($result) > 0) {
            $code = rand(1000, 9999);
            $this->engine->setEmail($email, "Verification Code", $code);
        }

        return response()->json(["code" => $code]);
    }

    public function serviceUpdatePassword(Request $request)
    {
        $email    = $request->input('email');
        $password = $request->input('password');
        Consumer::where('email', $email)->update(
            [
                'password' => $password
            ]
        );

        return response()->json(["result" => "success"]);
    }
}
