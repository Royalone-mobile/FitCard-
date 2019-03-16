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

class AdminClassController extends AdminMenuController
{

    public function viewClasses()
    {
        if ($this->isLogin() == 0) {
            return redirect("/admin");
        }
        $classInfos = ClassModel::orderBy('date', 'desc')->get();
        $gymInfos   = Gym::all();
        return view('index')->with('part', 'ADMIN')->with('pageName', 'CLASSES')
            ->with('title', "FitCard Admin")->with('classInfos', $classInfos)
            ->with('gymInfos', $gymInfos);
    }
    private function isLogin()
    {
        $conId = \Session::get('user');
        if ($conId == "" || $conId == null) {
            return 0;
        }
        return 1;
    }

    public function viewCreateClass()
    {
        if ($this->isLogin() == 0) {
            return redirect("/admin");
        }
        $gymInfos      = Gym::all();
        $categoryInfos = CategoryClass::all();
        return view('index')->with('part', 'ADMIN')->with('pageName', 'ADDCLASS')
            ->with('title', "FitCard Admin")
            ->with('gymInfos', $gymInfos)
            ->with('categoryInfos', $categoryInfos);
    }

    public function viewClassCategoryManage()
    {
        if ($this->isLogin() == 0) {
            return redirect("/admin");
        }
        $data = CategoryClass::all();
        return view('index')->with('part', 'ADMIN')->with('pageName', 'CLASSCATEGORY')
            ->with('title', "FitCard Admin")
            ->with('data', $data);
    }

    public function actionCreateClassCategory(Request $request)
    {
        $locationName = strip_tags($request->input('category_name'));
        if ($locationName == "") {
            return back();
        }
        $category           = new CategoryClass();
        $category->category = $locationName;
        $category->save();
        \AlertSweet::success(trans('message.categoryCreated'))->autoclose(3000);
        return redirect('/admin/classcategory');
    }
    private function getParamterClass(Request $request)
    {
        $className        = strip_tags($request->input('class_name'));
        $classDescription = strip_tags($request->input('class_description'));
        $classValue       = strip_tags($request->input('class_value'));
        $classDate        = strip_tags($request->input('class_date'));
        $classEndDate     = strip_tags($request->input('class_dateend'));
        $classStart       = strip_tags($request->input('class_starttime'));
        $classEnd         = strip_tags($request->input('class_endtime'));
        $classCategory    = strip_tags($request->input('class_category'));
        if (!isset($classCategory)) {
            $classCategory = "";
        }
        $classGym       = strip_tags($request->input('class_gym'));
        $classRecurring = strip_tags($request->input('class_recurring'));

        $result                   = [];
        $result['name']           = $className;
        $result['description']    = $classDescription;
        $result['value']          = $classValue;
        $result['date']           = $classDate;
        $result['endDate']        = $classEndDate;
        $result['start']          = $classStart;
        $result['classCategory']  = $classCategory;
        $result['end']            = $classEnd;
        $result['classGym']       = $classGym;
        $result['classRecurring'] = $classRecurring;
        return $result;
    }
    public function actionCreateClass(Request $request)
    {
        $result = $this->getParamterClass($request);
        $sTime  = $this->changeTimeFormat($result['start']);
        $eTime  = $this->changeTimeFormat($result['end']);
        if ($result['classRecurring'] == 0) {
            $date          =[];
            $date['start'] = new \DateTime($result['date']);
            $date['end']   = "";
            $this->saveClassModel(
                $result['name'],
                $result['classGym'],
                $result['description'],
                $date,
                $sTime,
                $eTime,
                $result['classCategory'],
                $result['value'],
                $result['classRecurring']
            );
        } elseif ($result['classRecurring'] == 1) { //Daily
            $dateStart = new \DateTime($result['date']);
            $dateEnd   = new \DateTime($result['endDate']);
            while ($dateStart <= $dateEnd) {
                $date          =[];
                $date['start'] = $dateStart;
                $date['end']   = $dateEnd;
                $this->saveClassModel(
                    $result['name'],
                    $result['classGym'],
                    $result['description'],
                    $date,
                    $sTime,
                    $eTime,
                    $result['classCategory'],
                    $result['value'],
                    $result['classRecurring']
                );
                $dateStart = $dateStart->add(new \DateInterval('P1D'));
            }
        } elseif ($result['classRecurring'] == 2) { //Weekly
            $dateStart = new \DateTime($result['date']);
            $dateEnd   = new \DateTime($result['endDate']);
            while ($dateStart <= $dateEnd) {
                $date          =[];
                $date['start'] = $dateStart;
                $date['end']   = $dateEnd;
                $this->saveClassModel(
                    $result['name'],
                    $result['classGym'],
                    $result['description'],
                    $date,
                    $sTime,
                    $eTime,
                    $result['classCategory'],
                    $result['value'],
                    $result['classRecurring']
                );
                $dateStart = $dateStart->add(new \DateInterval('P7D'));
            }
        } elseif ($result['classRecurring'] == 3) { //Monthly
            $dateStart = new \DateTime($result['date']);
            $dateEnd   = new \DateTime($result['endDate']);
            while ($dateStart <= $dateEnd) {
                $date          =[];
                $date['start'] = $dateStart;
                $date['end']   = $dateEnd;
                $this->saveClassModel(
                    $result['name'],
                    $result['classGym'],
                    $result['description'],
                    $date,
                    $sTime,
                    $eTime,
                    $result['classCategory'],
                    $result['value'],
                    $result['classRecurring']
                );
                $dateStart = $dateStart->add(new \DateInterval('P1M'));
            }
        }
        \AlertSweet::success(trans('message.classCreated'))->autoclose(3000);
        return redirect('/admin/classes');
    }

