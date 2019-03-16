<?php

namespace App\Http\Controllers;

use App\Model\Plan;
use App\Model\Consumer;
use App\Model\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsumerPaymentController extends ConsumerPageController
{

    public function actionCouponCode(Request $request)
    {
        $couponCode = strip_tags($request->input('couponCode'));
        if ($couponCode == "") {
            \AlertSweet::error(trans('message.emptyField'))->autoclose(5000);
            return back();
        }
        $conId      = Auth::user()->id;
        $couponInfo = Coupon::where('code', $couponCode)->where('use', 0)->get();
        $result     = $this->engine->couponProcess($couponInfo, $conId);
        if ($result == 0) {
            \AlertSweet::error(trans('message.invalidCoupon'))->autoclose(5000);
            return back();
        }
        \AlertSweet::success(trans('message.creditCharged'))->autoclose(5000);
        return back();
    }
}
