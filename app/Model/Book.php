<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    protected $table = 'book';

    public static function totalVisit()
    {
        $visits = Book::all();
        return count($visits);
    }

    public function consumer()
    {
        return $this->belongsTo('App\Model\Consumer', 'visitor_id');
    }
    public function gym()
    {
        return $this->belongsTo('App\Model\Gym', 'gym_id');
    }
    public function classModel()
    {
        return $this->belongsTo('App\Model\ClassModel', 'class_id');
    }

    public function visits()
    {
        return $this->hasManyThrough('App\Model\ClassModel', 'App\Model\Gym');
    }

    public static function allVisitCount()
    {
        $books = Book::all();
        return count($books);
    }
}
