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
use App\Model\Business;
use Illuminate\Http\Request;
use App\Engine\EngineClass;
use App\Engine\AdminEngine;
use App\Http\Controllers\AdminController;

class AdminMenuController extends AdminController
{

    public $engine;

    public function __construct()
    {
        $this->engine = new AdminEngine();
        $lang         = \Session::get('language');
        \App::setLocale('en');
        $this->engine->changeLanguage($lang);
    }
    public function index()
    {
        $userRole  = \Session::get('role');
        $adminUser = new Admin();
        if ($userRole == "admin") {
            return redirect('admin/dashboard');
        }
        return view('login_admin')->with('admin', $adminUser);
    }

    private function isLogin()
    {
        $conId = \Session::get('user');
        if ($conId == "" || $conId == null) {
            return 0;
        }
        return 1;
    }

    public function viewDashboard()
    {
        if ($this->isLogin() == 0) {
            return redirect("/admin");
        }
        $countVisits   = Book::allVisitCount() + count(BookGym::all());
        $countReview   = Review::countReviews();
        $amountPayment = $countVisits * 5;
        $rat           = Gym::averageRate();
        $rat           = number_format((float) $rat, 2, '.', '');
        $graphData     = [];
        for ($iIndex = -29; $iIndex < 1; $iIndex++) {
            $date1              = new \DateTime($iIndex . ' days');
            $users              = Consumer::where('registerdate', $date1->format('Y-m-d'))->get();
            $graphData[$iIndex] = count($users);
        }
        $graphg     = $this->engine->setJavascriptArray($graphData);
        $graphVisit = [];
        for ($iIndex = -29; $iIndex < 1; $iIndex++) {
            $date1               = new \DateTime($iIndex . ' days');
            $visit1              = Book::where('date', $date1->format('Y-m-d'))->get();
            $visit2              = BookGym::where('date', $date1->format('Y-m-d'))->get();
            $graphVisit[$iIndex] = count($visit1) + count($visit2);
        }
        $graphv = $this->engine->setJavascriptArray($graphVisit);

        $graphRevenue = [];
        for ($iIndex = -29; $iIndex < 1; $iIndex++) {
            $date1   = new \DateTime($iIndex . ' days');
            $visit1  = Payment::with('plan')->where('date', 'like', $date1->format('Y-m-d') . '%')->get();
            $sum     = 0;
            $countV1 = count($visit1);
            for ($kIndex = 0; $kIndex < $countV1; $kIndex++) {
                $sum += $visit1[$kIndex]->plan->price;
            }
            $graphRevenue[$iIndex] = $sum;
        }
        $graphr = $this->engine->setJavascriptArray($graphRevenue);
        return view('index')->with('part', 'ADMIN')->with('pageName', 'DASHBOARD')
            ->with('title', "FitCard Admin")->with('countVisit', $countVisits)
            ->with('countReview', $countReview)
            ->with('amountPayment', $amountPayment)
            ->with('graphs', $graphg)
            ->with('visitGraphs', $graphv)
            ->with('revGraphs', $graphr)
            ->with('averageRating', $rat);
    }

    public function viewCompany()
    {
        $companyInfos = Company::all();
        return view('index')->with('part', 'ADMIN')->with('pageName', 'COMPANY')
            ->with('title', "FitCard Admin")->with('companyInfos', $companyInfos);
    }

    public function viewReviews()
    {
        $reviewInfos = Review::getAllReviewInfos();
        return view('index')->with('part', 'ADMIN')->with('pageName', 'REVIEWS')
                        ->with('title', "FitCard Admin")->with('reviews', $reviewInfos);
    }
    public function viewBusiness()
    {
        $businessInfos = Business::with('consumer')->get();
        return view('index')->with('part', 'ADMIN')->with('pageName', 'BUSINESS')
                      ->with('title', "FitCard Admin")->with('business', $businessInfos);
    }
    public function actionCreateBusiness(Request $request)
    {
        $name     = $request->input('userName');
        $email    = $request->input('userEmail');
        $password = $request->input('userPassword');
        $business = Business::where('email', $email)->count();
        if ($business > 0) {
            \AlertSweet::success(trans('web.duplicateBusiness'))->autoclose(3000);
            return back();
        }
        Business::insert(
            [
                'name' => $name,
                'email' => $email,
                'password' => $password
            ]
        );
        \AlertSweet::success(trans('web.successCreateBusiness'))->autoclose(3000);
        return redirect('/admin/business');
    }
    public function actionDeleteBusiness($id)
    {
        Business::where('id', $id)->delete();
        return redirect('/admin/business');
    }
    public function viewLocationManage()
    {
        $data = Location::all();
        return view('index')->with('part', 'ADMIN')->with('pageName', 'LOCATION')
            ->with('title', "FitCard Admin")
            ->with('data', $data);
    }
    public function viewActivityManage()
    {
        $data = Activity::all();
        return view('index')->with('part', 'ADMIN')->with('pageName', 'ACTIVITY')
            ->with('title', "FitCard Admin")
            ->with('data', $data);
    }

    public function viewStudioManage()
    {
        $data = Studio::all();
        return view('index')->with('part', 'ADMIN')->with('pageName', 'STUDIO')
            ->with('title', "FitCard Admin")
            ->with('data', $data);
    }

    public function viewAmenityManage()
    {
        $data = Amenity::all();
        return view('index')->with('part', 'ADMIN')->with('pageName', 'AMENTITY')
            ->with('title', "FitCard Admin")
            ->with('data', $data);
    }

    public function viewCityManage()
    {
        $data = City::all();
        return view('index')->with('part', 'ADMIN')->with('pageName', 'CITY')
            ->with('title', "FitCard Admin")->with('data', $data);
    }
}
