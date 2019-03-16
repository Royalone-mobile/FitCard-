<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    protected $table = 'class';

    public function gymInfo()
    {
        return $this->belongsTo('App\Model\Gym', 'gym');
    }
    public function book()
    {
        return $this->hasMany('App\Model\Book', 'class_id');
    }
    public function category()
    {
        return $this->belongsTo('App\Model\Category', 'category');
    }
}
