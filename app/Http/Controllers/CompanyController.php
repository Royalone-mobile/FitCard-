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
use Illuminate\Http\Request;
use App\Engine\EngineClass;
use App\Engine\AdminEngine;

class CompanyController extends Controller
{

    public $engine;

    public function __construct()
    {
        $this->middleware('guest');
        $this->engine = new AdminEngine();
        $lang         = \Session::get('language');
        \App::setLocale('en');
        $this->engine->changeLanguage($lang);
    }

    public function actionLogout()
    {
        \Session::put('user', "");
        \Session::put('role', "");
        return redirect('/company');
    }

    public function index()
    {
        $userRole = \Session::get('role');
        if ($userRole == "company") {
            return redirect('company/visitors');
        }
        return view('login_company');
    }

    public function login(Request $request)
    {
        $user = strip_tags($request->input('username'));
        $pass = strip_tags($request->input('pw'));
        if ($user == "") {
            return redirect('company');
        }
        if ($pass == "") {
            return redirect('company');
        }
        $userInfos = Company::where('email', $user)->where('password', $pass)->get();
        if (count($userInfos) > 0) {
            \AlertSweet::success(trans('message.loginOk'))->autoclose(3000);
            \Session::put('user', $userInfos[0]->email);
            \Session::put('ano', $userInfos[0]->id);
            \Session::put('role', "company");
            return redirect('company/visitors');
        }
        return redirect('company');
    }

    private function isLogin()
    {
        $userRole = \Session::get('role');
        if ($userRole == "company") {
            return true;
        }
        return false;
    }
    private function viewDashboard($accountNo, $gymInfos)
    {
        $countVisits = 0;
        foreach ($gymInfos as $gymInfo) {
            $countVisits = $countVisits + count($gymInfo->bookgym);
        }
        $classInfos          = Gym::with('classes', 'classes.book')->where('company', $accountNo)->get();
        $iIndex              = 0;
        $classCount[$iIndex] = 0;
        foreach ($classInfos as $classInfo) {
            foreach ($classInfo->classes as $cls) {
                $classCount[$iIndex] = $classCount[$iIndex] + count($cls->book);
            }
        }
        $countReview    = Company::countReviewsCompany($accountNo);
        $amountPayment1 = 5 * $countVisits + 5 * $classCount[0];
        $currentDay     = date('D');
        $staticstart    = new \DateTime();
        $staticfinish   = new \DateTime($currentDay !== 'Sat' ? 'next Saturday' : null);

        $classes = ClassModel::with(['gymInfo' => function ($query) {
                      $query->where('company', \Session::get('ano'));
        }])
              ->whereBetween('class.date', [$staticstart->format('Y-m-d'), $staticfinish->format('Y-m-d')])
              ->get();

              $result                  = [];
              $result['countReview']   = $countReview;
              $result['amountPayment'] = $amountPayment1;
              $result['staticstart']   = $staticstart;
              $result['classes']       = $classes;
              $result['countVisits']   = $countVisits;
              $result['classCount']    = $classCount;
            return $result;
    }
    
