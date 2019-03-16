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
use Illuminate\Http\Request;
use App\Engine\EngineClass;
use App\Engine\AdminEngine;
use App\Http\Controllers\AdminController;

class AdminUserController extends AdminMenuController
{


    public function viewCreateUser()
    {
        if ($this->isLogin() == 0) {
            return redirect("/admin");
        }
        $plan = Plan::all();
        return view('index')->with('part', 'ADMIN')->with('pageName', 'CREATEUSER')
                        ->with('title', "FitCard Admin")
                        ->with('plans', $plan);
    }
    private function isLogin()
    {
        $conId = \Session::get('user');
        if ($conId == "" || $conId == null) {
            return 0;
        }
        return 1;
    }

    public function actionCreateUser(Request $request)
    {
        $name      = strip_tags($request->input('userName'));
        $email     = strip_tags($request->input('userEmail'));
        $password  = strip_tags($request->input('userPassword'));
        $plan      = strip_tags($request->input('userPlan'));
        $startDate = strip_tags($request->input('startDate'));
        $endDate   = strip_tags($request->input('endDate'));
        $now       = new \DateTime();
        $now->setTimezone(new \DateTimeZone('Europe/Helsinki'));
        $currentDate   = $now->format('Y-m-d');
        $consumerInfos = Consumer::where('email', $email)->get();
        if (count($consumerInfos) > 0) {
            \AlertSweet::error(trans("message.accountDuplicate"))->autoclose(5000);
            return back();
        }
        Consumer::insert(
            [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'plan' => $plan,
                'invoice_start' => $startDate,
                'invoice_end' => $endDate,
                'registerdate' => $currentDate,
                'memberdate' => $currentDate
            ]
        );
        $emailContent = "Username :" . $email . " <br><br> Password: " . $password .
                "<br><br>" . "Invoice Start: " . $startDate . "<br><br>" . "Invoice End: " .
                $endDate;
        $this->engine->setEmail($email, trans('message.yourAccount'), $emailContent);
        \AlertSweet::success(trans('message.userCreated'))->autoclose(3000);
        return redirect('/admin/users');
    }

    public function viewUsers()
    {
        if ($this->isLogin() == 0) {
            return redirect("/admin");
        }
        $users = Consumer::orderBy('id', 'desc')->get();
        $plan  = Plan::all();
        return view('index')->with('part', 'ADMIN')->with('pageName', 'USERS')
            ->with('title', "FitCard Admin")
            ->with('plans', $plan)
            ->with('users', $users);
    }

    public function viewEditUser($uid)
    {
        if ($this->isLogin() == 0) {
            return redirect("/admin");
        }
        $userInfo  = Consumer::where('id', $uid)->first();
        $bookgyms  = BookGym::with('gym')->where('visitor_id', $uid)->get();
        $bookclass = Book::with('classModel')->where('visitor_id', $uid)->get();
        $plan      = Plan::all();
        return view('index')->with('part', 'ADMIN')->with('pageName', 'USEREDIT')
                ->with('title', "FitCard Admin")->with('userInfo', $userInfo)
                ->with('plans', $plan)
                ->with('bookgyms', $bookgyms)->with('bookclass', $bookclass);
    }

    public function viewCreateCompany()
    {
        if ($this->isLogin() == 0) {
            return redirect("/admin");
        }
        return view('index')->with('part', 'ADMIN')->with('pageName', 'CREATECOMPANY')
            ->with('title', "FitCard Admin");
    }

