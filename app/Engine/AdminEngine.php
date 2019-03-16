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

class AdminEngine extends WebEngineClass
{
    public function getEditGym($gymNo, $result)
    {
        Gym::where('id', $gymNo)->update(
            $this->getUpdateGymArray($result)
        );
        GymActivity::where("gym_id", $gymNo)->delete();
        GymStudio::where("gym_id", $gymNo)->delete();
        GymLocation::where("gym_id", $gymNo)->delete();
        GymAmenity::where("gym_id", $gymNo)->delete();
        GymCategory::where("gym_id", $gymNo)->delete();

        $this->setAddOptionGymInfo(
            $result['gymActivityIds'],
            $result['gymStudioIds'],
            $result['gymAmentityIds'],
            $result['gymCategoryIds'],
            $result['gymLocationIds'],
            $gymNo
        );
    }
    public function getUpdateGymArray($result)
    {
        return [
        'name' => $result['name'], 'description' => $result['gymDescription'],
        'category' => 0, 'company' => $result['gymCompany'], 'location' => $result['city'],
        'joindate' => $result['currentDate'], 'totalcredit' => 0,
        'currentcredit' => 0,
        'bankaccount' => $result['gymBankAccount'],
        'image' => $result['image'], 'logo' => $result['image1'],
        'starthour_mon' => $result['data'] ['starthour_mon'],
         'endhour_mon' => $result['data'] ['endhour_mon'],
         'starthour_tue' => $result['data'] ['starthour_tue'],
          'endhour_tue' => $result['data'] ['endhour_tue'],
         'starthour_wed' => $result['data'] ['starthour_wed'],
         'endhour_wed' => $result['data'] ['endhour_wed'],
         'starthour_thu' => $result['data'] ['starthour_thu'],
         'endhour_thu' => $result['data'] ['endhour_thu'],
         'starthour_fri' => $result['data'] ['starthour_fri'],
         'endhour_fri' => $result['data'] ['endhour_fri'],
         'starthour_sat' => $result['data'] ['starthour_sat'],
         'endhour_sat' => $result['data'] ['endhour_sat'],
          'starthour_sun' => $result['data'] ['starthour_sun'],
        'endhour_sun' => $result['data'] ['endhour_sun'],
        'usability' => $result['gymUsa'],
        'country' => $result['country'], 'city' => $result['city'],
        'address' => $result['address'], 'lat' => $result['lat'], 'lon' => $result['lng'],
        'close_mon'=>$result['data']['close_mon'],
        'close_tue'=>$result['data']['close_tue'],
        'close_wed'=>$result['data']['close_wed'],
        'close_thu'=>$result['data']['close_thu'],
        'close_fri'=>$result['data']['close_fri'],
        'close_sat'=>$result['data']['close_sat'],
        'close_sun'=>$result['data']['close_sun'],
        'visitcode'=>$result['gymCode']
        ];
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
    public function getParamterGym(Request $request)
    {
        $gymImage       = strip_tags($request->input('gym_image'));
        $gymImage1      = strip_tags($request->input('gym_image1'));
        $gymName        = strip_tags($request->input('gym_name'));
        $gymCountry     = strip_tags($request->input('gym_country'));
        $gymCity        = strip_tags($request->input('gym_city'));
        $gymAddress     = strip_tags($request->input('gym_address'));
        $gymLat         = strip_tags($request->input('gym_lat'));
        $gymLng         = strip_tags($request->input('gym_lng'));
        $gymBankAccount = strip_tags($request->input('gym_bankaccount'));
        $gymDescription = strip_tags($request->input('gym_description'));
        $gymCompany     = strip_tags($request->input('gym_company'));
        $gymActivityIds = strip_tags($request->input('gym_activityid'));
        $gymAmentityIds = strip_tags($request->input('gym_amentityid'));
        $gymStudioIds   = strip_tags($request->input('gym_studioid'));
        $gymLocationIds = strip_tags($request->input('gym_locationid'));
        $gymCategoryIds = strip_tags($request->input('gym_categoryid'));
        $gymUsa         = strip_tags($request->input('gym_usability'));
        $gymCode        = strip_tags($request->input('visitCode'));
        $days           = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
        $data           = [];
        foreach ($days as $day) {
            $data['starthour_' . $day] = $this->changeTimeFormat(strip_tags($request->input('gym_starttime_' . $day)));
            $data['endhour_' . $day]   = $this->changeTimeFormat(strip_tags($request->input('gym_endtime_' . $day)));
            $data['close_'.$day]       = $request->input('gym_'.$day.'_close');
        }
        $data        = $this->setValidateCloseOption($data);
        $date        = getdate(date("U"));
        $currentDate = $date['year'] . "-" . $date['mon'] . "-" . $date['mday'];
        $citys       = City::where('city_name', $gymCity)->get();

        $result                   = [];
        $result['image']          = $gymImage;
        $result['image1']         = $gymImage1;
        $result['name']           = $gymName;
        $result['country']        = $gymCountry;
        $result['city']           = $gymCity;
        $result['address']        = $gymAddress;
        $result['lat']            = $gymLat;
        $result['lng']            = $gymLng;
        $result['gymBankAccount'] = $gymBankAccount;
        $result['gymDescription'] = $gymDescription;
        $result['gymCompany']     = $gymCompany;
        $result['gymActivityIds'] = $gymActivityIds;
        $result['gymAmenityIds']  = $gymAmentityIds;
        $result['gymStudioIds']   = $gymStudioIds;
        $result['gymLocationIds'] = $gymLocationIds;
        $result['gymCategoryIds'] = $gymCategoryIds;
        $result['gymUsa']         = $gymUsa;
        $result['citys']          = $citys;
        $result['currentDate']    = $currentDate;
        $result['data']           = $data;
        $result['gymAmentityIds'] = $gymAmentityIds;
        $result['gymActivityIds'] = $gymActivityIds;
        $result['gymStudioIds']   = $gymStudioIds;
        $result['gymLocationIds'] = $gymLocationIds;
        $result['gymCategoryIds'] = $gymCategoryIds;
        $result['gymCode']        = $gymCode;
        return $result;
    }


    public function getEditGymParameter($gid)
    {
        $companyInfos  = Company::all();
        $categoryInfos = Category::all();
        $activityInfos = Activity::all();
        $locationInfos = Location::all();
        $amentityInfos = Amenity::all();
        $studioInfos   = Studio::all();
        $cityInfos     = City::all();

        $gymInfo          = Gym::where('id', $gid)->first();
        $gymactivityInfos = GymActivity::where('gym_id', $gid)->get();
        $gymstudioInfos   = GymStudio::where('gym_id', $gid)->get();
        $gymamentityInfos = GymAmenity::where('gym_id', $gid)->get();
        $gymlocationInfos = GymLocation::where('gym_id', $gid)->get();
        $gymcategoryInfo  = GymCategory::where('gym_id', $gid)->get();

        $result = [];

        $result['companyInfos']     = $companyInfos;
        $result['categoryInfos']    = $categoryInfos;
        $result['activityInfos']    = $activityInfos;
        $result['locationInfos']    = $locationInfos;
        $result['amenityInfos']     = $amentityInfos;
        $result['studioInfos']      = $studioInfos;
        $result['cityInfos']        = $cityInfos;
        $result['gymInfos']         = $gymInfo;
        $result['gymactivityInfos'] = $gymactivityInfos;
        $result['gymamentityInfos'] = $gymamentityInfos;
        $result['gymcategoryInfo']  = $gymcategoryInfo;
        $result['gymstudioInfos']   = $gymstudioInfos;
        $result['gymlocationInfos'] = $gymlocationInfos;

        return $result;
    }
    public function getMonthPayment($companyInfo, $year, $month, $gymVisits, $classVisits)
    {
        $countVisits = 0;
        $countBook   = 0;
        if ($year != 'all') {
            $gymVisits   = $gymVisits->whereYear('date', '=', $year);
            $classVisits = $classVisits->whereYear('date', '=', $year);
        }
        if ($month != 'all') {
            $gymVisits   = $gymVisits->whereMonth('date', '=', $month);
            $classVisits = $classVisits->whereMonth('date', '=', $month);
        }
        $gymVisits   = $gymVisits->get();
        $classVisits = $classVisits->get();

        foreach ($gymVisits as $gymVisitInfo) {
            if ($gymVisitInfo->gym->company == $companyInfo->id) {
                $countVisits = $countVisits + 1;
            }
        }
        foreach ($classVisits as $classVisitInfo) {
            if ($classVisitInfo->classModel->gymInfo->company == $companyInfo->id) {
                $countBook = $countBook + 1;
            }
        }

        $item            = [];
        $item['gym']     = $countVisits;
        $item['class']   = $countBook;
        $item['company'] = $companyInfo->name;
        return $item;
    }
    public function setGenerateCouponCode($amount, $credit)
    {
        for ($i = 0; $i < $amount; $i++) {
            do {
                $code    = rand(10000000, 99999999);
                $isExist = Coupon::where('code', $code)->get();
            } while (count($isExist) > 0);
            Coupon::insert(
                [
                      'code' => $code,
                      'credit' => $credit
                ]
            );
        }
    }
    public function setValidateCloseOption($data)
    {
        $days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
        foreach ($days as $day) {
            if ($data['close_'.$day] == null) {
                $data['close_'.$day] = 0;
            } elseif ($data['close_'.$day] == "on") {
                $data['close_'.$day] = 1;
            }
        }
        return $data;
    }
    public function setAddOptionActivity($gymActivityIds, $gid)
    {
        if ($gymActivityIds != "") {
            foreach (explode("-", $gymActivityIds) as $id) {
                if ($id == "") {
                    continue;
                }
                GymActivity::insert(
                    [
                    'activity_id' => $id, 'gym_id' => $gid
                    ]
                );
            }
        }
    }
    private function setAddOptionStudio($gymStudioIds, $gid)
    {
        if ($gymStudioIds != "") {
            foreach (explode("-", $gymStudioIds) as $id) {
                if ($id == "") {
                    continue;
                }
                GymStudio::insert(
                    [
                    'studio_id' => $id, 'gym_id' => $gid
                    ]
                );
            }
        }
    }
    public function getIds($keyword, $activityList, $request)
    {
        $activitySearchIds = "";
        foreach ($activityList as $activity) {
            $field = $keyword . $activity->id;
            $tt    = $request->input($field);
            if (isset($tt)) {
                $activitySearchIds = $activitySearchIds . "-" . $activity->id;
            }
        }
        return $activitySearchIds;
    }
    private function setAddOptionAmenity($gymAmentityIds, $gid)
    {
        if ($gymAmentityIds != "") {
            foreach (explode("-", $gymAmentityIds) as $id) {
                if ($id == "") {
                    continue;
                }
                GymAmenity::insert(
                    [
                    'amenity_id' => $id, 'gym_id' => $gid
                    ]
                );
            }
        }
    }
    private function setAddOptionCategory($gymCategoryIds, $gid)
    {
        if ($gymCategoryIds != "") {
            foreach (explode("-", $gymCategoryIds) as $id) {
                if ($id == "") {
                    continue;
                }
                GymCategory::insert(
                    [
                    'category_id' => $id, 'gym_id' => $gid
                    ]
                );
            }
        }
    }
    public function setAddOptionGymInfo(
        $gymActivityIds,
        $gymStudioIds,
        $gymAmentityIds,
        $gymCategoryIds,
        $gymLocationIds,
        $gid
    ) {

        $this->setAddOptionActivity($gymActivityIds, $gid);
        $this->setAddOptionStudio($gymStudioIds, $gid);
        $this->setAddOptionAmenity($gymAmentityIds, $gid);
        $this->setAddOptionCategory($gymCategoryIds, $gid);
        $this->setAddOptionLocations($gymLocationIds, $gid);
    }
    private function setAddOptionLocations($gymLocationIds, $gid)
    {
        if ($gymLocationIds != "") {
            foreach (explode("-", $gymLocationIds) as $id) {
                if ($id == "") {
                    continue;
                }
                GymLocation::insert(
                    [
                    'location_id' => $id, 'gym_id' => $gid
                    ]
                );
            }
        }
    }
}
