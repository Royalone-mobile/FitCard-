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
use App\Model\GymCode;

class AdminGymController extends AdminMenuController
{
    private function isLogin()
    {
        $conId = \Session::get('user');
        if ($conId == "" || $conId == null) {
            return 0;
        }
        return 1;
    }
    public function viewGymCode()
    {
        if ($this->isLogin() == 0) {
            return redirect("/admin");
        }
        $gymInfos     = Gym::with('gymCode')->where('visitcode', 1)->get();
        $companyInfos = Company::all();
        return view('index')->with('part', 'ADMIN')->with('pageName', 'GYMCODE')
          ->with('title', "FitCard Admin")->with('gymInfos', $gymInfos)
          ->with('companyInfos', $companyInfos);
    }
    public function viewGyms()
    {
        if ($this->isLogin() == 0) {
            return redirect("/admin");
        }
        $gymInfos     = Gym::all();
        $companyInfos = Company::all();
        return view('index')->with('part', 'ADMIN')->with('pageName', 'GYMS')
            ->with('title', "FitCard Admin")->with('gymInfos', $gymInfos)
            ->with('companyInfos', $companyInfos);
    }
    public function actionDeleteCode($id)
    {
        GymCode::where('id', $id)->delete();
        return redirect('/admin/gymCode');
    }
    public function importCSV($gymId)
    {
        if (($handle = fopen("./uploads/visitList.csv", "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $code  = $data[0];
                $check = GymCode::where('code', $code)->where('gym_id', $gymId)->get();
                if (count($check) == 0) {
                    GymCode::insert(
                        [
                            'code' => $code,
                            'gym_id' => $gymId
                        ]
                    );
                }
            }
            fclose($handle);
        }
    }

    public function ajaxAddGymCode(Request $request)
    {
        $file  = $request->file('uploadLogo');
        $gymId = $request->input('gymId');
        $file->move("./uploads/", "visitList.csv");
        $this->importCSV($gymId);
        $json['result'] = $gymId;
        return \Response::json($json);
    }
    public function viewCreateGym()
    {
        if ($this->isLogin() == 0) {
            return redirect("/admin");
        }
        $companyInfos  = Company::all();
        $categoryInfos = Category::all();
        $activityInfos = Activity::all();
        $locationInfos = Location::all();
        $amentityInfos = Amenity::all();
        $studioInfos   = Studio::all();
        $cityInfos     = City::all();

        return view('index')->with('part', 'ADMIN')->with('pageName', 'ADDGYM')
            ->with('title', "FitCard Admin")->with('companyInfos', $companyInfos)
            ->with('categoryInfos', $categoryInfos)
            ->with('activityInfos', $activityInfos)
            ->with('locationInfos', $locationInfos)
            ->with('amentityInfos', $amentityInfos)
            ->with('studioInfos', $studioInfos)
            ->with('cityInfos', $cityInfos);
    }

    public function viewEditGym($gid)
    {
        if ($this->isLogin() == 0) {
            return redirect("/admin");
        }

        $result = $this->engine->getEditGymParameter($gid);

        return view('index')->with('part', 'ADMIN')->with('pageName', 'EDITGYM')
            ->with('title', "FitCard Admin")
            ->with('companyInfos', $result['companyInfos'])
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

    public function viewGymCategoryManage()
    {
        if ($this->isLogin() == 0) {
            return redirect("/admin");
        }
        $data = Category::all();
        return view('index')->with('part', 'ADMIN')->with('pageName', 'GYMCATEGORY')
            ->with('title', "FitCard Admin")
            ->with('data', $data);
    }

    public function actionCreateGymCategory(Request $request)
    {
        $locationName = strip_tags($request->input('category_name'));
        if ($locationName == "") {
            return back();
        }
        $category           = new Category();
        $category->category = $locationName;
        $category->save();
        \AlertSweet::success(trans('message.gymCreated'))->autoclose(3000);
        return redirect('/admin/gymcategory');
    }

    public function actionDeleteGym($gid)
    {
        Gym::deleteGym($gid);
        \AlertSweet::success(trans('message.gymDeleted'))->autoclose(3000);
        return redirect('/admin/gyms');
    }

    public function actionDeleteGymCategory($cid)
    {
        Category::where("id", $cid)->delete();
        \AlertSweet::success(trans('message.categoryDeleted'))->autoclose(3000);
        return redirect('/admin/gymcategory');
    }
    public function actionCreateGym(Request $request)
    {
        $result = $this->engine->getParamterGym($request);
        if (count($result['citys']) == 0) {
            $city            = new City();
            $city->city_name = $result['city'];
            $city->save();
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
            return redirect('/admin/gyms');
    }

    public function actionEditGym(Request $request)
    {
        $gymNo  = strip_tags($request->input('gym_no'));
        $result = $this->engine->getParamterGym($request);
        $this->engine->getEditGym($gymNo, $result);
        \AlertSweet::success(trans('message.gymUpdated'))->autoclose(3000);
        return redirect('/admin/gyms');
    }
}