    private function saveClassModel(
        $className,
        $classGym,
        $classDescription,
        $date,
        $sTime,
        $eTime,
        $classCategory,
        $classValue,
        $classRecurring
    ) {

        $class              = new ClassModel();
        $class->name        = $className;
        $class->gym         = $classGym;
        $class->description = $classDescription;
        $class->date        = $date['start'];
        $class->enddate     = $date['end'];
        $class->starthour   = $sTime;
        $class->endhour     = $eTime;
        $class->category    = $classCategory;
        $class->value       = $classValue;
        $class->recurring   = $classRecurring;
        $class->save();
    }

    public function actionDeleteClass($cid)
    {
        ClassModel::where("id", $cid)->delete();
        \AlertSweet::success(trans('message.classDeleted'))->autoclose(3000);
        return redirect('/admin/classes');
    }

    public function actionDeleteClassCategory($cid)
    {
        CategoryClass::where("id", $cid)->delete();
        \AlertSweet::success(trans('message.categoryDeleted'))->autoclose(3000);
        return redirect('/admin/classcategory');
    }

    public function viewEditClass($cid)
    {
        if ($this->isLogin() == 0) {
            return redirect("/admin");
        }
        $gymInfos      = Gym::all();
        $categoryInfos = CategoryClass::all();
        $classInfo     = ClassModel::with('book', 'book.consumer')->where('id', $cid)->first();
        return view('index')->with('part', 'ADMIN')->with('pageName', 'EDITCLASS')
            ->with('title', "FitCard Admin")
            ->with('gymInfos', $gymInfos)
            ->with('categoryInfos', $categoryInfos)
            ->with('classInfo', $classInfo);
    }
    private function changeTimeFormat($time)
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







    public function actionUpdateClass(Request $request)
    {
        $classNo = strip_tags($request->input('class_no'));
        $result  = $this->getParamterClass($request);

        $sTime = $this->changeTimeFormat($result['start']);
        $eTime = $this->changeTimeFormat($result['end']);
        ClassModel::where('id', $classNo)->update(
            [
                'name' => $result['name'], 'gym' => $result['classGym'], 'description' => $result['description'],
                'date' => $result['date'], 'starthour' => $sTime, 'endhour' => $eTime,
                'category' => $result['classCategory'], 'value' => $result['value'],
                'recurring' => $result['classRecurring'], 'enddate' => $result['endDate']
            ]
        );
        \AlertSweet::success(trans('message.classUpdated'))->autoclose(3000);
        return redirect('/admin/classes');
    }
}
