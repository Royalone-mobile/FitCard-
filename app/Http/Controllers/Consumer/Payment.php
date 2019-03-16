<?php

namespace App\Http\Controllers\Consumer;

use App\Http\Controllers\Controller;
use App\Model\Plan;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class Payment extends Controller
{
    /**
     * Show page with CC form
     *
     * This is used to pay for a plan with CC details.
     *
     * @param Plan $plan
     *
     * @return View
     */
    public function creditCard(Plan $plan)
    {
        return view('consumer.payment.credit_card', ['plan' => $plan]);
    }

    /**
     * Show plan selection page
     *
     * @return View
     */
    public function plans()
    {
        $plans = Plan::listEnabled();

        /*
        if (Auth::user()->inInvoicePeriod()) {
            \AlertSweet::error(trans('message.invoicePeriod'))->autoclose(5000);

            return back();
        }
        */

        return view('consumer.payment.select_plan', ['plans' => $plans]);
    }
}
