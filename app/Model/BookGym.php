<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\ClassModel;
use App\Model\Book;

class BookGym extends Model
{

    protected $table = 'book_gym';

    public function gym()
    {
        return $this->belongsTo('App\Model\Gym', 'gym_id');
    }
    public function consumer()
    {
        return $this->belongsTo('App\Model\Consumer', 'visitor_id');
    }
}
