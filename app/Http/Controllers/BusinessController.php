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

class BusinessController extends Controller
{

    public $engine;

    public function __construct()
    {
        $this->engine = new AdminEngine();
        $lang         = \Session::get('language');
        \App::setLocale('en');
        $this->engine->changeLanguage($lang);
    }
    public function actionLogin(Request $request)
    {
        $user = strip_tags($request->input('username'));
        $pass = strip_tags($request->input('pw'));
        if ($user == "") {
            return redirect('business');
        }
        if ($pass == "") {
            return redirect('business');
        }
        $userInfos = Business::where('email', $user)->where('password', $pass)->get();
        if (count($userInfos) > 0) {
            \AlertSweet::success(trans('message.loginOk'))->autoclose(3000);
            \Session::put('user', $userInfos[0]->email);
            \Session::put('ano', $userInfos[0]->id);
            \Session::put('role', "business");
            return redirect('/business/dashboard');
        }
        return redirect('business');
    }
    public function actionLogout()
    {
        \Session::put('user', "");
        \Session::put('role', "");
        return redirect('/business');
    }
    public function loginBusiness()
    {
        $userRole = \Session::get('role');
        if ($userRole == "business") {
            return redirect('business/dashboard');
        }
        return view('login_business');
    }
    public function getSumVisits($bookClasses, $books)
    {
        $accountNo  = \Session::get('ano');
        $sumBooking = 0;
        foreach ($bookClasses as $bookClass) {
            if ($bookClass->consumer->business_id == $accountNo) {
                $sumBooking++;
            }
        }
        foreach ($books as $book) {
            if ($book->consumer->business_id == $accountNo) {
                $sumBooking++;
            }
        }
        return $sumBooking;
    }
    public function viewDashboard()
    {
        if ($this->isLogin() == 0) {
            return redirect("/business");
        }
        $accountNo   = \Session::get('ano');
        $firstDay    = new \DateTime('first day of this month');
        $lastDay     = new \DateTime('last day of this month');
        $monday      = new \DateTime('monday this week');
        $sunday      = new \DateTime('sunday this week');
        $users       = Consumer::where('business_id', $accountNo)->get();
        $bookClasses = Book::with('consumer')
        ->whereBetween('date', [$firstDay->format('Y-m-d'), $lastDay->format('Y-m-d')])->get();
        $books       = BookGym::with('consumer')
        ->whereBetween('date', [$firstDay->format('Y-m-d'), $lastDay->format('Y-m-d')])->get();

        $bookClassWeek  = Book::with('consumer')
        ->whereBetween('date', [$monday->format('Y-m-d'), $sunday->format('Y-m-d')])->get();
        $bookGymWeek    = BookGym::with('consumer')
        ->whereBetween('date', [$monday->format('Y-m-d'), $sunday->format('Y-m-d')])->get();
        $sumCredit      = 0;
        $sumBooking     = 0;
        $sumWeekBooking = 0;
        foreach ($users as $user) {
            $sumCredit += $user->credit;
        }
        $sumBooking     = $this->getSumVisits($bookClasses, $books);
        $sumWeekBooking = $this->getSumVisits($bookClassWeek, $bookGymWeek);
        if (count($users) > 0) {
            $sumWeekBooking = number_format((float) $sumWeekBooking / count($users), 2, '.', '');
        }
        $days      = [31,28,31,30,31,30,31,31,30,31,30,31];
        $graphData = [];
        for ($i = 1; $i <  13; $i++) {
            $currentDate = new \DateTime();
            $startDate   = "";
            $endDate     = "";

            if ($i < 10) {
                $startDate = $currentDate->format('Y')."-0".$i."-01";
                $endDate   = $currentDate->format('Y') ."-0".$i ."-".$days[$i - 1];
            } else {
                $startDate = $currentDate->format('Y') ."-" .$i . "-01";
                $endDate   = $currentDate->format('Y') ."-" .$i ."-".$days[$i - 1];
            }
            $bookClassMonthly = Book::with('consumer')
            ->whereBetween('date', [$startDate, $endDate])->get();
            $bookGymMonthly   = BookGym::with('consumer')
            ->whereBetween('date', [$startDate, $endDate])->get();
            $sumMonthly       = 0;
            $sumMonthly       = $this->getSumVisits($bookClassMonthly, $bookGymMonthly);
            $graphData[$i]    =$sumMonthly;
        }
        $graphr = $this->engine->setJavascriptArray($graphData);
        return view('index')->with('part', 'BUSINESS')->with('pageName', 'DASHBOARD')
          ->with('title', "FitCard Business")->with('countCredit', $sumCredit)
          ->with('countVisit', $sumBooking)
          ->with('averageBook', $sumWeekBooking)
          ->with('graphs', $graphr);
    }
    public function viewUsers()
    {
        if ($this->isLogin() == 0) {
            return redirect("/business");
        }
        $accountNo = \Session::get('ano');
        $users     = Consumer::where('business_id', $accountNo)->get();
        return view('index')->with('part', 'BUSINESS')->with('pageName', 'USERS')
          ->with('title', "FitCard Business")->with('users', $users);
    }
    public function actionUpdateGraph(Request $request)
    {
        $conId     = $request->input('consumer_no');
        $firstDay  = $request->input('startDate');
        $lastDay   = $request->input('endDate');
        $userInfo  = Consumer::where('id', $conId)->first();
        $interval  = \DateInterval::createFromDateString('1 day');
        $firstDate = \DateTime::createFromFormat('Y-m-d', $firstDay);
        $endDate   = \DateTime::createFromFormat('Y-m-d', $lastDay);
        $endDate1  = \DateTime::createFromFormat('Y-m-d', $lastDay);
        $endDate->add($interval);
        $result = $this->getGraph($firstDate, $endDate, $conId);
        return view('index')->with('part', 'BUSINESS')->with('pageName', 'PROFILE')
          ->with('title', "FitCard Business")->with('userInfo', $userInfo)
          ->with('startDate', $firstDate->format('Y-m-d'))
          ->with('endDate', $endDate1->format('Y-m-d'))
          ->with('graphX', $result[0])->with('graphY', $result[1]);
    }
    public function getGraph($firstDay, $lastDay, $id)
    {
        $interval  = \DateInterval::createFromDateString('1 day');
        $period    = new \DatePeriod($firstDay, $interval, $lastDay);
        $graphData = [];
        $graphDays = [];
        $k         = 0;
        foreach ($period as $dt) {
            $bookClasses   = Book::with('consumer')->where('visitor_id', $id)
            ->where('date', 'like', '%'.$dt->format('Y-m-d').'%')->get();
            $books         = BookGym::with('consumer')->where('visitor_id', $id)
            ->where('date', 'like', '%'.$dt->format('Y-m-d').'%')->get();
            $graphData[$k] =count($bookClasses) + count($books);
            $graphDays[$k] = $dt->format('d/m');
            $k++;
        }
        $graphr    = $this->engine->setJavascriptArray($graphData);
        $graphY    = $this->engine->setJavascriptArray($graphDays);
        $result    = [];
        $result[0] = $graphr;
        $result[1] = $graphY;
        return $result;
    }
    public function viewProfile($id)
    {
        $interval = \DateInterval::createFromDateString('1 day');
        $userInfo = Consumer::where('id', $id)->first();
        $firstDay = new \DateTime('first day of this month');
        $lastDay  = new \DateTime('last day of this month');
        $lastDay1 = new \DateTime('last day of this month');
        $lastDay->add($interval);
        $result = $this->getGraph($firstDay, $lastDay, $id);
        return view('index')->with('part', 'BUSINESS')->with('pageName', 'PROFILE')
          ->with('title', "FitCard Business")->with('userInfo', $userInfo)
          ->with('startDate', $firstDay->format('Y-m-d'))
          ->with('endDate', $lastDay1->format('Y-m-d'))
          ->with('graphX', $result[0])->with('graphY', $result[1]);
    }
    private function isLogin()
    {
        $conId = \Session::get('user');
        if ($conId == "" || $conId == null) {
            return 0;
        }
        return 1;
    }
}