    public function viewEditCompany($cid)
    {
        if ($this->isLogin() == 0) {
            return redirect("/admin");
        }
        $companyInfo = Company::where('id', $cid)->first();
        return view('index')->with('part', 'ADMIN')->with('pageName', 'EDITCOMPANY')
            ->with('title', "FitCard Admin")->with('companyInfo', $companyInfo);
    }
    public function getParamterCompany(Request $request)
    {
        $companyPassword = strip_tags($request->input('company_password'));
        $companyLocation = strip_tags($request->input('company_location'));
        $city            = strip_tags($request->input('company_city'));
        $lat             = strip_tags($request->input('company_lat'));
        $lng             = strip_tags($request->input('company_lng'));
        $zip             = strip_tags($request->input('company_zip'));
        $email           = strip_tags($request->input('company_email'));
        $phone           = strip_tags($request->input('company_phone'));
        $vat             = strip_tags($request->input('company_vat'));
        $bank            = strip_tags($request->input('company_bank'));
        $image           = strip_tags($request->input('company_image'));
        $companyCountry  = strip_tags($request->input('company_country'));
        $description     = strip_tags($request->input('company_description'));

        $result['password']        = $companyPassword;
        $result['companyLocation'] = $companyLocation;
        $result['city']            = $city;
        $result['lat']             = $lat;
        $result['lng']             = $lng;
        $result['zip']             = $zip;
        $result['email']           = $email;
        $result['phone']           = $phone;
        $result['vat']             = $vat;
        $result['bank']            = $bank;
        $result['image']           = $image;
        $result['companyCountry']  = $companyCountry;
        $result['description']     = $description;
        return $result;
    }
    public function actionCreateCompany(Request $request)
    {
        $companyName    = strip_tags($request->input('company_name'));
        $companyOwner   = strip_tags($request->input('company_owner'));
        $companyAccount = strip_tags($request->input('company_account'));
        $result         = $this->getParamterCompany($request);
        $companyInfos   = Company::where('account', $companyAccount)->get();
        if (count($companyInfos) > 0) {
            return redirect('/admin/createcompany');
        }
        $company          = new Company();
        $company->name    = $companyName;
        $company->owner   = $companyOwner;
        $company->account = $companyAccount;
        $this->saveCompany($result, $company);
        \AlertSweet::success(trans('message.companyCreated'))->autoclose(3000);
        return redirect('/admin/company');
    }
    private function saveCompany($result, $company)
    {
        $company->password    = $result['password'];
        $company->location    = $result['companyLocation'];
        $company->city        = $result['city']   ;
        $company->lat         = $result['lat'];
        $company->lng         = $result['lng']  ;
        $company->zipcode     = $result['zip'];
        $company->email       = $result['email'] ;
        $company->phone       = $result['phone']  ;
        $company->vat         = $result['vat'] ;
        $company->bank        = $result['bank'] ;
        $company->image       = $result['image']  ;
        $company->description = $result['description'];
        $company->country     = $result['companyCountry'];
        $company->save();
    }
    public function actionEditCompany(Request $request)
    {
        $companyNo    = strip_tags($request->input('cmopany_no'));
        $companyName  = strip_tags($request->input('company_name'));
        $companyOwner = strip_tags($request->input('company_owner'));

        $result = $this->getParamterCompany($request);

        $company        = Company::where('id', $companyNo)->first();
        $company->id    = $companyNo;
        $company->name  = $companyName;
        $company->owner = $companyOwner;
        $this->saveCompany($result, $company);
        \AlertSweet::success(trans('message.companyUpdated'))->autoclose(3000);
        return redirect('/admin/company');
    }

    public function actionDeleteCompany($cid)
    {
        Company::deleteCompany($cid);
        \AlertSweet::success(trans('message.companyDeleted'))->autoclose(3000);
        return redirect('/admin/company');
    }

    public function actionUpdateUser(Request $request)
    {
        $userNo      = strip_tags($request->input('user_id'));
        $userPhone   = strip_tags($request->input('user_phone'));
        $userAddress = strip_tags($request->input('user_address'));
        $userPlan    = strip_tags($request->input('user_plan'));

        Consumer::where('id', $userNo)->update(
            [
                'phone' => $userPhone, 'address' => $userAddress, 'plan' => $userPlan
            ]
        );
        \AlertSweet::success(trans('message.userUpdated'))->autoclose(3000);
        return redirect('/admin/users');
    }
}
