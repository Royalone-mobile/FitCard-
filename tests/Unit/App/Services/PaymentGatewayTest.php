<?php

namespace Tests\Unit\App\Services;

use App\Model\Payment;
use App\Services\PaymentGateway;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Paybyway\Paybyway;
use Tests\TestCase;

/**
 * @coversDefaultClass \App\Services\PaymentGateway
 */
class PaymentGatewayTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * PayByWay test account API key
     */
    const TEST_API_KEY = '1479b9f75750d648dcb847520bc1e44291be';

    /**
     * PayByWay test account private key
     */
    const TEST_PRIVATE_KEY = '02f965b2b85264713826bbd81d0847a5';

    /**
     * @test
     * @covers ::__construct
     */
    public function can_init_object()
    {
        $paymentGateway = $this->initGateway();

        $this->assertInstanceOf(PaymentGateway::class, $paymentGateway);
    }

    /**
     * @test
     * @covers ::createCharge
     * @covers ::getChargeDetails
     */
    public function can_create_charge()
    {
        $paymentGateway = $this->initGateway();

        $result = $paymentGateway->createCharge();

        $this->assertTrue(strlen($result['token']) == 40);
        $this->assertStringStartsWith('https://www.paybyway.com/', $result['payment_url']);
        $this->assertSame(PaymentGateway::CURRENCY, $result['currency']);
        $this->assertSame($paymentGateway->getPayment()->amount, $result['amount']);
    }

    /**
     * Make sure can actually pay with created charge
     *
     * This kind of request is usually made in the front-end, directly towards the payment gateway.
     *
     * @test
     * @covers ::createCharge
     */
    public function can_make_payment()
    {
        $paymentGateway = $this->initGateway();

        $decoded = $this->makePayment($paymentGateway->createCharge());

        $this->assertSame(0, $decoded['result']);
    }

    /**
     * @test
     * @covers ::getAndSaveCardToken
     */
    public function can_save_card_token_for_recurring_payments()
    {
        $paymentGateway = $this->initGateway();
        $this->makePaymentSaveCardToken($paymentGateway);

        $this->assertTrue(strlen($paymentGateway->getPayment()->getUser()->card_token) === 40);
    }

    /**
     * @test
     * @covers ::chargeByToken
     */
    public function can_make_recurring_payment_with_token()
    {
        $paymentGateway = $this->initGateway();
        $this->makePaymentSaveCardToken($paymentGateway);

        $result = $paymentGateway->chargeByToken();

        $this->assertTrue($result);
    }

    /**
     * @return PaymentGateway
     */
    protected function initGateway()
    {
        $user = $this->createTestUser();
        $plan = $this->createTestPlan();

        $payment              = new Payment;
        $payment->consumer_id = $user->id;
        $payment->plan_id     = $plan->id;
        $payment->date        = new \DateTime;
        $payment->amount      = $plan->price;
        $payment->credit      = $plan->credit;
        $payment->save();

        $paymentGateway = new PaymentGateway(
            new Paybyway(self::TEST_API_KEY, self::TEST_PRIVATE_KEY),
            $payment
        );

        return $paymentGateway;
    }

    /**
     * @param array $charge
     *
     * @return array
     */
    protected function makePayment($charge)
    {
        $parameters = [
            'amount'        => $charge['amount'],
            'card'          => '4012888888881881',
            'currency'      => $charge['currency'],
            'exp_month'     => '01',
            'exp_year'      => date('Y', strtotime('+ 1 YEAR')),
            'security_code' => '123',
            'token'         => $charge['token']
        ];

        $client   = new Client;
        $response = $client->post(
            $charge['payment_url'],
            [
                'form_params' => $parameters
            ]
        );

        $decoded = json_decode($response->getBody(), JSON_OBJECT_AS_ARRAY);

        return $decoded;
    }

    /**
     * @param PaymentGateway $paymentGateway
     */
    protected function makePaymentSaveCardToken(PaymentGateway $paymentGateway)
    {
        $result = $paymentGateway->createCharge();

        $paymentResult = $this->makePayment($result);
        $this->assertSame(0, $paymentResult['result']);

        $paymentGateway->getAndSaveCardToken($result['token']);
    }
}
