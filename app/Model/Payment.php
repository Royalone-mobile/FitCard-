<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Payment Transactions
 *
 * @property int       $id
 * @property int       $consumer_id
 * @property int       $plan_id
 * @property string    $payment_token
 * @property \DateTime $date
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property Consumer  $consumer
 * @property Plan      $plan
 */
class Payment extends Model
{
    const STATUS_DONE = 'done';
    /**
     * @var string
     */
    protected $table = 'payment';

    /**
     * @return HasOne
     */
    public function consumer()
    {
        return $this->hasOne(Consumer::class, 'id', 'consumer_id');
    }

    /**
     * @return BelongsTo
     */
    public function plan()
    {
        return $this->hasOne(Plan::class, 'id', 'plan_id');
    }

    /**
     * @return \App\Model\Consumer
     */
    public function getUser()
    {
        return $this->consumer;
    }

    /**
     * Find payment by payment token
     *
     * @param User   $user
     * @param string $paymentToken
     *
     * @return Payment
     */
    public static function findByToken(User $user, $paymentToken)
    {
        return self::where([
            ['consumer_id', $user->id],
            ['payment_token', $paymentToken]
        ])->firstOrFail();
    }

    /**
     * @param User $user
     * @param Plan $plan
     *
     * @return Payment
     */
    public static function createForPlan(User $user, Plan $plan)
    {
        $payment = new self;

        $payment->plan_id     = $plan->id;
        $payment->consumer_id = $user->id;
        $payment->date        = new \DateTime;
        $payment->amount      = $plan->price;
        $payment->credit      = $plan->credit;

        $payment->save();

        return $payment;
    }

    /**
     * Finalize payment, update user credits
     *
     * - also set payment status to done
     */
    public function finalize()
    {
        $this->consumer->credit     = $this->credit;
        $this->consumer->memberdate = new \DateTime;
        $this->consumer->plan_id    = $this->plan->id;

        if (!$this->consumer->save()) {
            throw new \Exception('Could not update user credits! Will not finalize payment transaction.');
        }

        $this->status = self::STATUS_DONE;
        $this->save();
    }
}
