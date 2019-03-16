<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';

    public function gym()
    {
        return $this->hasMany('App\Model\Gym', 'id');
    }
    public function classes()
    {
        return $this->hasMany('App\Model\ClassModel', 'gym');
    }
    public function book()
    {
        return $this->hasMany('App\Model\Book', 'class_id');
    }
    public function deleteRelation()
    {
        $gyms = $this->gym;
        foreach ($gyms as $gym) {
            $gym->deleteRelation();
        }
        $this->delete();
    }
    public static function deleteCompany($cid)
    {
        $company = Company::with('gym')->where('id', $cid)->first();
        $company->deleteRelation();
    }
    public static function countReviewsCompany($accountNo)
    {
        $company = Company::where('id', $accountNo)->first();
        $gyms    = $company->gym;
        $sum     = 0;
        foreach ($gyms as $gym) {
            $sum = $sum + $gym->reviews;
        }
        return $sum;
    }
}
