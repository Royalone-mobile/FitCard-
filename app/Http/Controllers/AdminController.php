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
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{

    public $engine;

    public function __construct()
    {
        $this->engine = new AdminEngine();
        $lang         = \Session::get('language');
        \App::setLocale('en');
        $this->engine->changeLanguage($lang);
    }

    /**
     * Admin Login
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request)
    {
        $name     = $request->get('username');
        $password = $request->get('pw');

        $admin = Admin::where(['name' => $name, 'password' => $password])->get()->first();

        if ($admin) {
            Session::put('user', $name);
            Session::put('role', "admin");
            \AlertSweet::success("Login Success")->autoclose(3000);
            return redirect()->intended('admin/dashboard');
        }
        \AlertSweet::success("Login Error")->autoclose(3000);
        return redirect()->intended('/admin');
    }

    /**
     * Admin logout
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Session::flush();

        return redirect('/');
    }


    public function actionCreateActivity(Request $request)
    {
        $locationName = strip_tags($request->input('activity_name'));
        if ($locationName == "") {
            return back();
        }
        $activity       = new Activity();
        $activity->name = $locationName;
        $activity->save();
        \AlertSweet::success(trans('message.activityCreated'))->autoclose(3000);
        return redirect('/admin/activitymanage');
    }

    public function actionCreateStudio(Request $request)
    {
        $locationName = strip_tags($request->input('studio_name'));
        if ($locationName == "") {
            return back();
        }
        $studio       = new Studio();
        $studio->name = $locationName;
        $studio->save();
        \AlertSweet::success(trans('message.studioCreated'))->autoclose(3000);
        return redirect('/admin/studiomanage');
    }

    public function actionCreateAmenity(Request $request)
    {
        $locationName = strip_tags($request->input('amentity_name'));
        if ($locationName == "") {
            return back();
        }
        $amentity       = new Amenity();
        $amentity->name = $locationName;
        $amentity->save();
        \AlertSweet::success(trans('message.amentityCreated'))->autoclose(3000);
        return redirect('/admin/amentitymanage');
    }

    public function actionCreateCity(Request $request)
    {
        $locationName = strip_tags($request->input('city_name'));
        $locationLat  = strip_tags($request->input('city_lat'));
        $locationLon  = strip_tags($request->input('city_lon'));
        if ($locationName == "") {
            return back();
        }
        $city            = new City();
        $city->city_name = $locationName;
        $city->lat       = $locationLat;
        $city->lon       = $locationLon;
        $city->save();
        \AlertSweet::success('message.cityCreated')->autoclose(3000);
        return redirect('/admin/citymanage');
    }

    public function actionDeleteLocation($cid)
    {
        Location::where("id", $cid)->delete();
        \AlertSweet::success(trans('message.locationDeleted'))->autoclose(3000);
        return redirect('/admin/locationmanage');
    }

    public function actionDeleteActivity($cid)
    {
        Activity::where("id", $cid)->delete();
        \AlertSweet::success(trans('message.activityDeleted'))->autoclose(3000);
        return redirect('/admin/activitymanage');
    }

    public function actionDeleteStudio($cid)
    {
        Studio::where("id", $cid)->delete();
        \AlertSweet::success(trans('message.studioDeleted'))->autoclose(3000);
        return redirect('/admin/studiomanage');
    }

    public function actionDeleteAmenity($cid)
    {
        Amentity::where("id", $cid)->delete();
        \AlertSweet::success(trans('message.amenityDeleted'))->autoclose(3000);
        return redirect('/admin/amentitymanage');
    }

    public function actionDeleteCity($cid)
    {
        City::where("id", $cid)->delete();
        \AlertSweet::success(trans('message.cityDeleted'))->autoclose(3000);
        return redirect('/admin/citymanage');
    }
}
