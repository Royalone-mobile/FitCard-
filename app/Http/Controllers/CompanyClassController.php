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

class CompanyClassController extends Controller
{

    public $engine;


    private function isLogin()
    {
        $userRole = \Session::get('role');
        if ($userRole == "company") {
            return true;
        }
        return false;
    }

    public function __construct()
    {
        $this->middleware('guest');
        $this->engine = new AdminEngine();
        $lang         = \Session::get('language');
        \App::setLocale('en');
        $this->engine->changeLanguage($lang);
    }



    public function viewClasses()
    {
        if (!$this->isLogin()) {
            return redirect('company');
        }
        $accountNo  = \Session::get('ano');
        $gymInfos   = Gym::where('company', $accountNo)->get();
        $classInfos = Gym::with('classes')->where('gym.company', $accountNo)->get();

        $city   = City::all();
        $books  = [];
        $iIndex = 0;
        foreach ($classInfos as $classInfo) {
            foreach ($classInfo->classes as $clsInfo) {
                $booksCount     = Book::where('class_id', $clsInfo->id)->get();
                $books[$iIndex] = count($booksCount);
                $iIndex++;
            }
        }
        return view('index')->with('part', 'COMPANY')->with('pageName', 'CLASSES')
            ->with('title', "FitCard Company")
            ->with('gymInfos', $gymInfos)
            ->with('classInfos', $classInfos)
            ->with('cityInfos', $city)
            ->with('books', $books);
    }


    public function actionDeleteClass($cid)
    {
        ClassModel::where("id", $cid)->delete();
        \AlertSweet::success(trans('message.classDeleted'))->autoclose(3000);
        return redirect('/company/classes');
    }

    public function viewCreateClass()
    {
        if (!$this->isLogin()) {
            return redirect('company');
        }
        $accountNo     = \Session::get('ano');
        $gymInfos      = Gym::where('company', $accountNo)->get();
        $categoryInfos = CategoryClass::all();
        return view('index')->with('part', 'COMPANY')->with('pageName', 'ADDCLASS')
            ->with('title', "FitCard Admin")
            ->with('gymInfos', $gymInfos)
            ->with('categoryInfos', $categoryInfos);
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



    public function actionCreateClass(Request $request)
    {
        $className        = strip_tags($request->input('class_name'));
        $classDescription = strip_tags($request->input('class_description'));
        $classValue       = strip_tags($request->input('class_value'));
        $classDate        = strip_tags($request->input('class_date'));
        $classEndDate     = strip_tags($request->input('class_dateend'));
        $classStart       = strip_tags($request->input('class_starttime'));
        $classEnd         = strip_tags($request->input('class_endtime'));
        $classCategory    = strip_tags($request->input('class_category'));
        $classGym         = strip_tags($request->input('class_gym'));
        $classRecurring   = strip_tags($request->input('class_recurring'));


        $sTime = $this->changeTimeFormat($classStart);
        $eTime = $this->changeTimeFormat($classEnd);
        if ($classRecurring == 0) {
            $dateStart          = new \DateTime($classDate);
            $dateEnd            = new \DateTime($classEndDate);
            $class              = new ClassModel();
            $class->name        = $className;
            $class->gym         = $classGym;
            $class->description = $classDescription;
            $class->date        = $dateStart;
            $class->enddate     = $classEndDate;
            $class->starthour   = $sTime;
            $class->endhour     = $eTime;
            $class->category    = $classCategory;
            $class->value       = $classValue;
            $class->recurring   = $classRecurring;
            $class->save();
        } elseif ($classRecurring == 1) { //Daily
            $dateStart = new \DateTime($classDate);
            $dateEnd   = new \DateTime($classEndDate);
            while ($dateStart <= $dateEnd) {
                $class              = new ClassModel();
                $class->name        = $className;
                $class->gym         = $classGym;
                $class->description = $classDescription;
                $class->date        = $dateStart;
                $class->enddate     = $classEndDate;
                $class->starthour   = $sTime;
                $class->endhour     = $eTime;
                $class->category    = $classCategory;
                $class->value       = $classValue;
                $class->recurring   = $classRecurring;
                $class->save();
                $dateStart = $dateStart->add(new \DateInterval('P1D'));
            }
        } elseif ($classRecurring == 2) { //Weekly
            $dateStart = new \DateTime($classDate);
            $dateEnd   = new \DateTime($classEndDate);
            while ($dateStart <= $dateEnd) {
                $class              = new ClassModel();
                $class->name        = $className;
                $class->gym         = $classGym;
                $class->description = $classDescription;
                $class->date        = $dateStart;
                $class->enddate     = $classEndDate;
                $class->starthour   = $sTime;
                $class->endhour     = $eTime;
                $class->category    = $classCategory;
                $class->value       = $classValue;
                $class->recurring   = $classRecurring;
                $class->save();
                $dateStart = $dateStart->add(new \DateInterval('P7D'));
            }
        } elseif ($classRecurring == 3) { //Monthly
            $dateStart = new \DateTime($classDate);
            $dateEnd   = new \DateTime($classEndDate);
            while ($dateStart <= $dateEnd) {
                $class              = new ClassModel();
                $class->name        = $className;
                $class->gym         = $classGym;
                $class->description = $classDescription;
                $class->date        = $dateStart;
                $class->enddate     = $classEndDate;
                $class->starthour   = $sTime;
                $class->endhour     = $eTime;
                $class->category    = $classCategory;
                $class->value       = $classValue;
                $class->recurring   = $classRecurring;
                $class->save();
                $dateStart = $dateStart->add(new \DateInterval('P1M'));
            }
        }
        \AlertSweet::success(trans('classCreated'))->autoclose(3000);
        return redirect('/company/classes');
    }



    public function actionUpdateClass(Request $request)
    {
        $classNo          = strip_tags($request->input('class_no'));
        $className        = strip_tags($request->input('class_name'));
        $classDescription = strip_tags($request->input('class_description'));
        $classValue       = strip_tags($request->input('class_value'));
        $classDate        = strip_tags($request->input('class_date'));
        $classStart       = strip_tags($request->input('class_starttime'));
        $classEnd         = strip_tags($request->input('class_endtime'));
        $classCategory    = strip_tags($request->input('class_category'));
        $classGym         = strip_tags($request->input('class_gym'));
        $classRecurring   = strip_tags($request->input('class_recurring'));

        $sTime = $this->changeTimeFormat($classStart);
        $eTime = $this->changeTimeFormat($classEnd);

                ClassModel::where('id', $classNo)->update(
                    [
                    'name' => $className
                    , 'gym' => $classGym
                    , 'description' => $classDescription
                    , 'date' => $classDate
                    , 'starthour' => $sTime
                    , 'endhour' => $eTime
                    , 'category' => $classCategory
                    , 'value' => $classValue
                    , 'recurring' => $classRecurring
                    ]
                );
        \AlertSweet::success(trans('message.classUpdated'))->autoclose(3000);
        return redirect('/company/classes');
    }

    public function viewEditClass($cid)
    {
        if (!$this->isLogin()) {
            return redirect('company');
        }
        $accountNo     = \Session::get('ano');
        $gymInfos      = Gym::where('company', $accountNo)->get();
        $categoryInfos = CategoryClass::all();
        $classInfo     = ClassModel::with('book', 'book.consumer')->where('id', $cid)->first();
        return view('index')->with('part', 'COMPANY')->with('pageName', 'EDITCLASS')
            ->with('title', "FitCard Admin")
            ->with('gymInfos', $gymInfos)
            ->with('categoryInfos', $categoryInfos)
            ->with('classInfo', $classInfo);
    }
}
