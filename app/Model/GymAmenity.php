<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\ClassModel;
use App\Model\Book;

class GymAmenity extends Model
{
    protected $table = 'gym_amenity';

    public function amenity()
    {
        return $this->hasOne('App\Model\Amenity');
    }

    public function gym()
    {
        return $this->hasOne('App\Model\Gym');
    }
}
