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
use App\Engine\WebEngineClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsumerController extends Controller
{

    public $engine;

    public function __construct()
    {
        $this->engine = new WebEngineClass();
        $lang         = \Session::get('language');
        \App::setLocale('en');
        $this->engine->changeLanguage($lang);
    }

    /**
     * @return bool
     */
    protected function isLogin()
    {
        return Auth::check();
    }

    public function actionInviteFriend(Request $request)
    {
        $emailForget = strip_tags($request->input('forget_email'));
        $code        = trans('message.inviteEmailContent');
        $target      = $emailForget;
        $subject     = trans('message.inviteEmail');
        $this->engine->setEmail($target, $subject, $code);
        \AlertSweet::success(trans('message.inviteFriend'))->autoclose(3000);
        return redirect('/consumer');
    }

    public function ajaxClassCount($bDate)
    {
        $requestDate = $bDate;
        $classInfos  = ClassModel::with(
            'gymInfo',
            'gymInfo.gymCategory',
            'gymInfo.gymActivity',
            'gymInfo.gymAmenity',
            'gymInfo.gymLocation',
            'gymInfo.gymStudio'
        );
        $classInfos  = $classInfos->where('class.date', '=', $requestDate);
        $classInfos  = $classInfos->groupBy('class.id')->get();
        $data        = $this->engine->setMakeClassToArray($classInfos);
        return $data;
    }

    public function ajaxUploadConsumerLogo(Request $request)
    {
        $conId         = \Session::get('consumer_no');
        $file          = $request->file('uploadLogo');
        $thumbFilename = $this->engine->setUploadFile($file, $conId, "/uploads/consumer/"); //200
        $json          = [
            "path" => $thumbFilename
        ];
        echo json_encode($json);
    }
}
