<div class="footer" style="background-color:#2798c6;padding-bottom:0px;"><!-- Footer -->
    <div class="container">
        <div class="row">
            <div class="col-md-5 ft-link">
                <h2>{{ trans('web.company') }}</h2>
                <div class="col-md-4">
                    <ul>
                        <li><a href="/consumer/partner" style='color:#ffffff;'>{{ trans('web.partner') }}</a></li>
                        <li><a href="/consumer/about" style='color:#ffffff;'>{{ trans('web.about') }}</a></li>
                        <li><a href="#" style='color:#ffffff;'>{{ trans('web.team') }}</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul>
                        <li><a href="http://finternet-group.com/jobs" style='color:#ffffff;'>{{ trans('web.jobs') }}</a>
                        </li>
                        <li><a href="http://finternet-group.com/contact/"
                               style='color:#ffffff;'>{{ trans('web.press') }}</a></li>
                        <li><a href="#" style='color:#ffffff;'>{{ trans('web.newsroom') }}</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul>
                        <li><a href="#" style='color:#ffffff;'>{{ trans('web.warmup') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 ft-link">
                <h2>{{ trans('web.support') }}</h2>
                <ul>
                    <li><a href="#" style='color:#ffffff;'>{{ trans('web.helpcenter') }}</a></li>
                    <li><a href="#" style='color:#ffffff;'>{{ trans('web.contact') }}</a></li>
                </ul>
            </div>

            <div class="col-md-4 newsletter">
                <h2>{{ trans('web.enjoyFitnessGo') }}</h2>
                <img src="{{ url('images/appstore.png') }}"/>
                <img src="{{ url('images/googlestore.png') }}"/>
            </div>
        </div>
    </div>
</div><!-- /.Footer -->
<div class="tiny-footer" style="background-color:#2798c6;padding-top:0px;"><!-- Tiny footer -->
    <div class="container">
        <div class="row">
            <div class="social-icon">
                <ul>
                    <li><a href="#"><i class="fa fa-facebook-square" style="color:#fff;"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter-square" style="color:#fff;"></i></a></li>
                    <li><a href="#"><i class="fa fa-google-plus-square" style="color:#fff;"></i></a></li>
                    <li><a href="#"><i class="fa fa-instagram" style="color:#fff;"></i></a></li>
                    <li><a href="#"><i class="fa fa-flickr" style="color:#fff;"></i></a></li>
                </ul>
            </div>
            <div class="col-md-12"><label style='color:#ffffff;'>Copyright © 2016. All Rights Reserved</label></div>
        </div>
    </div>
</div><!-- /. Tiny Footer -->
<div class="modal"></div>


<!-- Site javascript files -->
{{ Html::script('js/jquery.min.js') }}
{{ Html::script('js/bootstrap.min.js') }}
{{ Html::script('js/nav.js') }}
{{ Html::script('js/bootstrap-select.js') }}
{{ Html::script('js/owl.carousel.min.js') }}
{{ Html::script('js/slider.js') }}
{{ Html::script('js/testimonial.js') }}
{{ Html::script('js/jquery.sticky.js') }}
{{ Html::script('js/header-sticky.js') }}

{{ Html::script('js/pagescroll.js') }}
