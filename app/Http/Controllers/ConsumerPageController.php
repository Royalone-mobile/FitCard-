<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ConsumerController;
use App\Model\Gym;
use App\Model\ClassModel;
use App\Model\Plan;
use App\Model\Category;
use App\Model\Activity;
use App\Model\Studio;
use App\Model\Location;
use App\Model\Consumer;
use App\Model\Amenity;
use App\Model\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ConsumerPageController extends ConsumerController
{
    /**
     * The main, customer-facing front page of the site
     *
     * @return View
     */
    public function index()
    {
        $classes = ClassModel::with('gymInfo')->limit(6)->orderby('date', 'desc')->get();

        return view('index_consumer')
            ->with('part', 'CONSUMER')
            ->with('pageName', 'HOME')
            ->with('title', "FitCard Company")
            ->with('isLogin', $this->isLogin())
            ->with('classes', $classes)
            ->with('planInfos', Plan::all())
            ->with('gyms', $this->engine->getTopGyms())
            ->with('reviews', $this->engine->getRecentReviews())
            ->with('cityInfos', City::all());
    }

    public function viewInvites()
    {
        $isLogin = $this->isLogin();

        return view('index_consumer')->with('part', 'CONSUMER')->with('pageName', 'INVITE')
            ->with('title', "FitCard Company")->with('isLogin', $isLogin);
    }

    public function viewAbout()
    {
        $isLogin = $this->isLogin();

        return view('index_consumer')->with('part', 'CONSUMER')->with('pageName', 'ABOUT')
            ->with('title', "FitCard Company")->with('isLogin', $isLogin);
    }

    public function viewPartner()
    {
        $isLogin = $this->isLogin();

        return view('index_consumer')->with('part', 'CONSUMER')->with('pageName', 'PARTNER')
            ->with('title', "FitCard Company")->with('isLogin', $isLogin);
    }

    public function viewContacts()
    {
        $isLogin = $this->isLogin();

        return view('index_consumer')->with('part', 'CONSUMER')->with('pageName', 'CONTACT')
            ->with('title', "FitCard Company")->with('isLogin', $isLogin);
    }

    public function viewListGym()
    {
        $isLogin      = $this->isLogin();
        $gymInfos     = Gym::all();
        $cityList     = City::all();
        $locationList = Location::all();
        $activityList = Category::all();
        $studioList   = Studio::all();
        $amentityList = Amenity::all();
        $gymInfoArray = $this->engine->setMakeGymToArray($gymInfos);

        return view('index_consumer')->with('part', 'CONSUMER')->with('pageName', 'LISTGYM')
            ->with('title', "FitCard Company")->with('isLogin', $isLogin)
            ->with('gymInfos', $gymInfoArray)
            ->with('cityInfos', $cityList)
            ->with('locationInfos', $locationList)
            ->with('activityInfos', $activityList)
            ->with('studioInfos', $studioList)
            ->with('amentityInfos', $amentityList);
    }

    public function viewListClass()
    {
        $isLogin      = $this->isLogin();
        $cityList     = City::all();
        $locationList = Location::all();
        $activityList = Activity::all();
        $studioList   = Studio::all();
        $amentityList = Amenity::all();

        return view('index_consumer')->with('part', 'CONSUMER')->with('pageName', 'LISTCLASS')
            ->with('title', "FitCard Company")->with('isLogin', $isLogin)
            ->with('cityInfos', $cityList)
            ->with('locationInfos', $locationList)
            ->with('activityInfos', $activityList)
            ->with('studioInfos', $studioList)
            ->with('amentityInfos', $amentityList);
    }
}
