<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\ClassModel;
use App\Model\Consumer;
use App\Model\Plan;
use App\Model\Book;

class Business extends Model
{
    protected $table = 'business';

    public function consumer()
    {
        return $this->hasMany('App\Model\Consumer', 'business_id');
    }
}
