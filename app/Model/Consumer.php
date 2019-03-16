<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\ClassModel;
use App\Model\Book;

class Consumer extends Model
{

    protected $table = 'consumer';

    public function plan()
    {
        return $this->hasOne('App\Model\Plan');
    }
}
