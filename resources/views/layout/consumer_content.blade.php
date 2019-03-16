<div class="slider-bg" >
    <!-- slider start-->

    @if ($pageName == "HOME")
        <div id="slider" class="owl-carousel owl-theme slider" >
            <div class="item"><img src="{!! url('/') . "/" . "images/banner/slider1.jpg" !!}"></div>
            <div class="item"><img src="{!! url('/') . "/" . "images/banner/slider2.jpg" !!}"></div>
            <div class="item"><img src="{!! url('/') . "/" . "images/banner/slider3.jpg" !!}"></div>
        </div>
    @else
        <div id="slider" class="owl-carousel owl-theme slider" >
            <div class="item"><img src="{!! url('/') . "/" . "images/banner/fitcardbg1.jpg" !!}"></div>
            <div class="item"><img src="{!! url('/') . "/" . "images/banner/fitcardbg2.jpg" !!}"></div>
            <div class="item"><img src="{!! url('/') . "/" . "images/banner/fitcardbg3.jpg" !!}"></div>
        </div>
    @endif

    <div class="find-section" style="top:2%"><!-- Find search section-->

        <div class="container" style="width:100%;">
            <div class="row">
                <div class="tp-nav" id="headersticky"><!-- navigation start -->
                    <div class="container">
                        <nav class="navbar navbar-default navbar-static-top">

                            <!-- Brand and toggle get grouped for better mobile display -->

                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                                <a class="navbar-brand" href="/consumer"><img src="<?php echo url('/') . "/"; ?>images/logo.png" class="img-responsive"></a> </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav navbar-right" >
                                    <li class="active"><a href="/"><?php echo trans('web.home'); ?></a></li>
                                    <li><a href="/consumer/gyms"><?php echo trans('web.gyms'); ?></a></li>
                                    <li><a href="/consumer/classlist"><?php echo trans('web.classes'); ?></a></li>
                                    <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo trans('web.consumerAccount'); ?> <span class="fa fa-angle-down"></span></a>
                                        <ul class="dropdown-menu">
                                            @if($isLogin)
                                                <li><a href="/consumer/invite"><?php echo trans('web.inviteFriend'); ?></a></li>
                                                <li><a href="/consumer/books"><?php echo trans('web.mybooks'); ?></a></li>
                                                <li><a href="/consumer/payment/plans"><?php echo trans('web.pricing'); ?></a></li>
                                                <li><a href="/consumer/profile"><?php echo trans('web.profile'); ?></a></li>
                                                <li><a href="/logout"><?php echo trans('web.logout'); ?></a></li>
                                            @else
                                                <li><a href="/consumer/auth/login"><?php echo trans('web.login'); ?></a></li>
                                                <li><a href="/consumer/auth/register"><?php echo trans('web.register'); ?></a></li>
                                            @endif
                                        </ul>
                                    </li>
                                    <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo trans('web.language'); ?> <span class="fa fa-angle-down"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="/consumer/actionLanguage/1"><?php echo trans('web.english'); ?></a></li>
                                            <li><a href="/consumer/actionLanguage/2"><?php echo trans('web.finnish'); ?></a></li>
                                        </ul>
                                    </li>
                                    <li><a href="/consumer/contact"><?php echo trans('web.contactus'); ?></a></li>
                                </ul>
                            </div>

                            <!-- /.navbar-collapse -->
                        </nav>
                    </div>
                    <!-- /.container-fluid -->

                </div><!-- navigation end -->
                <?php
                if ($pageName == "HOME") {
                    ?>
                    <div style="margin-top:5%">
                        <h1 class="welcome-heading"><?php echo trans('web.welcomeMessageTitle'); ?></h1>
                        <p>{!! trans('web.welcomeMessageContent') !!}</p>
                        <?php
                        if (!$isLogin) {
                            ?>
                            <a href="/consumer/register" style="width:200px;padding:10px;border-radius:20px;" id="submit" name="submit" class="btn tp-btn-default " onclick="clickSubmitVendor()"><?php echo trans('web.tryFitCard'); ?></a>
                            <?php
                        }
                        ?>

                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div><!-- /.Find search section-->

<?php
if ($pageName == "HOME") {
    ?>
    @include('consumer_content.home')
    <?php
} else if ($pageName == "LOGIN") {
    ?>
    @include('consumer_content.login')
    <?php
} else if ($pageName == "REGISTER") {
    ?>
    @include('consumer_content.register')
    <?php
} else if ($pageName == "PRICE") {
    ?>
    @include('consumer_content.price')
    <?php
} else if ($pageName == "FORGET") {
    ?>
    @include('consumer_content.forgetpassword')
    <?php
} else if ($pageName == "VERIFICATION") {
    ?>
    @include('consumer_content.verificationcode')
    <?php
} else if ($pageName == "LISTGYM") {
    ?>
    @include('consumer_content.list')
    <?php
} else if ($pageName == "INVITE") {
    ?>
    @include('consumer_content.invite')
    <?php
} else if ($pageName == "CONTACT") {
    ?>
    @include('consumer_content.contacts')
    <?php
} else if ($pageName == "DETAILGYM") {
    ?>
    @include('consumer_content.detailgym')
    <?php
} else if ($pageName == "DETAILCLASS") {
    ?>
    @include('consumer_content.detailclass')
    <?php
} else if ($pageName == "PROFILE") {
    ?>
    @include('consumer_content.profile')
    <?php
} else if ($pageName == "LISTCLASS") {
    ?>
    @include('consumer_content.classlist')
    <?php
} else if ($pageName == "CHARGEFUND") {
    ?>
    @include('consumer_content.charge')
    <?php
} else if ($pageName == "MYBOOKS") {
    ?>
    @include('consumer_content.books')
    <?php
} else if ($pageName == "ABOUT") {
    ?>
    @include('consumer_content.about')
    <?php
} else if ($pageName == "PARTNER") {
    ?>
    @include('consumer_content.partner')
    <?php
}
?>
