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
use App\Model\Business;
use App\Model\Payment;
use App\Model\Coupon;
use Illuminate\Http\Request;
use App\Engine\EngineClass;
use App\Engine\AdminEngine;
use App\Http\Controllers\AdminController;

class AdminPaymentController extends AdminMenuController
{
    public function viewInvoice($uid)
    {
        if ($this->isLogin() == 0) {
            return redirect("/admin");
        }
        $business = Business::all();
        $userInfo = Consumer::where('id', $uid)->first();
        return view('index')->with('part', 'ADMIN')->with('pageName', 'INVOICE')
                        ->with('title', "FitCard Admin")
                        ->with('business', $business)
                        ->with('userInfo', $userInfo);
    }
    private function isLogin()
    {
        $conId = \Session::get('user');
        if ($conId == "" || $conId == null) {
            return 0;
        }
        return 1;
    }
    public function actionCreateLocation(Request $request)
    {
        $locationName = strip_tags($request->input('location_name'));
        if ($locationName == "") {
            return back();
        }
        $location       = new Location();
        $location->name = $locationName;
        $location->save();
        \AlertSweet::success(trans('message.locationCreated'))->autoclose(3000);
        return redirect('/admin/locationmanage');
    }
    public function viewCoupon()
    {
        if ($this->isLogin() == 0) {
            return redirect("/admin");
        }
        $coupons = Coupon::all();
        return view('index')->with('part', 'ADMIN')->with('pageName', 'COUPON')
                        ->with('title', "FitCard Admin")
                        ->with('coupons', $coupons);
    }

    public function actionDeleteCoupon($id)
    {
        Coupon::where("id", $id)->delete();
        \AlertSweet::success(trans('message.couponDeleted'))->autoclose(3000);
        return redirect('/admin/viewCoupon');
    }

    public function actionCreateCoupon(Request $request)
    {
        $code   = strip_tags($request->input('coupon_code'));
        $credit = strip_tags($request->input('coupon_credit'));
        if ($code == "" || $credit == "") {
            \AlertSweet::error(trans('message.emptyField'))->autoclose(3000);
            return back();
        }
        $this->engine->setGenerateCouponCode($code, $credit);
        \AlertSweet::success(trans('message.couponCreated'))->autoclose(3000);
        return redirect('/admin/viewCoupon');
    }

    public function actionSetInvoice(Request $request)
    {
        $conId      = strip_tags($request->input('user_no'));
        $startDate  = strip_tags($request->input('startDate'));
        $endDate    = strip_tags($request->input('endDate'));
        $businessId = strip_tags($request->input('business'));
        Consumer::where('id', $conId)->update(
            [
                'invoice_start' => $startDate,
                'invoice_end' => $endDate,
                'business_id' =>$businessId
            ]
        );
        return redirect('/admin/users');
    }



    public function viewPlanManage()
    {
        if ($this->isLogin() == 0) {
            return redirect("/admin");
        }
        $planInfos = Plan::all();
        return view('index')->with('part', 'ADMIN')->with('pageName', 'PLAN')
            ->with('title', "FitCard Admin")->with('planInfos', $planInfos);
    }

    public function actionPlanUpdate(Request $request)
    {
        $planName1   = strip_tags($request->input('planName1'));
        $planName2   = strip_tags($request->input('planName2'));
        $planName3   = strip_tags($request->input('planName3'));
        $planPrice1  = strip_tags($request->input('planPrice1'));
        $planPrice2  = strip_tags($request->input('planPrice2'));
        $planPrice3  = strip_tags($request->input('planPrice3'));
        $planCredit1 = strip_tags($request->input('planCredit1'));
        $planCredit2 = strip_tags($request->input('planCredit2'));
        $planCredit3 = strip_tags($request->input('planCredit3'));


        Plan::savePlan($planName1, $planPrice1, $planCredit1, 1);
        Plan::savePlan($planName2, $planPrice2, $planCredit2, 2);
        Plan::savePlan($planName3, $planPrice3, $planCredit3, 3);

        return redirect('/admin/planmanage');
    }

    public function ajaxMonthPayment(Request $request)
    {
        $company     = Company::all();
        $year        = strip_tags($request->input('year'));
        $month       = strip_tags($request->input('month'));
        $gymVisits   = BookGym::with('gym');
        $classVisits = Book::with('classModel', 'classModel.gymInfo');
        $result      = [];
        $cntCompany  = count($company);
        for ($iIndex = 0; $iIndex < $cntCompany; $iIndex++) {
            $companyInfo = $company[$iIndex];

            $item = $this->engine->getMonthPayment($companyInfo, $year, $month, $gymVisits, $classVisits);

            $result[$iIndex] = $item;
        }
        return $result;
    }

    public function viewPayments()
    {
        if ($this->isLogin() == 0) {
            return redirect("/admin");
        }
        $company    = Company::all();
        $gymCount   = [];
        $classCount = [];
        $iIndex     = 0;
        foreach ($company as $comInfo) {
            $gymInfos            = Gym::with('bookgym')->where('gym.company', $comInfo->id)->get();
            $classInfos          = Gym::with('classes', 'classes.book')->where('company', $comInfo->id)->get();
            $gymCount[$iIndex]   = 0;
            $classCount[$iIndex] = 0;
            foreach ($gymInfos as $gymInfo) {
                $gymCount[$iIndex] = $gymCount[$iIndex] + count($gymInfo->bookgym);
            }
            foreach ($classInfos as $classInfo) {
                foreach ($classInfo->classes as $cls) {
                    $classCount[$iIndex] = $classCount[$iIndex] + count($cls->book);
                }
            }
            $iIndex++;
        }

        return view('index')->with('part', 'ADMIN')->with('pageName', 'PAYMENTS')
            ->with('title', "FitCard Admin")
            ->with('companyInfos', $company)
            ->with('gymVisits', $gymCount)
            ->with('classCounts', $classCount);
    }
}
