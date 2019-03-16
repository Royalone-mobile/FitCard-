<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\ClassModel;
use App\Model\Book;
use App\Model\GymCode;

class GymBase extends Model
{
    protected $table = 'gym';


    protected function company()
    {
        return $this->belongsTo('App\Model\Company', 'company');
    }
    public function classes()
    {
        return $this->hasMany('App\Model\ClassModel', 'gym')->orderBy('date', 'asc');
    }
    public function gymCode()
    {
        return $this->hasMany('App\Model\GymCode', 'gym_id')->orderBy('use', 'asc');
    }
    public function bookgym()
    {
        return $this->hasMany('App\Model\BookGym', 'gym_id');
    }
    public function gymCategory()
    {
        return $this->hasMany('App\Model\GymCategory', 'gym_id');
    }
    public function gymActivity()
    {
        return $this->hasMany('App\Model\GymActivity', 'gym_id');
    }
    public function gymAmenity()
    {
        return $this->hasMany('App\Model\GymAmenity', 'gym_id');
    }
    public function gymStudio()
    {
        return $this->hasMany('App\Model\GymStudio', 'gym_id');
    }
    public function gymLocation()
    {
        return $this->hasMany('App\Model\GymLocation', 'gym_id');
    }

    public function reviewsGym()
    {
        return $this->hasMany('App\Model\Review', 'gym_id');
    }
    public function reviewsInfo()
    {
        return $this->hasMany('App\Model\Review', 'gym_id');
    }
}
