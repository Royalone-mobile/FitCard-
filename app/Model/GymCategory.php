<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\ClassModel;
use App\Model\Book;

class GymCategory extends Model
{
    protected $table = 'gym_category';

    public function category()
    {
        return $this->belongsTo('App\Model\Category', 'category_id');
    }

    public function gym()
    {
        return $this->hasOne('App\Model\Gym');
    }
}
