<?php
namespace App\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int       $id
 * @property string    $name
 * @property string    $email
 * @property string    $password
 * @property int       $credit
 * @property int       $plan
 * @property \DateTime $registerdate
 * @property \DateTime $memberdate
 * @property string    $image
 * @property string    $city
 * @property string    $phone
 * @property string    $address
 * @property string    $zip
 * @property float     $fund
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property string    $card_token
 * @property Plan      $paymentPlan
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * @var string
     */
    protected $table = 'consumer';

    /**
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'payment_token'];

    /**
     * @return HasOne
     */
    public function paymentPlan()
    {
        return $this->hasOne(Plan::class, 'id', 'plan_id');
    }

    /**
     * @return bool
     */
    public function hasCardToken()
    {
        return $this->card_token ? true : false;
    }

    /**
     * @return bool
     */
    public function inInvoicePeriod()
    {
        return $this->invoice_end > new \DateTime;
    }
}
