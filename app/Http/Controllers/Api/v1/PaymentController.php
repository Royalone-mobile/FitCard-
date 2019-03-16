<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\ApiController;
use App\Model\Payment;
use App\Model\Plan;
use App\Services\PaymentGateway;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Paybyway\Paybyway;
use AlertSweet;

/**
 * Provide payment functionality to customers
 */
class PaymentController extends ApiController
{
    /**
     * Create new charge for making payment
     *
     * The response of this call can be used to make another call towards
     * the payment gateway with added credit card details.
     *
     * @param Plan $plan
     *
     * @return JsonResponse
     */
    public function createCharge(Plan $plan)
    {
        $payment        = Payment::createForPlan(Auth::user(), $plan);
        $paymentGateway = $this->getGateway($payment);

        try {
            $result = $paymentGateway->createCharge();
        } catch (\Exception $exception) {
            $result = ['error' => $exception->getMessage()];
        }

        return response()->json($result);
    }

    /**
     * Charge for plan change, using saved card_token
     *
     * @param Plan $plan
     *
     * @return JsonResponse
     */
    public function payWithToken(Plan $plan)
    {
        $payment        = Payment::createForPlan(Auth::user(), $plan);
        $paymentGateway = $this->getGateway($payment);

        try {
            if (!$paymentGateway->chargeByToken()) {
                throw new \Exception('Could not pay with token');
            }
            AlertSweet::success(trans('message.membershipChanged'))->autoclose(3000);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Check if payment was successful
     *
     * This call also saves the card token for later use in recurring payments.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function paymentSuccessful(Request $request)
    {
        $this->validate($request, [
            'payment_token' => 'required|string|size:40',
        ]);

        $paymentToken   = $request->get('payment_token');
        $payment        = Payment::findByToken(Auth::user(), $paymentToken);
        $paymentGateway = $this->getGateway($payment);

        try {
            $result = $paymentGateway->getAndSaveCardToken($paymentToken);
            AlertSweet::success(trans('message.membershipChanged'))->autoclose(3000);
            return response()->json(['success' => $result]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    /**
     * Get the Payment Gateway object for current logged in user
     *
     * @param Payment $payment
     *
     * @return PaymentGateway
     */
    protected function getGateway(Payment $payment)
    {
        $paymentGateway = new PaymentGateway(
            new Paybyway(getenv("PAYMENT_API_KEY"), getenv("PAYMENT_PRIVATE_KEY")),
            $payment
        );

        return $paymentGateway;
    }
}
