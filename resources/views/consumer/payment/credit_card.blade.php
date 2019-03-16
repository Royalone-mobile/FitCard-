@extends('layouts.consumer')

@section('content')
    <div class="tp-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <ol class="breadcrumb">
                        <li><a href="/">{!! trans('web.home') !!}</a></li>
                        <li class="active">{!! trans('web.chargeFund') !!}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="main-container">
        <div class="container">
            <div class="row">
                <div class="col-md-12 tp-title-center">
                    <h1>{!! trans('web.chargeFund') !!}</h1>
                </div>
            </div>
            <div class="col-md-offset-3 col-md-6 well-box">
                <form id="credit-card-form" method="post" action="?" role="form" autocomplete="off">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                    <div class="row">
                        <div class="col-xs-12">
                            <h2>{!! trans('web.creditCardPayment') !!}</h2>
                            <div class="form-group">
                                <label for="cardNumber">{!! trans('web.cardNumber') !!}</label>
                                <input type="number" id="cardNumber" name="cardNumber" maxlength="30"
                                       placeholder="{!! trans('web.cardNumber') !!}" class="form-control" required/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="expMonth">{!! trans('web.month') !!}</label>
                                <select id="expMonth" name="expMonth" class="form-control card-exp-month" required>
                                    <option>01</option>
                                    <option>02</option>
                                    <option>03</option>
                                    <option>04</option>
                                    <option>05</option>
                                    <option>06</option>
                                    <option>07</option>
                                    <option>08</option>
                                    <option>09</option>
                                    <option>10</option>
                                    <option>11</option>
                                    <option>12</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="expYear">{!! trans('web.year') !!}</label>
                                <select id="expYear" name="expYear" class="form-control card-exp-year" required>
                                    <option>2015</option>
                                    <option>2016</option>
                                    <option>2017</option>
                                    <option>2018</option>
                                    <option>2019</option>
                                    <option>2020</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="cvv">{!! trans('web.cvv') !!}</label>
                                <input type="number" name="cvv" id="cvv" maxlength="4" class="form-control"
                                       placeholder="{!! trans('web.cvv') !!}" required/>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="cvv">{!! trans('web.amount') !!}</label>
                                <input type="number" id="amount" maxlength="4" class="form-control" disabled
                                       value="{{ $plan->price }}" placeholder="{!! trans('web.amount') !!}"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <input type="submit" id="cc-form-button"
                                       class="btn tp-btn-primary tp-btn-lg form-control"
                                       value="{!! trans('web.pay') !!}"/>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{ Html::script('js/consumer/payment.js') }}
@endsection