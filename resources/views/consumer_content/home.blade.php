<div class="tp-section spacer" style="padding-top:0px;padding-bottom:0px;border-bottom: 0px;">
    <div class="row" style="min-height:150px;">
        <div class="col-md-4 tp-title"
             style="min-height:150px;background-color:#0085ae;padding-bottom:30px;padding-left:45px;padding-right:30px;padding-top:35px;">
            <div class="row">
                <div class="col-md-2">
                    <i class="fa fa-thumbs-o-up" style="font-size:50px; color:#fff;"></i>
                </div>
                <div class="col-md-10">
                    <p style="color:#fff">
                        <b><?php echo trans('web.consumerHomeTab1');?></b><br>
                        <?php echo trans('web.consumerHomeTabContent1');?>
                        <br>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 tp-title"
             style="min-height:150px;background-color:#0093c0;padding-bottom:30px;padding-left:45px;padding-right:30px;padding-top:35px;">
            <div class="row">
                <div class="col-md-2">
                    <i class="fa fa-globe" style="font-size:55px; color:#fff"></i>
                </div>
                <div class="col-md-10">
                    <p style="color:#fff">
                        <b><?php echo trans('web.consumerHomeTab2');?></b><br>
                        <?php echo trans('web.consumerHomeTabContent2');?>
                    </p>
                </div>
            </div>

        </div>
        <div class="col-md-4 tp-title"
             style="min-height:150px;background-color:#009fd0;padding-bottom:30px;padding-left:45px;padding-right:30px;padding-top:35px;">
            <div class="row">
                <div class="col-md-2">
                    <i class="fa fa-heart-o fa-6" style="font-size:50px; color:#fff"></i>
                </div>
                <div class="col-md-10">
                    <p style="color:#fff;text-align: left;">
                        <b><?php echo trans('web.consumerHomeTab3');?></b><br>
                        <?php echo trans('web.consumerHomeTabContent3');?>
                    </p>
                </div>
            </div>

        </div>
    </div>
    <div class="container">


        <div class="row">
            <div class="col-md-12 tp-title-center" style="text-align: left;">
                <h1><?php echo trans('web.featuredGym');?></h1>
            </div>
        </div>
        <div class="row ">
            <?php
            for ($i = 0; $i < count($gyms); $i++) {
            $gym = $gyms[$i];
            ?>
            <div class="col-md-4 vendor-box"><!-- venue box start-->
                <div class="vendor-image"><!-- venue pic -->
                    <a href="/consumer/detailgym/{{ $gym->id }}"><img src="{{ banner_path() . $gym->image }}" alt=""
                                                                      class="img-responsive"></a>
                </div>
                <!-- /.venue pic -->
                <div class="vendor-detail"><!-- venue details -->
                    <div class="caption"><!-- caption -->
                        <h2><a href="/consumer/detailgym/<?php echo $gym->id; ?>"
                               class="title"><?php echo $gym->name; ?></a></h2>
                        <p class="location"><i class="fa fa-map-marker"></i>
                            <?php
                            echo $gym->city;
                            ?>
                        </p>
                        <div class="rating">
                            <?php
                            $starCount = 0;
                            for ($j = 0; $j < (int)$gym->rating; $j++) {
                                echo "<i class='fa fa-star'></i>";
                                $starCount++;
                            }
                            if ($starCount < 4) {
                                $dec = $gym->rating - (int)$gym->rating;
                                if ($dec < 0.5) {
                                    echo "<i class='fa fa-star-o'></i>";
                                } else {
                                    echo "<i class='fa fa-star-half-full'></i>";
                                }
                                $starCount++;
                            }
                            for ($j = $starCount; $j < 5; $j++) {
                                echo "<i class='fa fa-star-o'></i>";
                            }
                            ?>
                            <span class="rating-count">(<?php echo $gym->reviews; ?>)</span>
                        </div>
                    </div>
                </div>
                <!-- venue details -->
            </div>
            <?php
            }
            ?>
        </div>
        <div class="row form-group" style="padding-left:10px;padding-right:10px;">
            <a href="/consumer/gyms"
               class="btn tp-btn-default tp-btn-lg btn-block"><?php echo trans('web.loadMore');?></a>
        </div>
        <div class="row">
            <div class="col-md-12 tp-title-center" style="text-align: left;">
                <h1><?php echo trans('web.newClasses');?></h1>
            </div>
        </div>
        <div class="row">
            <?php
            for ($i = 0; $i < count($classes); $i++) {
            $classInfo = $classes[$i];
            ?>
            <div class="col-md-6 vendor-box vendor-box-grid">
                <div class="row">
                    <div class="col-md-6 no-right-pd" style="height:150px">
                        <div class="">
                            <a href="/consumer/detailclass/<?php echo $classInfo->id; ?>"><img
                                        style="height:150px; width:100%;"
                                        src="<?php echo url('/') . "/" . $classInfo->gymInfo->image; ?>"></a>
                        </div>
                    </div>
                    <div class=" col-md-6 vendor-detail" style="height:150px">
                        <div class="caption" style="padding-right:0px;display:inherit;">
                            <div class="col-md-6">
                                <h2 style='font-size:18px;'><a
                                            href="/consumer/detailclass/<?php echo $classInfo->id; ?>"
                                            class="title"><?php echo $classInfo->name; ?></a></h2>
                                <p class="location"
                                   style="font-size:20px; color:72B147;"><?php echo substr($classInfo->starthour, 0, 5) . "-" . substr($classInfo->endhour, 0, 5); ?></p>
                                <p class="location" style="font-size:18px;"><?php echo $classInfo->gymInfo->name; ?></p>
                            </div>
                            <?php
                            $timestamp = strtotime($classInfo->date);
                            $time = date('d/m/Y', $timestamp);
                            $today = time();
                            $currentDate = date('d/m/Y', $today);
                            if ($time == $currentDate) {
                                $time = "Today";
                            }
                            ?>
                            <div class="col-md-6">
                                <span class="location" style="font-size:20px; color:72B147;"><?php echo $time; ?></span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
        <div class="row form-group" style="padding-left:10px;padding-right:10px;">
            <a href="/consumer/classlist"
               class="btn tp-btn-default tp-btn-lg btn-block"><?php echo trans('web.loadMore');?></a>
        </div>

    </div>
    <?php
    if (!$isLogin) {
    ?>
    <section class="row"
             style="background-image:url(https://classpass.com/style-guide/templates/static/assets/images/css/masthead--04.jpg);height:800px;background-size:cover;background-repeat:no-repeat;">
        <div style='position:relative;top:50%;transform: translate(0,-50%);text-align:center;'>
            <h2 class="dark" style='font-size:30px;'>{!! trans('web.enjoyFitness'); !!}</h2>
            <p style='font-size:20px;'>
                <?php echo trans('web.enjoyContent');?>
            </p>
            <img src="<?php echo url('/') . "/"; ?>images/appstore.png"/>
            <img src="<?php echo url('/') . "/"; ?>images/googlestore.png"/>
        </div>
    </section>
    <div class="container" style='padding-top:20px;background-color:#18233e;margin:0px; width:100%;'>
        <div class="row">
            <div class="col-md-12" style='text-align:center;padding-top:20px;'>
                <h1 style='color:#fff'><?php echo trans('web.selectPlan');?></h1>
            </div>
            <!--
            <div class="col-md-4 "><a href="#" class="btn tp-btn-primary tp-btn-lg pull-right"> Start Free Trial</a></div>
            -->
        </div>
        <div class="row pricing-container" style='padding:30px;'>
            <div class="col-md-4 pricing-box pricing-box-regualr">
                <div class="well-box">
                    <h2 class="price-title dark">{!! $planInfos[0]->plan; !!}</h2>
                    <h1 class="price-plan dark"><span class="dollor-sign"></span>{!! $planInfos[0]->price; !!}<span
                                class="permonth">€/kk</span></h1>
                    <p>{!!  $planInfos[0]->credit . " " . trans('web.creditMonth'); !!}</p>
                    <a href="#" class="btn tp-btn-default">{!! trans('web.selectPlan'); !!}</a>
                </div>
                <!--
              <ul class="check-circle list-group">
                <li class="list-group-item">24/7 Email Support</li>
                <li class="list-group-item">ePayments &amp; eInvoices</li>
                <li class="list-group-item">Advanced Review Management</li>
                <li class="list-group-item">Education Webinars</li>
              </ul>
                -->
            </div>
            <div class="col-md-4 pricing-box pricing-box-regualr">
                <div class="well-box">
                    <h2 class="price-title dark">{!! $planInfos[0]->plan; !!}</h2>
                    <h1 class="price-plan dark"><span class="dollor-sign"></span>{!! $planInfos[1]->price; !!}<span
                                class="permonth">€/kk</span></h1>
                    <p>{!!  $planInfos[1]->credit . " " . trans('web.creditMonth'); !!}</p>
                    <a href="#" class="btn tp-btn-default">{!! trans('web.selectPlan'); !!}</a>
                </div>
                <!--
              <ul class="check-circle list-group">
                <li class="list-group-item">24/7 Email Support</li>
                <li class="list-group-item">Unlimited User Accounts</li>
                <li class="list-group-item">Secure Client Transactions</li>
                <li class="list-group-item">Online Appointment Scheduling</li>
              </ul>
                -->
            </div>
            <div class="col-md-4 pricing-box pricing-box-regualr">
                <div class="well-box">
                    <h2 class="price-title dark">{!! $planInfos[2]->plan; !!}</h2>
                    <h1 class="price-plan dark"><span class="dollor-sign"></span>{!! $planInfos[2]->price; !!}<span
                                class="permonth">€/kk</span></h1>
                    <p>{!!  $planInfos[2]->credit . " " . trans('web.creditMonth'); !!}</p>
                    <a href="#" class="btn tp-btn-default">{!! trans('web.selectPlan'); !!}</a>
                </div>
                <!--
              <ul class="check-circle list-group">
                <li class="list-group-item">24/7 Email Support</li>
                <li class="list-group-item">ePayments &amp; eInvoices</li>
                <li class="list-group-item">Advanced Review Management</li>
                <li class="list-group-item">Education Webinars</li>
              </ul>
                -->
            </div>
        </div>
        <div></div>

    </div>
    <div class="container" style='padding-top:20px;background-color:#fff;margin:0px; width:100%;'>
        <div class="row">
            <div class="col-md-12" style='text-align:center;padding-top:20px;padding-left:100px;padding-right:100px;'>
                <h1 style='color:#18233e;font-size:20px;'><?php echo trans('web.consumerHomeBottomTitle');?></h1>
                <p>
                    <?php echo trans('web.consumerHomeBottomContent');?>
                </p>
                <br>
                <div class="col-md-4" style="text-align: left;">
                    <h1 style='font-size:15px;'><?php echo trans('web.consumerHomeBottomTab1');?></h1>
                    <p>
                        <?php echo trans('web.consumerHomeBottomTabContent1');?>
                    </p>
                </div>
                <div class="col-md-4" style="text-align: left;">
                    <h1 style='font-size:15px;'><?php echo trans('web.consumerHomeBottomTab2');?></h1>
                    <p>
                        <?php echo trans('web.consumerHomeBottomTabContent2');?>
                    </p>
                </div>
                <div class="col-md-4" style="text-align: left;">
                    <h1 style='font-size:15px;'><?php echo trans('web.consumerHomeBottomTab3');?></h1>
                    <p>
                        <?php echo trans('web.consumerHomeBottomTabContent3');?>
                    </p>
                </div>
            </div>
            <!--
            <div class="col-md-4 "><a href="#" class="btn tp-btn-primary tp-btn-lg pull-right"> Start Free Trial</a></div>
            -->
        </div>


    </div>
    <?php
    }
    ?>
</div>
<!-- /.top location -->
