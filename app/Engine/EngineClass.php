<?php

namespace App\Engine;

use App\Model\Gym;
use App\Model\Book;
use App\Model\Consumer;
use App\Model\Coupon;

class EngineClass extends BaseEngine
{

    use \Illuminate\Foundation\Bus\DispatchesJobs;

    protected $searchCity;
    public $activityArray;
    public $amenityArray;
    public $studioArray;
    public $locationArray;

    public function setEmail($targetEmail, $subject, $message)
    {
        $this->dispatch(new \App\Jobs\SendEmail([
            'message' => $message,
            'email'   => $targetEmail, 'title' => $subject, 'content' => $message
        ]));
    }

    public function getTopGyms()
    {
        $gymInfos = Gym::limit(3)->orderby('reviews', 'desc')->get();

        return $gymInfos;
    }

    public function setJavascriptString($slashString)
    {
        return '"' . addcslashes($slashString, "\0..\37\"\\") . '"';
    }

    public function setJavascriptArray($array)
    {
        $temp = array_map([$this, 'setJavascriptString'], $array);

        return '[' . implode(',', $temp) . ']';
    }

    public function isLogin()
    {
        $consumerNo = \Session::get('consumer_no');
        if ($consumerNo == "") {
            return false;
        }

        return true;
    }

    public function getSearchGym($city, $keyword, $activityIds, $amenityIds, $studioIds, $locationIds)
    {
        if (isset($activityIds, $amenityIds, $studioIds, $locationIds)) {
            // unused variables
        }

        if ($city < 0) {
            $city = "";
        }
        if ($keyword < 0) {
            $keyword = "";
        }
        $gymInfos = Gym::with('gymActivity', 'gymAmenity', 'gymLocation', 'gymStudio');
        if ($city != "") {
            $gymInfos = $gymInfos->where('gym.city', $city);
        }
        if ($keyword != "") {
            $gymInfos = $gymInfos->where('gym.name', 'like', '%' . $keyword . '%');
        }
        $gymInfos = $gymInfos->select()->groupBy('gym.id')->get();

        return $gymInfos;
    }

    public function couponProcess($couponInfo, $consumerId)
    {
        if (count($couponInfo) == 0) {
            return 0;
        }
        Coupon::where('id', $couponInfo[0]->id)->update(['use' => '1']);
        $now = new \DateTime();
        $now->setTimezone(new \DateTimeZone('Europe/Helsinki'));
        $currentDate = $now->format('Y-m-d H:i:m');
        Consumer::where('id', $consumerId)->update(
            [
                'memberdate' => $currentDate,
                'credit'     => $couponInfo[0]->credit,
            ]
        );

        return 1;
    }

    public function getAfterOneMonthDate($baseDate)
    {
        $date = date('Y-m-d', strtotime($baseDate . '+1 months'));
        if (date('d') == 31 || (date('m') == 1 && date('d') > 28)) {
            $date = date('Y-m-d', strtotime($baseDate . 'last day of next month'));
        }

        return $date;
    }

    public function getUpcomingClass($classInfos, $requestDate)
    {
        $classInfos1 = clone $classInfos;

        $upcomingDate = "";
        $classInfos1  = $classInfos1->where('class.date', '>', $requestDate);
        $classInfos1  = $classInfos1->orderBy('date', 'asc')->first();

        if ($classInfos1 != null) {
            $upcomingDate = $classInfos1->date;
        }

        return $upcomingDate;
    }

    public function cancelBook($id, $uid)
    {
        Book::where('id', $id)->delete();
        $user = Consumer::where('id', $uid)->first();
        Consumer::where('id', $uid)->update(
            [
                'credit' => $user->credit + 1
            ]
        );
    }
}
