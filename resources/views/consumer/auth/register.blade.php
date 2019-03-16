@extends('layouts.consumer')

@section('content')
    <!-- Breadcrumbs -->
    <div class="tp-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/') }}">{{ trans('web.home') }} </a></li>
                        <li class="active">{{ trans('web.register') }} </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration page content -->
    <div class="main-container">
        <div class="container">
            <div class="row">
                <div class="col-md-12 tp-title-center">
                    <h1>{{ trans('web.welcomeRegister') }}</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 singup-couple">
                    <div class="well-box">
                        <form action="/register" method="post">
                            {{ csrf_field() }}

                            <!-- Text input-->
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="control-label" for="name">{{ trans('web.name') }} <span
                                            class="required">*</span></label>
                                <input id="consumer_name" name="name" type="text" maxlength="255"
                                       placeholder="{{ trans('web.name') }} " class="form-control input-md"
                                       required value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <!-- Text input-->
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="control-label" for="email">{{ trans('web.email') }} <span
                                            class="required">*</span></label>
                                <input id="consumer_email" name="email" type="email" maxlength="255"
                                       placeholder="{{ trans('web.email') }} " class="form-control input-md"
                                       required value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <!-- Password field -->
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="control-label" for="password">{{ trans('web.password') }} <span
                                            class="required">*</span></label>
                                <input id="consumer_password" name="password" type="password" minlength="6"
                                       placeholder="{{ trans('web.password') }} " class="form-control input-md"
                                       required value="{{ old('password') }}">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <!-- Submit registration form -->
                            <div class="form-group">
                                <input type="submit" class="btn tp-btn-default tp-btn-lg"
                                       value="{{ trans('web.create') }}">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6 feature-block">
                            <div class="well-box">
                                <h3>Notice1</h3>
                                <p>Description Here</p>
                            </div>
                        </div>
                        <div class="col-md-6 feature-block">
                            <div class="well-box">
                                <h3>Notice1</h3>
                                <p>Description Here</p>
                            </div>
                        </div>
                        <div class="col-md-6 feature-block">
                            <div class="well-box">
                                <h3>Notice1</h3>
                                <p>Description Here</p>
                            </div>
                        </div>
                        <div class="col-md-6 feature-block">
                            <div class="well-box">
                                <h3>Notice1</h3>
                                <p>Description Here</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection