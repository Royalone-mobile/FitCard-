<?php

namespace App\Engine;

use App\Model\Gym;
use App\Model\ClassModel;
use App\Model\Book;
use App\Model\Review;
use App\Model\BookGym;
use App\Model\Consumer;

class ServiceEngine extends EngineClass
{
    public function getRegisterConsumer($user, $password, $email)
    {
        $consumerInfos = Consumer::where('email', $email)->get();
        $now           = new \DateTime();
        $now->setTimezone(new \DateTimeZone('Europe/Helsinki'));
        $currentDate = $now->format('Y-m-d H:i:m');
        if (count($consumerInfos) > 0) {
            return "fail";
        }
        $insertStatus = Consumer::insertGetId(
            [
                'name'           => $user
                , 'email'        => $email
                , 'password'     => $password
                , 'registerdate' => $currentDate
                , 'plan'         => 4
            ]
        );

        return $insertStatus;
    }

    public function getLastVisitGym($consumerNo, $gid)
    {
        $book     = BookGym::where('visitor_id', $consumerNo)->where('gym_id', $gid)->orderby('date', 'desc')->get();
        $isBook   = false;
        $bookTime = "";
        if (count($book) > 0) {
            $isBook   = true;
            $bookTime = $book[0]->date;
        }

        return $bookTime;
    }

    public function isClassBook($consumerNo, $cid)
    {
        $book   = Book::where('visitor_id', $consumerNo)->where('class_id', $cid)->get();
        $isBook = 0;
        if (count($book) > 0) {
            $isBook = 1;
        }

        return $isBook;
    }

    public function initSearchClass($gid, $category, $city, $keyword)
    {
        if ($gid < 0) {
            $gid = "";
        }
        if ($category < 0) {
            $category = "";
        }
        if ($city < 0) {
            $city = "";
        }
        if ($keyword < 0) {
            $keyword = "";
        }
    }

    public function getLoadBooks($consumerNo)
    {
        $result  = [];
        $curTime = new \DateTime();
        $curTime->setTimezone(new \DateTimeZone('Europe/Helsinki'));
        $gymBooks   = BookGym::with('gym')->where('book_gym.visitor_id', $consumerNo)->orderBy('date', 'desc')
            ->get();
        $classInfos = Book::with('classModel', 'classModel.gymInfo')
            ->where('book.visitor_id', $consumerNo)->orderBy('date', 'desc')->get();
        //->where('date', '>=', $curTime->format('Y-m-d'))
        $durationArray   = [];
        $availableArray  = [];
        $countClassInfos = count($classInfos);
        for ($i = 0; $i < $countClassInfos; $i++) {
            $bookClass      = $classInfos[$i];
            $classInfo      = $bookClass->classModel;
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
            $durationArray[$i]  = $hourDiff * 60 + $minDiff;
            $booksCount         = Book::where('class_id', $classInfo->id)->get();
            $availableArray[$i] = $classInfo->value - count($booksCount);
        }
        $result['gyms']      = $gymBooks;
        $result['classes']   = $classInfos;
        $result['duration']  = $durationArray;
        $result['available'] = $availableArray;

        return $result;
    }

    public function setAddConditionSearchClass($classInfos, $gid, $category, $keyword, $city)
    {
        if ($gid != "") {
            $classInfos = $classInfos->where('gym', $gid);
        }
        if ($category != "") {
            $classInfos = $classInfos->where('category', $category);
        }
        if ($keyword != "") {
            $classInfos = $classInfos->where('name', 'like', '%' . $keyword . '%');
        }
        if ($city != "") {
            $this->searchCity = $city;
            $classInfos       = $classInfos->whereHas('gymInfo', function ($q) {
                $q->where('city', $this->searchCity);
            });
        }

        return $classInfos;
    }

    /**
     * @param     $date
     * @param     $gid
     * @param     $city
     * @param     $category
     * @param     $keyword
     * @param int $uid
     *
     * @return array
     */
    public function getSearchClass($date, $gid, $city, $category, $keyword, $uid = -1)
    {
        $result = [];

        if ($gid < 0) {
            $gid = "";
        }
        if ($category < 0) {
            $category = "";
        }
        if ($city < 0) {
            $city = "";
        }
        if ($keyword < 0) {
            $keyword = "";
        }

        $classInfos = ClassModel::with(
            'gymInfo',
            'category',
            'gymInfo.gymCategory',
            'gymInfo.gymActivity',
            'gymInfo.gymAmenity',
            'gymInfo.gymLocation',
            'gymInfo.gymStudio'
        );

        $classInfos = $classInfos->where('class.date', '=', $date);
        $classInfos = $this->setAddConditionSearchClass($classInfos, $gid, $category, $keyword, $city);
        $classInfos = $classInfos->get();

        $durationArray  = [];
        $availableArray = [];
        $bookArray      = [];

        foreach ($classInfos as $index => $classInfo) {
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

            $durationArray[]  = $hourDiff * 60 + $minDiff;
            $booksCount       = Book::where('class_id', $classInfo->id)->get();
            $bookArray[]      = $uid && $this->isBookedByUser($classInfo, $uid) ? 1 : 0;
            $availableArray[] = $classInfo->value - count($booksCount);
        }

        $result['classInfos']     = $classInfos;
        $result['durationArray']  = $durationArray;
        $result['availableArray'] = $availableArray;
        $result['upcomingDate']   = $this->getUpcomingDate($date, $gid, $city, $category, $keyword);
        $result['bookArray']      = $bookArray;

        return $result;
    }

    /**
     * Check if class is booked by user
     *
     * @param ClassModel $class
     * @param int        $userId
     *
     * @return bool
     */
    protected function isBookedByUser(ClassModel $class, $userId)
    {
        $bookings = Book::where('class_id', $class->id)->where('visitor_id', $userId)->get();

        return count($bookings) > 0;
    }

    /**
     * Get upcoming date for class
     *
     * @param string $date
     * @param int    $gid
     * @param string $city
     * @param string $category
     * @param string $keyword
     *
     * @return string
     */
    protected function getUpcomingDate($date, $gid, $city, $category, $keyword)
    {
        $classes = ClassModel::where('date', '>', $date);
        $classes = $this->setAddConditionSearchClass($classes, $gid, $category, $keyword, $city);

        $class = $classes->orderBy('date', 'asc')->first();

        return $class ? $class->date : '';
    }

    public function setReviewClass($title, $cid, $gid, $content, $star, $bookId, $id)
    {
        $date        = getdate(date("U"));
        $currentDate = $date['year'] . "-" . $date['mon'] . "-" . $date['mday'];
        Review::insert(
            [
                'visitor_id'    => $id
                , 'gym_id'      => $gid
                , 'description' => $content
                , 'date'        => $currentDate
                , 'star'        => $star
                , 'class_id'    => $cid
                , 'title'       => $title
            ]
        );
        $gymInfo = Gym::where('id', $gid)->get();
        $reviews = Review::where('gym_id', $gid)->get();
        $sum     = 0;
        foreach ($reviews as $review) {
            $sum = $sum + $review->star;
        }
        $rate = (float)$sum / count($reviews);
        Gym::where('id', $gid)->update(
            [
                'reviews' => $gymInfo[0]->reviews + 1,
                'rating'  => $rate
            ]
        );
        if ($cid == "-1") {
            BookGym::where('id', $bookId)->update(
                [
                    'review' => 1
                ]
            );

            return;
        }
        Book::where('id', $bookId)->update(
            [
                'review' => 1
            ]
        );
    }
}
