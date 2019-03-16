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
use App\Model\GymCode;
use Illuminate\Support\Facades\Auth;

class ConsumerBookController extends ConsumerPageController
{

    public function actionCancelBook($bookid)
    {
        $conId = Auth::user()->id;
        $this->engine->cancelBook($bookid, $conId);
        \AlertSweet::success(trans('web.bookCancelled'))->autoclose(3000);
        return redirect('/consumer/books');
    }

    public function viewDetailGym($gid)
    {
        $isLogin   = $this->isLogin();
        $conId     = Auth::user()->id;
        $gymInfo   = Gym::where('id', $gid)->get();
        $classData = ClassModel::with('gymInfo')->where('gym', $gid)
                ->groupBy('class.id')->get();
        $gymData   = $this->engine->setMakeGymToArray($gymInfo);
        $classData = $this->engine->setMakeClassToArray($classData);
        $book      = BookGym::where('visitor_id', $conId)->where('gym_id', $gid)->orderby('date', 'desc')->get();
        $visitors  = BookGym::with('consumer')->where('gym_id', $gid)->get();
        $isBook    = false;
        $bookTime  = "";
        if (count($book) > 0) {
            $isBook   = true;
            $bookTime = $book[0]->date;
        }
        return view('index_consumer')->with('part', 'CONSUMER')->with('pageName', 'DETAILGYM')
                ->with('title', "FitCard Company")->with('isLogin', $isLogin)
                ->with('gymData', $gymData)->with('classData', $classData)
                ->with('bookTime', $bookTime)
                ->with('isBook', $isBook)->with('visitors', $visitors);
    }



    public function viewDetailClass($cid)
    {
        $conId       = Auth::user()->id;
        $isLogin     = $this->isLogin();
        $classInfo   = Gym::join('class', 'gym.id', '=', 'class.gym')
                ->where('class.id', $cid)->first();
        $classData   = $this->engine->setMakeClassDetail($classInfo);
        $visitorInfo = Book::join('consumer', 'book.visitor_id', '=', 'consumer.id')
                ->where('book.class_id', $cid)->get();
        $book        = Book::where('visitor_id', $conId)->where('class_id', $cid)->get();
        $bookCount   = Book::where('class_id', $cid)->get();
        $isBook      = false;
        if (count($book) > 0) {
            $isBook = true;
        }
        return view('index_consumer')->with('part', 'CONSUMER')->with('pageName', 'DETAILCLASS')
                ->with('title', "FitCard Company")->with('isLogin', $isLogin)
                ->with('classData', $classData)->with('visitors', $visitorInfo)
                ->with('isBook', $isBook)->with('bookCount', count($bookCount));
    }



    public function viewBooks()
    {
        $isLogin    = $this->isLogin();
        $conId      = Auth::user()->id;
        $userInfo   = Consumer::where('id', $conId)->first();
        $gymBooks   = BookGym::with('gym')->where('book_gym.visitor_id', $conId)->get();
        $classBooks = Book::with('classModel', 'classModel.gymInfo')->where('book.visitor_id', $conId)->get();
        return view('index_consumer')->with('part', 'CONSUMER')->with('pageName', 'MYBOOKS')
                ->with('title', "FitCard Company")->with('isLogin', $isLogin)
                ->with('userInfo', $userInfo)
                ->with('gymInfos', $gymBooks)
                ->with('classInfos', $classBooks);
    }

