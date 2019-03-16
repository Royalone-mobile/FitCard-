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

class ConsumerUserController extends ConsumerController
{

    public function actionChangeLanguage($id)
    {
        $this->engine->changeLanguage($id);
        \Session::put('language', $id);
        return back();
    }
    public function actionPostFacebook()
    {
        \AlertSweet::success(trans('message.postedOnFacebook'))->autoclose(3000);
        return $this->viewDetailGymAgain();
    }
    private function viewDetailGymAgain()
    {
        $gid       = \Session::get('book_gym');
        $isLogin   = $this->isLogin();
        $conId     = Auth::user()->id;
        $gymInfo   = Gym::where('id', $gid)->get();
        $classData = ClassModel::with('gym')->where('gym', $gid)
                ->select()
                ->groupBy('class.id')->get();
        $gymData   = $this->engine->setMakeGymToArray($gymInfo);
        $classData = $this->engine->setMakeClassToArray($classData);
        $book      = BookGym::where('visitor_id', $conId)->where('gym_id', $gid)->get();
        $visitors  = BookGym::with('consumer')->where('gym_id', $gid)->get();
        $isBook    = false;
        if (count($book) > 0) {
            $isBook = true;
        }
        return view('index_consumer')->with('part', 'CONSUMER')->with('pageName', 'DETAILGYM')
                ->with('title', "FitCard Company")->with('isLogin', $isLogin)
                ->with('gymData', $gymData)->with('classData', $classData)
                ->with('isBook', $isBook)->with('visitors', $visitors);
    }

    public function actionUpdateProfile(Request $request)
    {
        $conId   = Auth::user()->id;
        $email   = strip_tags($request->input('profile_name'));
        $phone   = strip_tags($request->input('profile_phone'));
        $city    = strip_tags($request->input('profile_city'));
        $address = strip_tags($request->input('profile_address'));
        $zipcode = strip_tags($request->input('profile_zip'));
        $image   = strip_tags($request->input('profile_image'));
        Consumer::where('id', $conId)->update(
            [
            'phone' => $phone
            , 'name' => $email
            , 'city' => $city
            , 'zip' => $zipcode
            , 'image' => $image
            , 'address' => $address
            ]
        );
        \AlertSweet::success(trans("message.profileUpdated"))->autoclose(3000);
        return redirect('/consumer/profile');
    }
    public function viewProfile()
    {
        $isLogin  = $this->isLogin();
        $conId    = Auth::user()->id;
        $userInfo = Consumer::where('id', $conId)->first();
        return view('index_consumer')->with('part', 'CONSUMER')->with('pageName', 'PROFILE')
                ->with('title', "FitCard Company")->with('isLogin', $isLogin)
                ->with('userInfo', $userInfo);
    }
}
