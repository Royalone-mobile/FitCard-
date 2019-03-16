<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\ClassModel;
use App\Model\Book;

class GymLocation extends Model
{

    protected $table = 'gym_location';

    public function location()
    {
        return $this->hasOne('App\Model\Location');
    }

    public function gym()
    {
        return $this->hasOne('App\Model\Gym');
    }
}
