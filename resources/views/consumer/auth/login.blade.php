@extends('layouts.consumer')

@section('content')
    <!-- Breadcrumbs -->
    <div class="tp-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/') }}">{{ trans('web.home') }}</a></li>
                        <li class="active">{{ trans('web.login') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Login page content -->
    <div class="main-container">
        <div class="container">
            <div class="row">
                <div class="col-md-12 tp-title-center"><h1> {{ trans('web.welcomeLogin') }}</h1>
                    <p></p>
                </div>
            </div>
            <div class="col-md-offset-3 col-md-6 st-tabs">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#home" aria-controls="home" style="color: #2798c6;" role="tab" data-toggle="tab">
                            {{ trans('web.consumerLogin') }}
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content ">
                    <div role="tabpanel" class="tab-pane active vendor-login" id="home">
                        <form method="post" id="vendorLogin" action="{{ url('/login') }}">
                        {{ csrf_field() }}
                            <!-- Username (email) input-->
                            <div class="form-group">
                                <label class="control-label" for="email">{{ trans('web.email') }}<span
                                            class="required">*</span></label>
                                <input id="consumer_email" name="email" type="email"
                                       placeholder="{{ trans('web.email') }}" class="form-control input-md"
                                       required>
                            </div>

                            <!-- Password input-->
                            <div class="form-group">
                                <label class="control-label" for="password">{{ trans('web.password') }}<span
                                            class="required">*</span></label>
                                <input id="consumer_password" name="password" type="password"
                                       placeholder="{{ trans('web.password') }}" class="form-control input-md"
                                       required>
                            </div>

                            <!-- Forgot password link -->
                            <div class="row" style="margin-right: 0;">
                                <div class="form-group">
                                    <a href="{{ route('consumer.auth.forgot') }}" class="pull-right">
                                        <small>{{ trans('web.forgetPassword') }}</small>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group">
                                <!-- Login submit button -->
                                <input type="submit" style="width: 200px;" class="btn tp-btn-default tp-btn-lg"
                                    value="{{ trans('web.login') }}">

                                <!-- Facebook login button -->
                                <a href="{{ route('consumer.auth.login.facebook') }}"
                                   class="pull-right btn tp-btn-default tp-btn-lg">
                                    {{ trans('web.loginFacebook') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection