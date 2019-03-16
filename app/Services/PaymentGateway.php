<?php
namespace App\Services;

use App\Model\Payment;
use App\Model\User;
use Paybyway\Paybyway;
use Paybyway\PaybywayException;

/**
 * Payment Gateway
 *
 * Provides methods to make payments from customer to FitCard.
 */
class PaymentGateway
{
    /**
     * Maximum payment amount
     */
    const MAX_AMOUNT = 10000;

    /**
     * Payment currency
     */
    const CURRENCY = 'EUR';

    /**
     * @var Paybyway
     */
    protected $gateway;

    /**
     * @var User
     */
    protected $user;

    /**
     * @param Paybyway $paybyway
     * @param Payment  $payment
     */
    public function __construct(
        Paybyway $paybyway,
        Payment $payment
    ) {
        $this->gateway = $paybyway;
        $this->payment = $payment;
    }

    /**
     * Create charge request for given amount
     *
     * The result can be used to create actual transaction, when sent with credit card details
     * to the PayByWay API. The API will then respond with transaction result and "payment token",
     * which can be further used to create a "card token", which is used for recurring payments
     * in method ::chargeByToken.
     *
     * @return array|bool
     * @throws \Exception
     */
    public function createCharge()
    {
        $this->gateway->addCharge($this->getChargeDetails());
        $this->gateway->addPaymentMethod(['type' => 'card', 'register_card_token' => 1]);

        try {
            $response = $this->gateway->createCharge();

            if ($response->result !== 0) {
                throw new \Exception('Payment charge response not ok');
            }

            $this->payment->payment_token = $response->token;
            $this->payment->save();
        } catch (PaybywayException $exception) {
            throw new \Exception('Cannot create new charge request');
        }

        return [
            'token'       => $response->token,
            'payment_url' => Paybyway::API_URL . '/charge',
            'currency'    => self::CURRENCY,
            'amount'      => $this->payment->amount
        ];
    }

    /**
     * Make payment using stored card token
     *
     * See ::createCharge and ::getAndSaveCardToken, and the unit tests on how to retrieve
     * the card token, if it doesn't exist yet.
     *
     * @return bool
     * @throws \Exception
     */
    public function chargeByToken()
    {
        $this->verifyHasToken();

        $this->gateway->addCharge($this->getChargeDetails($this->payment->getUser()->card_token));
        $this->gateway->addPaymentMethod(['type' => 'card', 'register_card_token' => 0]);

        $response = $this->gateway->chargeWithCardToken();

        if ($response->result !== 0 || $response->settled !== 1) {
            throw new \Exception('Could not make recurring payment');
        }

        $this->payment->finalize();

        return true;
    }

    /**
     * Get card token from gateway for recurring payments
     *
     * If charge & pay with CC details was successful, then the payment token from it
     * can be used to retrieve a card token. The card token may be stored and re-used for
     * future payments.
     *
     * @param string $paymentToken
     *
     * @return bool
     * @throws \Exception
     */
    public function getAndSaveCardToken($paymentToken)
    {
        $result = $this->gateway->checkStatus($paymentToken);

        if (!isset($result->source->card_token)) {
            throw new \Exception('Cannot save card token for recurring payments - card token not received from gw!');
        }

        $this->payment->getUser()->card_token = $result->source->card_token;
        $this->payment->finalize();

        return $this->payment->getUser()->save();
    }

    /**
     * Get charge details for CC payment or "card token' payment
     *
     * If cardToken is specified, then can take a charge without CC details.
     *
     * @param null|string $cardToken
     *
     * @return array
     */
    protected function getChargeDetails($cardToken = null)
    {
        $this->verifyAmount($this->payment->amount);

        $details = [
            'order_number' => 'fitcard_u' . $this->payment->getUser()->id . '_' . time(),
            'amount'       => $this->payment->amount,
            'currency'     => 'EUR',
            'email'        => getenv("PAYMENT_RECEIVER_EMAIL")
        ];

        if ($cardToken) {
            $details['card_token'] = $cardToken;
        }

        return $details;
    }

    /**
     * Verify user has card token set, or throw exception
     *
     * @return bool
     * @throws \Exception
     */
    protected function verifyHasToken()
    {
        if (!$this->payment->getUser()->card_token) {
            throw new \Exception('User has no card token set');
        }

        return true;
    }

    /**
     * Verify charge amount is within reasonable bounds
     *
     * @param int $amount
     *
     * @return bool
     * @throws \Exception
     */
    protected function verifyAmount($amount)
    {
        if (!is_numeric($amount) || $amount < 0 || $amount > self::MAX_AMOUNT) {
            throw new \Exception('Payment amount is invalid or too big');
        }

        return true;
    }

    /**
     * Get the payment transaction model
     *
     * @return Payment
     */
    public function getPayment()
    {
        return $this->payment;
    }
}
