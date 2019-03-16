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
use App\Engine\EngineClass;
use App\Engine\ServiceEngine;
use Illuminate\Http\Request;

class WebServiceClassController extends Controller
{

    private $engine;

    public function __construct()
    {
        $this->middleware('guest');
        $this->engine = new ServiceEngine();
    }



    public function serviceLastVisitClass($conId, $cid)
    {
        $book = $this->engine->isClassBook($conId, $cid);
        return response()->json(
            [
                "book" => $book
            ]
        );
    }

    public function serviceLoadReviewForClass($cid)
    {
        $reviewInfos = Review::with('consumer')->where('review.class_id', $cid)->get();
        return response()->json(
            [
                "reviews" => $reviewInfos
            ]
        );
    }


    public function serviceLoadPlan()
    {
        $planInfos = Plan::all();
        return response()->json(
            [
                "plans" => $planInfos
            ]
        );
    }

    public function searchClass($date, $gid, $city, $category, $keyword, $uid)
    {
        $result       = $this->engine->getSearchClass($date, $gid, $city, $category, $keyword, $uid);
        $cityList     = City::all();
        $categoryList = CategoryClass::all();
        return response()->json(
            [
                "classes" => $result['classInfos'],
                "duration" => $result['durationArray'],
                "available" => $result['availableArray'],
                "upcoming" => $result['upcomingDate'],
                "bookArray" =>$result['bookArray'],
                "cityList" => $cityList,
                "category" => $categoryList
            ]
        );
    }

    public function serviceDeleteClass($id, $uid)
    {
        $this->engine->cancelBook($id, $uid);
    }

    public function serviceLoadBooks($consumerNo)
    {
        $result = $this->engine->getLoadBooks($consumerNo);
        return response()->json(
            [
                "gyms" => $result['gyms'],
                "classes" => $result['classes'],
                "duration" => $result['duration'],
                "available" => $result['available']
            ]
        );
    }

    public function serviceReviewClass(Request $request)
    {
        $title   = $request->input('title');
        $cid     = $request->input('class');
        $gid     = $request->input('gym');
        $content = $request->input('content');
        $star    = $request->input('rate');
        $bookId  = $request->input('book');
        $id      = $request->input('id');
        $this->engine->setReviewClass($title, $cid, $gid, $content, $star, $bookId, $id);
    }

    public function serviceLoadOverBooks($id)
    {
        $curTime = new \DateTime();
        $curTime->setTimezone(new \DateTimeZone('Europe/Helsinki'));
        $reviewBooks   = BookGym::with('gym')->where('review', 0)->where('visitor_id', $id)->get();
        $reviewClasses = Book::with('classModel', 'classModel.gymInfo')->where('review', 0)
                        ->where('visitor_id', $id)->where('date', '<', $curTime->format('Y-m-d'))->get();
        $gymArray      = [];
        $kIndex        = 0;
        foreach ($reviewBooks as $gymObject) {
            $timestamp = strtotime($gymObject->date) + 60 * 60 * 3;
            $tt        = date('Y-m-d H:i:m', $timestamp);
            if ($tt >= $curTime->format('Y-m-d H:i:m')) {
                continue;
            }
            $gymArray[$kIndex] = $gymObject;
        }
        $count = count($gymArray) + count($reviewClasses);
        return response()->json(
            [
                    "gyms" => $gymArray,
                    "classes" => $reviewClasses,
                    "count" => $count
            ]
        );
    }

    public function serviceBookClass($consumerId, $cid)
    {
        $now = new \DateTime();
        $now->setTimezone(new \DateTimeZone('Europe/Helsinki'));
        $currentDate = $now->format('Y-m-d');
        $classData   = ClassModel::where('class.id', $cid)->first();
        $countBook   = Book::where('class_id', $cid)->get();
        $userData    = Consumer::where('id', $consumerId)->first();
        if (count($countBook) >= $classData->value) {
            return response()->json(["result" => "2"]);
        }
        if (0 < $userData->credit) {
            $credit = $userData->credit - 1;
            Book::insert(
                [
                        'visitor_id' => $consumerId,
                        'class_id' => $cid,
                        'date' => $currentDate
                ]
            );
            Consumer::where('id', $consumerId)->update(
                [
                    'credit' => $credit
                ]
            );
            return response()->json(["result" => "1"]);
        }
        return response()->json(["result" => "0"]);
    }
}
