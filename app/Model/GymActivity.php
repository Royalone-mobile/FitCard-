<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\ClassModel;
use App\Model\Book;

class GymActivity extends Model
{

    protected $table = 'gym_activity';

    public function activity()
    {
        return $this->hasOne('App\Model\Activity');
    }

    public function gym()
    {
        return $this->hasOne('App\Model\Gym');
    }
}