    public function actionBookGym($gid)
    {
        $conId = Auth::user()->id;
        $now   = new \DateTime();
        $now->setTimezone(new \DateTimeZone('Europe/Helsinki'));
        $currentDate = $now->format('Y-m-d H:i:m');
        $userData    = Consumer::where('id', $conId)->first();
        $gymInfo     = Gym::where('id', $gid)->first();
        if (0 < $userData->credit) {
            $credit = $userData->credit - 1;
            BookGym::insert(
                [
                            'visitor_id' => $conId
                            , 'gym_id' => $gid
                            , 'date' => $currentDate
                ]
            );
            Consumer::where('id', $conId)->update(
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

                    \AlertSweet::success(trans('message.successVisitGym') ."<br><br>"."Code:".$code[0]->code)
                        ->persistent(trans('message.shareFacebook'));

                    return redirect('/consumer/detailgym/' . $gid);
                }
                \AlertSweet::success(trans('message.successVisitGym'))->persistent(trans('message.shareFacebook'));
                return redirect('/consumer/detailgym/' . $gid);
            }
            \AlertSweet::success(trans('message.successVisitGym'))->persistent(trans('message.shareFacebook'));
            return redirect('/consumer/detailgym/' . $gid);
        }
        \AlertSweet::error(trans('message.notEnoughCredit'))->autoclose(5000);
        return back();
    }

    public function actionBookClass($cid)
    {
        $conId = Auth::user()->id;
        $now   = new \DateTime();
        $now->setTimezone(new \DateTimeZone('Europe/Helsinki'));
        $currentDate = $now->format('Y-m-d H:i:m');
        $classData   = ClassModel::where('class.id', $cid)->first();
        $countBook   = Book::where('class_id', $cid)->get();
        $userData    = Consumer::where('id', $conId)->first();
        if (count($countBook) >= $classData->value) {
            \AlertSweet::error(trans('message.fullBooked'))->autoclose(5000);
            return back();
        }
        if (0 < $userData->credit) {
            $credit = $userData->credit - 1;
            Book::insert(
                [
                    'visitor_id' => $conId
                    , 'class_id' => $cid
                    , 'date' => $currentDate
                ]
            );
            Consumer::where('id', $conId)->update(
                [
                'credit' => $credit
                ]
            );
            \AlertSweet::success(trans('message.successBookClass'))->persistent(trans('web.shareFaceBook')); //->autoclose(3000);
            return redirect('/consumer/detailclass/' . $cid);
        }
        \AlertSweet::error(trans('message.notEnoughCredit'))->autoclose(5000);
        return back();
    }


    public function ajaxSearchGym(Request $request)
    {
        $cityValue = strip_tags($request->input('searchCity'));
        $keyword   = strip_tags($request->input('keyword'));
        if (!isset($cityValue)) {
            $cityValue = "";
        }
        $data = $this->engine->searchGymWeb($cityValue, $keyword);
        return $data;
    }
    public function ajaxSearchClass(Request $request)
    {
        $data               = $this->engine->setSearchClassWeb($request);
        $result             = [];
        $result['vendors']  = $data['data'];
        $result['upcoming'] = $data['upcoming'];
        return $result;
    }
    public function actionCreateReview(Request $request)
    {
        $star    = 0;
        $title   = strip_tags($request->input('reviewtitle'));
        $cid     = strip_tags($request->input('class_id'));
        $gid     = strip_tags($request->input('gym_id'));
        $content = strip_tags($request->input('reviewcontent'));
        $star    = strip_tags($request->input('radio1'));
        if (!isset($star)) {
            $star = 0;
        }
        $date        = getdate(date("U"));
        $currentDate = $date['year'] . "-" . $date['mon'] . "-" . $date['mday'];
        if (($title == "" ) || ($content == "")) {
            \AlertSweet::error(trans('message.fillInput'))->autoclose(3000);
            return back();
        }
        Review::insert(
            [
                            'visitor_id' => Auth::user()->id
                            , 'gym_id' => $gid
                            , 'description' => $content
                            , 'date' => $currentDate
                            , 'star' => $star
                            , 'class_id' => $cid
                            , 'title' => $title
            ]
        );

        $gymInfo = Gym::where('id', $gid)->get();

        $reviews = Review::where('gym_id', $gid)->get();
        $sum     = 0;
        foreach ($reviews as $review) {
            $sum = $sum + $review->star;
        }
        $rate = (float) $sum / count($reviews);
        Gym::where('id', $gid)->update(
            [
                    'reviews' => $gymInfo[0]->reviews + 1,
                    'rating' => $rate
            ]
        );
        \AlertSweet::success(trans('message.leaveFeedback'))->autoclose(3000);
        if ($cid == "") {
            return redirect('/consumer/detailgym/' . $gid);
        }
        return redirect('/consumer/detailclass/' . $cid);
    }
}
