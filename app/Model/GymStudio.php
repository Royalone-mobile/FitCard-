<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\ClassModel;
use App\Model\Book;

class GymStudio extends Model
{

    protected $table = 'gym_studio';

    public function studio()
    {
        return $this->hasOne('App\Model\Studio');
    }

    public function gym()
    {
        return $this->hasOne('App\Model\Gym');
    }
}
