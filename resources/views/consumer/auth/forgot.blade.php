@extends('layouts.consumer')

@section('content')
    <!-- Breadcrumbs -->
    <div class="tp-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/') }}">{{ trans('web.home') }}</a></li>
                        <li class="active">{{ trans('web.forgetPassword') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Forgot password content -->
    <div class="main-container">
        <div class="container">
            <div class="row">
                <div class="col-md-12 tp-title-center">
                    <h1>{{ trans('web.forgetPassword') }}</h1>
                </div>
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="col-md-offset-3 col-md-6 well-box">
                <form action="{{ url('password/email') }}" method="post">
                {{ csrf_field() }}

                <!-- Email field -->
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="control-label" for="email">
                            {{ trans('web.email') }}
                            <span class="required"></span>
                        </label>
                        <input id="forget_email" name="email" type="email"
                               placeholder=" {{ trans('web.email') }}" class="form-control input-md" required
                               value="{{ old('email') }}"/>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn tp-btn-default tp-btn-lg"
                               value="{{ trans('web.resetPassword') }}">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection