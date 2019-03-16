<?php

namespace App\Engine;

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

class WebEngineClass extends EngineClass
{


    public function getSearchGymWeb($city, $keyword)
    {
        $gymInfos = $this->getSearchGym($city, $keyword);
        return $gymInfos;
    }

    public function getRecentReviews()
    {

        $reviewInfos      = Review::getRecentReviews();
        $reviewData       = [];
        $sum              = 0;
        $data             = [];
        $countReviewInfos = count($reviewInfos);
        for ($i = 0; $i < $countReviewInfos; $i++) {
            $reviewItem                = [];
            $reviewInfo                = $reviewInfos[$i];
            $reviewItem['user']        = $reviewInfo->cname;
            $reviewItem['description'] = $reviewInfo->description;
            $reviewItem['title']       = $reviewInfo->title;
            $reviewItem['date']        = $reviewInfo->date;
            $reviewItem['rating']      = $reviewInfo->star;
            $reviewItem['image']       = $reviewInfo->image;
            $sum                       = $sum + $reviewInfo->star;
            $reviewData[$i]            = $reviewItem;
        }
        $data['reviews'] = $reviewData;
        $data['rating']  = 0;
        if (count($reviewInfos) > 0) {
            $data['rating'] = (float) $sum / count($reviewInfos);
        }
        return $data;
    }
    public function changeLanguage($id)
    {
        \App::setLocale('fi');
        if ($id == 1) {
            \App::setLocale('en');
        }
    }
    public function setSearchOption($activitySearchIds, $amentitySearchIds, $studioSearchIds, $locationSearchIds)
    {
        if ($activitySearchIds != "") {
            foreach (explode("-", $activitySearchIds) as $activityId) {
                $classInfos = $classInfos->where('gymInfo.gymActivity.activity_id', $activityId);
            }
        }

        if ($amentitySearchIds != "") {
            foreach (explode("-", $amentitySearchIds) as $amenId) {
                $classInfos = $classInfos->where('gymInfo.gymAmenity.amenity_id', $amenId);
            }
        }
        if ($studioSearchIds != "") {
            foreach (explode("-", $studioSearchIds) as $studioId) {
                $classInfos = $classInfos->where('gymInfo.gymStudio.studio_id', $studioId);
            }
        }
        if ($locationSearchIds != "") {
            foreach (explode("-", $locationSearchIds) as $locationId) {
                $classInfos = $classInfos->where('gymInfo.gymLocation.location_id', $locationId);
            }
        }
    }
    public function setSearchClassWeb(Request $request)
    {
        $keyword     = $request->input('keyword');
        $requestDate = $request->input('classDate');
        $gid         = $request->input('gid');
        $cityValue   = $request->input('searchCity');
        //$requestDate = "2016-08-12";
        //$gid = 1;

        $classInfos = ClassModel::with(
            'gymInfo',
            'gymInfo.gymCategory',
            'gymInfo.gymActivity',
            'gymInfo.gymAmenity',
            'gymInfo.gymLocation',
            'gymInfo.gymStudio'
        );

        if (isset($cityValue) && $cityValue != "") {
            $classInfos = $classInfos->where('gymInfo.city', $cityValue);
        }

        if (isset($gid)) {
            $classInfos = $classInfos->where('gym', $gid);
        }
        if ($keyword != "") {
            $classInfos = $classInfos->where('name', 'like', '%' . $keyword . '%');
        }
        $upcomingDate       = $this->getUpcomingClass($classInfos, $requestDate);
        $classInfos         = $classInfos->where('class.date', '=', $requestDate);
        $classInfos         = $classInfos->where('class.date', '=', $requestDate);
        $classInfos         = $classInfos->get();
        $data               = $this->setMakeClassToArray($classInfos);
        $result             = [];
        $result['data']     = $data;
        $result['upcoming'] = $upcomingDate;
        return $result;
    }

