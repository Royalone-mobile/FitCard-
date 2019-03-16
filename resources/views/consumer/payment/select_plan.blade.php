@extends('layouts.consumer')

@section('content')
    <script>
        function selectPlan(id) {
            swal({
                text: "{{ trans('web.changeMember') }}",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ trans('web.yes') }}",
                cancelButtonText: "{{ trans('web.no') }}"
            }).then(function () {
                $('body').addClass("loading");
                $.get("/api/v1/payment/pay_with_token/" + id, function (data) {
                    if (data.success == true) {
                        document.location.href = '/consumer/payment/plans';
                    } else {

                    }
                    $('body').removeClass("loading");
                });
            })
        }
    </script>
    <div class="tp-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <ol class="breadcrumb">
                        <li><a href="#">{{ trans('web.home') }}</a></li>
                        <li class="active">{{ trans('web.pricing') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="main-container">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1>{{ trans('web.selectMembership') }}</h1>
                </div>
                <br>
                <form method="post" id="forgetForm" action='/consumer/actionCouponCode'>
                    <div class="form-group" style="display:inherit; margin-left:20px;">
                        <input id="forget_email" style="width:500px;display:inline;"
                               name="{{ trans('web.couponCode') }}"
                               type="text" placeholder="{{ trans('web.couponCode') }}" class="form-control input-md"
                               required/>
                        <button onclick="sendEmail()"
                                class="btn tp-btn-primary tp-btn-lg">{{ trans('web.submit') }}</button>
                    </div>
                </form>
            </div>
            <div class="row pricing-container" style="margin-top: 20px;">
                @foreach($plans as $plan)
                    <div class="col-md-4 pricing-box pricing-box-regualr">
                        <div class="well-box">
                            <h2 class="price-title">{{ $plan->plan }}</h2>
                            <h1 class="price-plan">
                                <span class="dollor-sign">€</span>{{ $plan->price }}<span class="permonth">/mo</span>
                            </h1>

                            <p>{{ $plan->credit }} {{ trans('web.creditMonth') }}</p>

                            @if(Auth::user()->paymentPlan == $plan)
                                <a href="#" class="btn tp-btn-primary">{{ trans('web.selected') }}</a>
                            @elseif(Auth::user()->hasCardToken())
                                <button style="height:31px;" onclick="selectPlan({{ $plan->id }})"
                                        class="btn tp-btn-default">{{ trans('web.selectPlan') }}</button>
                            @else
                                <a href="{{ route('consumer.payment.credit-card', $plan->id) }}"
                                   class="btn tp-btn-default">{{ trans('web.selectPlan') }}</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection