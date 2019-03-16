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
use App\Model\GymCode;
use App\Model\Payment;
use App\Model\Coupon;
use App\Engine\EngineClass;
use App\Engine\ServiceEngine;
use Illuminate\Http\Request;

class WebServiceGymController extends WebServiceClassController
{

    private $engine;

    public function __construct()
    {
        $this->middleware('guest');
        $this->engine = new ServiceEngine();
    }

    public function serviceFeaturedGym()
    {
        $gymInfos = $this->engine->getTopGyms();

        return response()->json(["gyms" => $gymInfos]);
    }

    public function serviceLoadGym()
    {
        $gymInfos     = Gym::all();
        $cityList     = City::all();
        $locationList = Location::all();
        $activityList = Activity::all();
        $studioList   = Studio::all();
        $amentityList = Amenity::all();

        return response()->json(
            [
                "gyms"          => $gymInfos,
                "cityInfos"     => $cityList,
                "locationInfos" => $locationList,
                "activityInfos" => $activityList,
                "studioInfos"   => $studioList,
                "amenityInfos"  => $amentityList
            ]
        );
    }

    public function serviceSearchGym($city, $keyword, $activityIds, $amenityIds, $studioIds, $locationIds)
    {
        $gymInfos = $this->engine->getSearchGym($city, $keyword, $activityIds, $amenityIds, $studioIds, $locationIds);

        return response()->json(
            [
                "gyms" => $gymInfos
            ]
        );
    }

    public function serviceLoadReviewForGym($gid)
    {
        $reviewInfos = Review::with('consumer')->where('review.gym_id', $gid)->get();

        return response()->json(
            [
                "reviews" => $reviewInfos
            ]
        );
    }

    public function serviceLastVisitGym($conId, $gid)
    {
        $bookTime = $this->engine->getLastVisitGym($conId, $gid);
        $now      = new \DateTime();
        $now->setTimezone(new \DateTimeZone('Europe/Helsinki'));
        $currentDate = $now->format('Y-m-d H:i:m');
        $book        = BookGym::where('visitor_id', $conId)
            ->where('gym_id', $gid)->where('date', '>', $currentDate)->orderby('date', 'desc')->get();
        $countBooks  = count($book);

        return response()->json(
            [
                "booktime" => $bookTime,
                "count"    => $countBooks
            ]
        );
    }


    public function serviceBookGym($consumerId, $gid)
    {
        $now = new \DateTime();
        $now->setTimezone(new \DateTimeZone('Europe/Helsinki'));
        $currentDate = $now->format('Y-m-d H:i:m');
        $userData    = Consumer::where('id', $consumerId)->first();
        if (0 < $userData->credit) {
            $credit  = $userData->credit - 1;
            $gymInfo = Gym::where('id', $gid)->first();
            BookGym::insert(
                [
                    'visitor_id' => $consumerId,
                    'gym_id'     => $gid,
                    'date'       => $currentDate
                ]
            );
            Consumer::where('id', $consumerId)->update(
                [
                    'credit' => $credit
                ]
            );
            if ($gymInfo->visitcode > 0) {
                $code = GymCode::where('gym_id', $gid)->where('use', 0)->get();
                if (count($code) > 0) {
                    GymCode::where('id', $code[0]->id)->update(
                        [
                            'use' => 1
                        ]
                    );

                    return response()->json(["result" => "1", "code" => $code[0]->code]);
                }

                return response()->json(["result" => "1", "code" => 0]);
            }

            return response()->json(["result" => "1", "code" => 0]);
        }

        return response()->json(["result" => "0", "code" => 0]);
    }

    public function serviceDeleteGym($id, $uid)
    {
        BookGym::where('id', $id)->delete();
        $user = Consumer::where('id', $uid)->first();
        Consumer::where('id', $uid)->update(
            [
                'credit' => $user->credit + 1
            ]
        );
    }
}
