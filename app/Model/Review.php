<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'review';
    public function consumer()
    {
        return $this->belongsTo('App\Model\Consumer', 'visitor_id');
    }

    public function gym()
    {
        return $this->belongsTo('App\Model\Gym', 'gym_id');
    }
    public static function countReviews()
    {
        $reviews = Review::all();
        return count($reviews);
    }
    public static function getAverageRating()
    {
        $reviews = Review::all();
        $count   = 0;
        $sum     = 0;
        foreach ($reviews as $review) {
            $count++;
            $sum = $sum + $review->star;
        }
        return $sum / $count;
    }
    public static function getAllReviewInfos()
    {
        $reviewInfos = Review::with('consumer', 'gym', 'gym.classes')->get();
        return $reviewInfos;
    }
    public static function getRecentReviews()
    {
        $reviewInfos = Review::join('consumer', 'visitor_id', '=', 'consumer.id')
              ->limit(10)->orderby('date', 'desc')->get();
        return $reviewInfos;
    }
}
