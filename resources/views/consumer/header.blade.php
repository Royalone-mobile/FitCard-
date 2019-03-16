<div class="slider-bg">
    <!-- slider start-->

    <div id="slider" class="owl-carousel owl-theme slider">
        @if (Request::route()->getName() == 'consumer.home')
            <div class="item"><img src="{!! url('images/banner/slider1.jpg') !!}"></div>
            <div class="item"><img src="{!! url('images/banner/slider2.jpg') !!}"></div>
            <div class="item"><img src="{!! url('images/banner/slider3.jpg') !!}"></div>
        @else
            <div class="item"><img src="{!! url('images/banner/fitcardbg1.jpg') !!}"></div>
            <div class="item"><img src="{!! url('images/banner/fitcardbg2.jpg') !!}"></div>
            <div class="item"><img src="{!! url('images/banner/fitcardbg3.jpg') !!}"></div>
        @endif
    </div>

    <div class="find-section" style="top:2%"><!-- Find search section-->

        <div class="container" style="width:100%;">
            <div class="row">
                <div class="tp-nav" id="headersticky"><!-- navigation start -->
                    <div class="container">
                        <nav class="navbar navbar-default navbar-static-top">

                            <!-- Brand and toggle get grouped for better mobile display -->

                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed"
                                        data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
                                        aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span>
                                    <span class="icon-bar"></span> <span class="icon-bar"></span>
                                </button>

                                <a class="navbar-brand" href="/consumer">
                                    <img src="{{ url('images/logo.png') }}" class="img-responsive">
                                </a>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav navbar-right">
                                    <li class="active"><a href="/">{{ trans('web.home') }}</a></li>
                                    <li><a href="/consumer/gyms">{{ trans('web.gyms') }}</a></li>
                                    <li><a href="/consumer/classlist">{{ trans('web.classes') }}</a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                           aria-haspopup="true" aria-expanded="false">
                                            {{ trans('web.account') }}
                                            <span class="fa fa-angle-down"></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            @if(Auth::check())
                                                <li><a href="/consumer/invite">{{ trans('web.inviteFriend') }}</a></li>
                                                <li><a href="/consumer/books">{{ trans('web.mybooks') }}</a></li>
                                                <li><a href="/consumer/payment/plans">{{ trans('web.pricing') }}</a></li>
                                                <li><a href="/consumer/profile">{{ trans('web.profile') }}</a></li>
                                                <li><a href="/logout">{{ trans('web.logout') }}</a></li>
                                            @else
                                                <li><a href="/consumer/auth/login">{{ trans('web.login') }}</a></li>
                                                <li><a href="/consumer/auth/register">{{ trans('web.register') }}</a></li>
                                            @endif
                                        </ul>
                                    </li>
                                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                            role="button" aria-haspopup="true"
                                                            aria-expanded="false">{{ trans('web.language') }} <span
                                                    class="fa fa-angle-down"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="/consumer/actionLanguage/1">{{ trans('web.english') }}</a></li>
                                            <li><a href="/consumer/actionLanguage/2">{{ trans('web.finnish') }}</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="/consumer/contact">{{ trans('web.contactus') }}</a></li>
                                </ul>
                            </div>

                            <!-- /.navbar-collapse -->
                        </nav>
                    </div>
                    <!-- /.container-fluid -->

                </div><!-- navigation end -->
                @if (Request::route()->getName() == 'consumer.home')
                    <div style="margin-top:5%">
                        <h1 class="welcome-heading">{{ trans('web.welcomeMessageTitle') }}</h1>
                        <p>{!! trans('web.welcomeMessageContent') !!}</p>
                        @if(!Auth::check())
                            <a href="/consumer/register" style="width:200px;padding:10px;border-radius:20px;"
                               id="submit" name="submit" class="btn tp-btn-default "
                               onclick="clickSubmitVendor()">{{ trans('web.tryFitCard') }}</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div><!-- /.Find search section-->