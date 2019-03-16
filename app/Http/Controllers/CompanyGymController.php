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

class CompanyGymController extends CompanyController
{

    private function isLogin()
    {
        $userRole = \Session::get('role');
        if ($userRole == "company") {
            return true;
        }
        return false;
    }
    public function viewCreateGym()
    {
        if (!$this->isLogin()) {
            return redirect('company');
        }
        $companyUser   = \Session::get('user');
        $companyInfos  = Company::where('email', $companyUser)->get();
        $categoryInfos = Category::all();
        $activityInfos = Activity::all();
        $locationInfos = Location::all();
        $amentityInfos = Amenity::all();
        $studioInfos   = Studio::all();
        $cityInfos     = City::all();


        return view('index')->with('part', 'COMPANY')->with('pageName', 'ADDGYM')
            ->with('title', "FitCard Admin")->with('companyInfos', $companyInfos)
            ->with('categoryInfos', $categoryInfos)
            ->with('activityInfos', $activityInfos)
            ->with('locationInfos', $locationInfos)
            ->with('amentityInfos', $amentityInfos)
            ->with('studioInfos', $studioInfos)
            ->with('cityInfos', $cityInfos);
    }
    public function ajaxMonthPayment(Request $request)
    {
        $accountNo   = \Session::get('ano');
        $companyInfo = Company::where('id', $accountNo)->first();
        $year        = strip_tags($request->input('year'));
        $month       = strip_tags($request->input('month'));
        $gymVisits   = BookGym::with('gym');
        $classVisits = Book::with('classModel', 'classModel.gymInfo');
        $result      = [];

        $item = $this->engine->getMonthPayment($companyInfo, $year, $month, $gymVisits, $classVisits);

        $result[0] = $item;
        return $result;
    }
    public function actionDeleteGym($gid)
    {
        Gym::deleteGym($gid);
        \AlertSweet::success(trans('message.gymDeleted'))->autoclose(3000);
        return redirect('/company/classes');
    }

    public function viewEditGym($gid)
    {
        if (!$this->isLogin()) {
            return redirect('company');
        }
        $accountNo    = \Session::get('ano');
        $companyInfos = Company::where('id', $accountNo)->get();

        $result = $this->engine->getEditGymParameter($gid);

        return view('index')->with('part', 'COMPANY')->with('pageName', 'EDITGYM')
            ->with('title', "FitCard Admin")
            ->with('companyInfos', $companyInfos)
            ->with('categoryInfos', $result['categoryInfos'])
            ->with('activityInfos', $result['activityInfos'])
            ->with('locationInfos', $result['locationInfos'])
            ->with('amentityInfos', $result['amenityInfos'])
            ->with('studioInfos', $result['studioInfos'])
            ->with('cityInfos', $result['cityInfos'])
            ->with('gymActivityInfos', $result['gymactivityInfos'])
            ->with('gymStudioInfos', $result['gymstudioInfos'])
            ->with('gymAmentityInfos', $result['gymamentityInfos'])
            ->with('gymLocationInfos', $result['gymlocationInfos'])
            ->with('gymCategoryInfos', $result['gymcategoryInfo'])
            ->with('gymInfo', $result['gymInfos']);
    }

    public function changeTimeFormat($time)
    {
        if ($time == null || $time == "") {
            return "";
        }
        $stimeArray = explode(":", $time);
        $stime      = $stimeArray[0] . ":" . $stimeArray[1];
        if (strpos($time, "PM") > 0) {
            $stime = ($stimeArray[0] + 12) . ":" . $stimeArray[1];
        }
        return $stime;
    }

    public function actionCreateGym(Request $request)
    {
        $result = $this->engine->getParamterGym($request);
        if (count($result['citys']) == 0) {
            City::insert(
                [
                    'city_name' => $result['city']
                ]
            );
        }
        $gid = Gym::insertGetId(
            $this->engine->getUpdateGymArray($result)
        );
        $this->engine->setAddOptionGymInfo(
            $result['gymActivityIds'],
            $result['gymStudioIds'],
            $result['gymAmentityIds'],
            $result['gymCategoryIds'],
            $result['gymLocationIds'],
            $gid
        );
        \AlertSweet::success(trans('message.gymCreated'))->autoclose(3000);
        return redirect('/company/classes');
    }


    public function actionEditGym(Request $request)
    {
        $gymNo  = $request->input('gym_no');
        $result = $this->engine->getParamterGym($request);
        $this->engine->getEditGym($gymNo, $result);
        \AlertSweet::success(trans('message.gymUpdated'))->autoclose(3000);
        return redirect('/company/classes');
    }
}