    public function setMakeClassDetail($classInfo)
    {
        $data                = [];
        $gymInfo             = Gym::where('id', $classInfo->gym)->first();
        $classCategory       = CategoryClass::where('id', $classInfo->category)->first();
        $data['no']          = $classInfo->id;
        $data['gid']         = $classInfo->gym;
        $data['gymName']     = $gymInfo->name;
        $data['category']    = $classCategory->category;
        $data['description'] = $classInfo->description;
        $data['location']    = $classInfo->city;
        $data['lat']         = $classInfo->lat;
        $data['lon']         = $classInfo->lon;
        $data['name']        = $classInfo->name;
        $data['value']       = $classInfo->value;
        $data['date']        = $classInfo->date;
        $data['start']       = $classInfo->starthour;
        $data['end']         = $classInfo->endhour;
        $reviewInfos         = Review::with('consumer')->where('review.class_id', $classInfo->id)->get();
        $reviewData          = [];
        $sum                 = 0;
        $countReview         = count($reviewInfos);
        for ($i = 0; $i < $countReview; $i++) {
            $reviewItem                = [];
            $reviewInfo                = $reviewInfos[$i];
            $reviewItem['user']        = $reviewInfo->consumer->name;
            $reviewItem['description'] = $reviewInfo->description;
            $reviewItem['title']       = $reviewInfo->title;
            $reviewItem['date']        = $reviewInfo->date;
            $reviewItem['rating']      = $reviewInfo->star;
            $reviewItem['image']       = $reviewInfo->consumer->image;
            $sum                       = $sum + $reviewInfo->star;
            $reviewData[$i]            = $reviewItem;
        }
        $data['reviews'] = $reviewData;
        $data['rating']  = 0;
        if (count($reviewInfos) > 0) {
            $data['rating'] = (float) $sum / count($reviewInfos);
        }
        return $data;
    }

    public function setMakeClassToArray($classInfos)
    {
        $isLogin    = $this->isLogin();
        $dataArray  = [];
        $countInfos = count($classInfos);
        for ($i = 0; $i < $countInfos; $i++) {
            $classInfo               = $classInfos[$i];
            $dataItem                = [];
            $dataItem['gid']         = $classInfo->gymInfo->id;
            $dataItem['cid']         = $classInfo->id;
            $dataItem['gym']         = $classInfo->gymInfo->name;
            $dataItem['name']        = $classInfo->name;
            $dataItem['date']        = $classInfo->date;
            $dataItem['description'] = $classInfo->description;
            $dataItem['recurring']   = $classInfo->recurring;
            $dataItem['value']       = $classInfo->value;
            if ($isLogin) {
                $consumerNo         = \Session::get('consumer_no');
                $bookInfos          = Book::where('book.visitor_id', $consumerNo)
                ->where('book.class_id', $classInfo->id)->get();
                $dataItem['isBook'] = 0;
                if (count($bookInfos) > 0) {
                    $dataItem['isBook'] = 1;
                }
                $bookCount             = Book::where('book.class_id', $classInfo->id)->get();
                $dataItem['bookCount'] = count($bookCount);
            }
            $startHourArray = explode(":", $classInfo->starthour);
            $endHourArray   = explode(":", $classInfo->endhour);
            $hourDiff       = $endHourArray[0] - $startHourArray[0];
            $minDiff        = $endHourArray[1] - $startHourArray[1];
            if ($minDiff < 0) {
                $minDiff = 60 + $minDiff;
                $hourDiff--;
            }
            if ($hourDiff < 0) {
                $hourDiff = 24 + $hourDiff;
            }
            $dataItem['startHour'] = ($startHourArray[0]) . ":" . $startHourArray[1];
            $dataItem['duration']  = $hourDiff * 60 + $minDiff;

            $gymCategoryInfos = GymCategory::with('category')->where('gym_id', $classInfo->gym)->get();

            $dataItem['category'] = "";
            foreach ($gymCategoryInfos as $gymCategory) {
                $dataItem['category'] = $dataItem['category'] . $gymCategory->category . "&nbsp&nbsp";
            }
            $dataArray[$i] = $dataItem;
        }
        return $dataArray;
    }