    public function viewVisitors()
    {
        if (!$this->isLogin()) {
            return redirect('company');
        }
        $accountNo = \Session::get('ano');
        $gymInfos  = Gym::with('bookgym')->where('gym.company', $accountNo)->get();

        $result = $this->viewDashboard($accountNo, $gymInfos);


        $gyms     = Gym::with('reviewsGym')->where('gym.company', $accountNo)->get();
        $city     = City::all();
        $rat      = 0;
        $countGym = count($gyms);
        $k        = 0;
        if (count($gyms) > 0) {
            for ($i = 0; $i < $countGym; $i++) {
                $countBook = count($gyms[$i]->reviewsGym);
                for ($j = 0; $j < $countBook; $j++) {
                    $k++;
                    $rat = $rat + $gyms[$i]->reviewsGym[$j]->star;
                }
            }
            if ($k > 0) {
                $rat = (float) $rat / $k;
            }
        }
        $rat          = number_format((float) $rat, 2, '.', '');
        $countBook    = [];
        $countClasses = count($result['classes']);
        for ($iIndex = 0; $iIndex < $countClasses; $iIndex++) {
            $books              = Book::where('class_id', $result['classes'][$iIndex]->id)->get();
            $countBook[$iIndex] = count($books);
        }
        $currentDay   = date('D');
        $staticfinish = new \DateTime($currentDay !== 'Sat' ? 'next Saturday' : null);
        $bookVisits   = BookGym::with('consumer', 'gym')
        ->whereBetween('date', [$result['staticstart']->format('Y-m-d'), $staticfinish->format('Y-m-d')])
        //->where('date', 'like', '%' . $result['staticstart']->format('Y-m-d') . '%')
                        ->orderby('date', 'desc')
                        ->whereHas('gym', function ($q) {
                            $q->where('company', \Session::get('ano'));
                        })->get();
        return view('index')->with('part', 'COMPANY')->with('pageName', 'VISITORS')
            ->with('title', "FitCard Company")->with('countVisit', $result['countVisits'] + $result['classCount'][0])
            ->with('countReview', $result['countReview'])
            ->with('amountPayment', $result['amountPayment'])
            ->with('averageRating', $rat)
            ->with('cityInfos', $city)
            ->with('graphs', "")
            ->with('visitGraphs', "")
            ->with('revGraphs', "")
            ->with('bookVisits', $bookVisits)
            ->with('classes', $result['classes'])
            ->with('countBook', $countBook);
    }


    public function viewHours()
    {
        return view('index')->with('part', 'COMPANY')->with('pageName', 'HOURS')
            ->with('title', "FitCard Company");
    }

    public function viewPayments()
    {
        if (!$this->isLogin()) {
            return redirect('company');
        }
        $accountNo           = \Session::get('ano');
        $gymCount            = [];
        $classCount          = [];
        $iIndex              = 0;
        $gymInfos            = Gym::with('bookgym')->where('gym.company', $accountNo)->get();
        $classInfos          = Gym::with('classes', 'classes.book')->where('company', $accountNo)->get();
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
        $accountNo   = \Session::get('ano');
        $gymInfos    = Gym::with('bookgym')->where('gym.company', $accountNo)->get();
        $countVisits = 0;
        foreach ($gymInfos as $gymInfo) {
            $countVisits = $countVisits + count($gymInfo->bookgym);
        }
        $gymCount[0] = $countVisits;
        return view('index')->with('part', 'COMPANY')->with('pageName', 'PAYMENTS')
            ->with('title', "FitCard Company")
            ->with('gymVisits', $gymCount)
            ->with('classCounts', $classCount);
    }

    public function viewReviews()
    {
        if (!$this->isLogin()) {
            return redirect('company');
        }
        $reviewInfos = Review::with('consumer')->with(['gym' => function ($query) {
                        $query->where('company', \Session::get('ano'));
        }])->get();
        return view('index')->with('part', 'COMPANY')->with('pageName', 'REVIEWS')
            ->with('title', "FitCard Admin")->with('reviews', $reviewInfos);
    }

    public function viewProfile()
    {
        $accountNo   = \Session::get('ano');
        $companyInfo = Company::where('id', $accountNo)->first();
        return view('index')->with('part', 'COMPANY')->with('pageName', 'PROFILE')
                        ->with('title', "FitCard Admin")->with('companyInfo', $companyInfo);
    }


    public function actionEditProfile(Request $request)
    {

        $companyNo       = strip_tags($request->input('cmopany_no'));
        $companyName     = strip_tags($request->input('company_name'));
        $companyOwner    = strip_tags($request->input('company_owner'));
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
        $description     = strip_tags($request->input('company_description'));


        Company::where('id', $companyNo)->update(
            [
                'name' => $companyName
                , 'owner' => $companyOwner
                , 'password' => $companyPassword
                , 'location' => $companyLocation
                , 'city' => $city
                , 'lat' => $lat
                , 'lng' => $lng
                , 'zipcode' => $zip
                , 'email' => $email
                , 'phone' => $phone
                , 'vat' => $vat
                , 'bank' => $bank
                , 'image' => $image
                , 'description' => $description
            ]
        );
        \AlertSweet::success(trans('message.profileUpdated'))->autoclose(3000);
        return redirect('/company/viewProfile');
    }
}
