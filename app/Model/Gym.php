<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\ClassModel;
use App\Model\Book;
use App\Model\GymBase;

class Gym extends GymBase
{

    public static function countVisitCompany($accountNo)
    {
        $gym = Gym::with('bookgym')->where('company', $accountNo)->get();
        if ($gym == null) {
            return 0;
        }
        $sum = 0;
        foreach ($gym as $gymInfo) {
            $sum = $sum + count($gymInfo->bookgym);
        }
        return $sum;
    }

    public static function averageRate()
    {
        $gyms     = Gym::with('reviewsGym')->get();
        $rat      = 0;
        $countGym = count($gyms);
        $k        = 0;
        if (count($gyms) > 0) {
            for ($i = 0; $i < $countGym; $i++) {
                $countBook = count($gyms[$i]->reviewsGym);
                for ($j = 0; $j < $countBook; $j++) {
                    $k++;
                    $rat = $rat + $gyms[$i]->reviewsGym[$j]->star;
                }
            }
            if ($k > 0) {
                $rat = (float) $rat / $k;
            }
        }
        return $rat;
    }
    public function deleteRelation()
    {
        $classes = ClassModel::with('classes')->where('gym', $this->id)->get();
        foreach ($classes as $classItem) {
            $classItem->deleteRelation();
        }
        $books = BookGym::where('gym_id', $this->id)->get();
        foreach ($books as $book) {
            $book->delete();
        }
        $reviews = Review::where('gym_id', $this->id)->get();
        foreach ($reviews as $review) {
            $review->delete();
        }
        GymActivity::where('gym_id', $this->id)->delete();
        GymCategory::where('gym_id', $this->id)->delete();
        GymAmenity::where('gym_id', $this->id)->delete();
        GymLocation::where('gym_id', $this->id)->delete();
        GymStudio::where('gym_id', $this->id)->delete();

        $this->delete();
    }
    public static function deleteGym($gid)
    {
        $gym = Gym::where('id', $gid)->first();
        $gym->deleteRelation();
    }
    public function countReviewGym()
    {
        return count($this->reviews);
    }
}