    public function setMakeGymToArray($gymInfos)
    {
        $isLogin       = $this->isLogin();
        $dataArray     = [];
        $countGymInfos = count($gymInfos);
        for ($i = 0; $i < $countGymInfos; $i++) {
            $gymItem               = $gymInfos[$i];
            $dataItem              = [];
            $dataItem['gid']       = $gymItem->id;
            $dataItem['name']      = $gymItem->name;
            $dataItem['image']     = $gymItem->image;
            $dataItem['logo']      = $gymItem->logo;
            $dataItem['usability'] = $gymItem->usability;

            $startHours              = [];
            $endHours                = [];
            $closeDay                = [];
            $startHours[0]           = $gymItem->starthour_mon;
            $endHours[0]             = $gymItem->endhour_mon;
            $startHours[1]           = $gymItem->starthour_tue;
            $endHours[1]             = $gymItem->endhour_tue;
            $startHours[2]           = $gymItem->starthour_wed;
            $endHours[2]             = $gymItem->endhour_wed;
            $startHours[3]           = $gymItem->starthour_thu;
            $endHours[3]             = $gymItem->endhour_thu;
            $startHours[4]           = $gymItem->starthour_fri;
            $endHours[4]             = $gymItem->endhour_fri;
            $startHours[5]           = $gymItem->starthour_sat;
            $endHours[5]             = $gymItem->endhour_sat;
            $startHours[6]           = $gymItem->starthour_sun;
            $endHours[6]             = $gymItem->endhour_sun;
            $closeDay[0]             = $gymItem->close_mon;
            $closeDay[1]             = $gymItem->close_tue;
            $closeDay[2]             = $gymItem->close_wed;
            $closeDay[3]             = $gymItem->close_thu;
            $closeDay[4]             = $gymItem->close_fri;
            $closeDay[5]             = $gymItem->close_sat;
            $closeDay[6]             = $gymItem->close_sun;
            $dataItem['startHours']  = $startHours;
            $dataItem['endHours']    = $endHours;
            $dataItem['closeDay']    = $closeDay;
            $dataItem['description'] = $gymItem->description;
            $dataItem['city']        = "";
            $dataItem['reviews']     = "0";
            $dataItem['rating']      = "0";
            $dataItem['category']    = "";
            if ($isLogin) {
                $consumerNo         = \Session::get('consumer_no');
                $bookInfos          = BookGym::where('book_gym.visitor_id', $consumerNo)
                ->where('book_gym.gym_id', $gymItem->id)->get();
                $dataItem['isBook'] = 0;
                if (count($bookInfos) > 0) {
                    $dataItem['isBook'] = 1;
                }
            }
            $dataItem['city']    = $gymItem->city;
            $dataItem['address'] = $gymItem->address;
            $dataItem['lat']     = $gymItem->lat;
            $dataItem['lng']     = $gymItem->lon;
            $gymCategoryInfos    = GymCategory::with('category')->where('gym_category.gym_id', $gymItem->id)->get();
            $countGymCategory    = count($gymCategoryInfos);
            for ($j                   = 0; $j < $countGymCategory; $j++) {
                $dataItem['category'] =
                $dataItem['category'] . $gymCategoryInfos[$j]->category->category . "&nbsp&nbsp";
            }
            $gymReviewInfos      = Review::where('gym_id', $gymItem->id)->get();
            $dataItem['reviews'] = count($gymReviewInfos);
            $reviewInfos         = Review::with('consumer')->where('review.gym_id', $gymItem->id)->get();
            $reviewData          = [];
            $sum                 = 0;
            $countReviewInfos    = count($reviewInfos);
            for ($k = 0; $k < $countReviewInfos; $k++) {
                $reviewItem                = [];
                $reviewInfo                = $reviewInfos[$k];
                $reviewItem['user']        = $reviewInfo->consumer->name;
                $reviewItem['description'] = $reviewInfo->description;
                $reviewItem['title']       = $reviewInfo->title;
                $reviewItem['date']        = $reviewInfo->date;
                $reviewItem['rating']      = $reviewInfo->star;
                $reviewItem['image']       = $reviewInfo->image;
                $sum                       = $sum + $reviewInfo->star;
                $reviewData[$k]            = $reviewItem;
            }
            $dataItem['reviewData'] = $reviewData;
            $starSum                = 0;
            $countGymReview         = count($gymReviewInfos);
            for ($j = 0; $j < $countGymReview; $j++) {
                $starSum = $starSum + $gymReviewInfos[$j]->star;
            }
            if (count($gymReviewInfos) > 0) {
                $dataItem['rating'] = (float) $starSum / count($gymReviewInfos);
            }
            $dataArray[$i] = $dataItem;
        }
        return $dataArray;
    }
}
