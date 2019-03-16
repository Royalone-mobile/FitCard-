<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plan';

    public static function savePlan($name, $price, $credit, $planId)
    {
        Plan::where('id', $planId)->update(
            [
                'plan' => $name
                , 'price' => $price
                , 'credit' => $credit
            ]
        );
    }

    /**
     * @return Plan[]
     */
    public static function listEnabled()
    {
        return self::where('enabled', true)->orderBy('credit')->get();
    }
}
