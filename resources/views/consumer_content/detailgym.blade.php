<link rel="stylesheet" type="text/css" href="{{ url('css/gym.css') }}" />
<script>
    function getdate(baseDate, delta)
    {
        var tt = baseDate

        var date = new Date(tt);
        var newdate = new Date(date);
        var d1 = date.getDay();
        newdate.setDate(newdate.getDate() + delta - d1);

        var dd = newdate.getDate();
        var DD = newdate.getDay();
        var mm = newdate.getMonth() + 1;
        var y = newdate.getFullYear();
        var keyword = ["<?php echo trans('web.sun'); ?>", "<?php echo trans('web.mon'); ?>", "<?php echo trans('web.tue'); ?>", "<?php echo trans('web.wed'); ?>", "<?php echo trans('web.thu'); ?>", "<?php echo trans('web.fri'); ?>", "<?php echo trans('web.sat'); ?>", "<?php echo trans('web.sun'); ?>"];
        var someFormattedDate = keyword[DD] + ' ' + dd + '/' + mm;
        return someFormattedDate;
    }
    function getDateFormat(baseDate, delta)
    {
        var tt = baseDate
        var date = new Date(tt);
        var newdate = new Date(date);

        var DD = date.getDay();

        newdate.setDate(newdate.getDate() + delta - DD);

        var dd = newdate.getDate();
        var mm = newdate.getMonth() + 1;
        var y = newdate.getFullYear();


        if (mm < 10)
            mm = "0" + mm;
        if (dd < 10)
            dd = "0" + dd;
        var someFormattedDate = y + "-" + mm + "-" + dd;
        return someFormattedDate;
    }
    function reDrawDate(baseDate)
    {
        for (i = 0; i < 9; i++)
        {
            idField = 'headerDate_' + (i);
            var element = document.getElementById(idField);
            if (i != 0 && i != 8)
                element.innerHTML = getdate(baseDate, i);
            element.className = "btn list-btn btn-sm";
            element.dataset.index = i;
            element.dataset.date = getDateFormat(baseDate, i);
            element.onclick = function ()
            {
                var dateElement = document.getElementById("classDate");
                dateElement.value = this.dataset.date;
                if (this.dataset.index == 0)
                {
                    var baseDate2 = new Date(this.dataset.date);
                    baseDate2.setDate(baseDate2.getDate() - 1);
                    reDrawDate(baseDate2);
                    var element = document.getElementById('headerDate_7');
                    element.className = "btn list-btn btn-sm active";
                }
                else if (this.dataset.index == 8)
                {
                    var baseDate1 = new Date(this.dataset.date);
                    baseDate1.setDate(baseDate1.getDate() + 1);
                    reDrawDate(baseDate1);
                    var element = document.getElementById('headerDate_1');
                    element.className = "btn list-btn btn-sm active";
                }
                else
                {
                    reDrawDate(baseDate);
                    this.className = "btn list-btn btn-sm active";
                }
                onSearch();
            };
        }

    }
    function onSearch()
    {
        var formElement = document.getElementById("searchForm");
        var formData = new FormData(formElement);
        $.ajax({
            type: 'POST',
            data: formData,
            url: '/consumer/ajaxSearchClass',
            contentType: false,
            processData: false,
            success: function (data)
            {
                appendClass(data.vendors);
            }
        });
        return false;
    }
    function parseDate(str) {
        var mdy = str.split('-');
        return new Date(mdy[0], mdy[1] - 1, mdy[2]);
    }

    function daydiff(first, second) {
        return Math.round((second - first) / (1000 * 60 * 60 * 24));
    }
    function appendClass(vendors)
    {

        var gridContainer = document.getElementById("class_content");
        gridContainer.innerHTML = "";
        for (i = 0; i < vendors.length; i++)
        {
            vendorUser = vendors[i];

            /*var dateElement = document.getElementById("classDate");
             var days = daydiff(parseDate(dateElement.value),parseDate(vendorUser.date));
             if (vendorUser.recurring == 2)
             {
             if (days % 7 != 0) continue;
             }
             else if (vendorUser.recurring == 3)
             {
             var mdy = dateElement.value.split('-');
             var mdy1 = vendorUser.date.split('-');
             if (mdy[2] != mdy1[2]) continue;
             }*/


            var vendorContent = document.implementation.createHTMLDocument("New Document");
            var trDiv = vendorContent.createElement("tr");
            trDiv.className = "cart_item";
            gridContainer.appendChild(trDiv);
            var timeElement = vendorContent.createElement("td");
            var nameElement = vendorContent.createElement("td");
            var categoryElement = vendorContent.createElement("td");
            var gymElement = vendorContent.createElement("td");
            var actionElement = vendorContent.createElement("td");
            timeElement.className = "product-name";
            timeElement.style = "padding:5px;";
            nameElement.className = "product-name";
            nameElement.style = "padding:5px;";
            categoryElement.className = "product-name";
            categoryElement.style = "padding:5px;";
            gymElement.className = "product-name";
            gymElement.style = "padding:5px;";
            actionElement.className = "product-name";
            actionElement.style = "padding:5px;";
            trDiv.appendChild(timeElement);
            trDiv.appendChild(nameElement);
            trDiv.appendChild(gymElement);
            trDiv.appendChild(actionElement);
            trDiv.onclick = function ()
            {
              location.href = "/consumer/detailclass/" + vendorUser.cid;
            }
            var aNameElement = vendorContent.createElement("a");
            var pNameElement = vendorContent.createElement("p");
            aNameElement.innerHTML = vendorUser.startHour;
            aNameElement.href = "/consumer/detailclass/" + vendorUser.cid;
            pNameElement.style = "margin-bottom:0px;";
            pNameElement.innerHTML = "(" + vendorUser.duration + "Min)";
            timeElement.appendChild(aNameElement);
            timeElement.appendChild(pNameElement);

            var aElement = vendorContent.createElement("a");
            var spanElement = vendorContent.createElement("span");
            aElement.href = "/consumer/detailclass/" + vendorUser.cid;
            spanElement.className = "amount";
            spanElement.innerHTML = vendorUser.name;
            aElement.appendChild(spanElement);
            nameElement.appendChild(aElement);

            var spanElement1 = vendorContent.createElement("span");
            spanElement1.className = "amount";
            if (vendorUser.category != null)
            {
                spanElement1.innerHTML = vendorUser.category;
            }
            categoryElement.appendChild(spanElement1);
            var spanElement2 = vendorContent.createElement("span");
            spanElement2.className = "amount";
            if (vendorUser.description.length > 20)
            {
                spanElement2.innerHTML = vendorUser.description.substring(0, 20) + "...";
            }
            else
                spanElement2.innerHTML = vendorUser.description;
            gymElement.appendChild(spanElement2);

            var buttonElement = vendorContent.createElement("a");
            buttonElement.style = "height:30px;font-size:12px;text-align:center;padding-top:5px";
            buttonElement.className = "btn tp-btn-default tp-btn-lg btn-block";

<?php
if ($isLogin) {
    ?>
                if (vendorUser.isBook == 1)
                {
                    buttonElement.href = "#";
                    buttonElement.innerHTML = "Booked";
                }
                else
                {
                    buttonElement.href = "/consumer/actionBookClass/" + vendorUser.cid;
                    buttonElement.innerHTML = "Book";
                }
    <?php
} else {
    ?>
                buttonElement.href = "/consumer/login";
                buttonElement.innerHTML = "Login";
    <?php
}
?>
            actionElement.appendChild(buttonElement);
        }
    }
</script>
<style>
    @media (min-width: 768px){
        .seven-cols .col-md-1,
        .seven-cols .col-sm-1,
        .seven-cols .col-lg-1  {
            width: 100%;
            *width: 100%;
        }
    }

    @media (min-width: 992px) {
        .seven-cols .col-md-1,
        .seven-cols .col-sm-1,
        .seven-cols .col-lg-1 {
            width: 11.1111111111111111111111111111111%;
            *width: 11,111111111111111111111111111111%;
        }
    }

    /**
     *  The following is not really needed in this case
     *  Only to demonstrate the usage of @media for large screens
     */
    @media (min-width: 1200px) {
        .seven-cols .col-md-1,
        .seven-cols .col-sm-1,
        .seven-cols .col-lg-1 {
            width: 11.1111111111111111111111111111111%;
            *width: 11,111111111111111111111111111111%;
        }
    }
    .upcoming
    {
        color:#2798c6;
    }
    .upcoming:hover
    {
        color:#d5ab49;
    }
</style>

<!-- /.page header -->
<div class="tp-breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <ol class="breadcrumb">
                    <li><a href="/consumer"><?php echo trans('web.home'); ?></a></li>
                    <li><a href="/consumer/gyms"><?php echo trans('web.gyms'); ?></a></li>
                    <li class="active"><?php echo trans('web.detailGym'); ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="main-container">
    <div class="woo-shop" id="woo-shop">
        <div class="container">
            <div class="row">
                <div class="col-md-12 shop-details">
                    <div class="row product-summry gym-product-summary">
                        <!-- Gym Banner column start -->
                        <div class="col-md-5 product-box">
                            <div class="product-wrap">
                                @if ($gymData[0]['image'] == "")
                                    <img src="" style="width:100%;height:250px;" class="img-responsive">
                                @else
                                    <img src="{{ url($gymData[0]['image']) }}"  class="img-responsive">
                                @endif
                            </div>
                        </div>
                        <!-- Gym Banner column end -->
                        <div class="col-md-7 summry-details">
                            <p class="rating"><span>
                                    <div class="row">
                                        <?php
                                        $curTime = new \DateTime();
                                        $curTime->setTimezone(new \DateTimeZone('Europe/Helsinki'));

                                        $curDate = $curTime->format('Y-m-d');
                                        $curDay = $curTime->format('N');
                                        $days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
                                        $startHour = $gymData[0]['startHours'][$curDay - 1];
                                        $endHour = $gymData[0]['endHours'][$curDay - 1];
                                        $startDateTime = $curDate . " " . $startHour;
                                        $endDateTime = $curDate . " " . $endHour;
                                        $curTimestamp = strtotime($curTime->format('Y-m-d H:i:m'));
                                        $startTimeStamp = strtotime($startDateTime);
                                        $endTimeStamp = strtotime($endDateTime);
                                        $isClose = $gymData[0]['closeDay'][$curDay - 1];

                                        if ($isLogin) {
                                            if (!$isBook) {
                                                if ($curTimestamp > $startTimeStamp && $curTimestamp < $endTimeStamp) {
                                                    if ($gymData[0]['usability'] > count($visitors)) {
                                                        if ($isClose == 0)
                                                        {
                                                          ?>
                                                          <div class="col-md-12 venue-action"><a href="/consumer/actionBookGym/<?php echo $gymData[0]['gid']; ?>" class="btn tp-btn-default"><?php echo trans('web.visit'); ?></a> </div>
                                                          <?php
                                                        }
                                                        else {
                                                          ?>
                                                          <div class="col-md-12 venue-action"><a href="#" class="btn tp-btn-default"><?php echo trans('web.closed'); ?></a> </div>
                                                          <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <div class="col-md-12 venue-action"><a href="#" class="btn tp-btn-default"><?php echo trans('web.fullVisits'); ?></a> </div>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <div class="col-md-12 venue-action"><a href="#" class="btn tp-btn-default"><?php echo trans('web.closed'); ?></a> </div>
                                                    <?php
                                                }
                                            } else {

                                                $timestamp = strtotime($bookTime) + 60 * 60 * 3;
                                                $time = date('d/m H:i', $timestamp);
                                                $tt = date('Y-m-d H:i:m', $timestamp);

                                                if ($tt < $curTime->format('Y-m-d H:i:m')) {
                                                    if ($curTimestamp > $startTimeStamp && $curTimestamp < $endTimeStamp) {
                                                        if ($gymData[0]['usability'] > count($visitors)) {
                                                          if ($isClose == 0)
                                                          {
                                                            ?>
                                                            <div class="col-md-12 venue-action"><a href="/consumer/actionBookGym/<?php echo $gymData[0]['gid']; ?>" class="btn tp-btn-default"><?php echo trans('web.visit'); ?></a> </div>
                                                            <?php
                                                          }
                                                          else {
                                                            ?>
                                                            <div class="col-md-12 venue-action"><a href="#" class="btn tp-btn-default"><?php echo trans('web.closed'); ?></a> </div>
                                                            <?php
                                                          }
                                                        } else {
                                                            ?>
                                                            <div class="col-md-12 venue-action"><a href="#" class="btn tp-btn-default"><?php echo trans('web.fullVisits'); ?></a> </div>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <div class="col-md-12 venue-action"><a href="#" class="btn tp-btn-default"><?php echo trans('web.closed'); ?></a> </div>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <div class="col-md-12 venue-action"><a href="#" class="btn tp-btn-default"><?php echo trans('web.activeUntil') . $time.trans('web.activeUntil1'); ?></a> </div>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="row gym-info-row">
                                        <div class="col-md-3" style="padding-right: 0px;">
                                            <img src="{{ url($gymData[0]['logo']) }}"  class="img-responsive gym-logo">
                                        </div>
                                        <div class="col-md-9">
                                            <h1 class="product-title gym-title">{{ $gymData[0]['name'] }}</h1>
                                            <p class="gym-location">
                                                {{ $gymData[0]['address'] . ', ' . $gymData[0]['city'] }}
                                            </p>
                                            <div class="rating-stars">
                                                <?php
                                                $starCount = 0;
                                                for ($j = 0; $j < (int) $gymData[0]['rating']; $j++) {
                                                    echo "<i class='fa fa-star rating-star'></i>";
                                                    $starCount++;
                                                }
                                                if ($starCount < 4) {
                                                    $dec = $gymData[0]['rating'] - (int) $gymData[0]['rating'];
                                                    if ($dec < 0.5)
                                                        echo "<i class='fa fa-star-o rating-star'></i>";
                                                    else
                                                        echo "<i class='fa fa-star-half-full rating-star'></i>";
                                                    $starCount++;
                                                }
                                                for ($j = $starCount; $j < 5; $j++) {
                                                    echo "<i class='fa fa-star-o rating-star'></i>";
                                                }
                                                ?>
                                            </div>
                                        </div>

                                    </div>

                            <p>{{ $gymData[0]['description'] }}</p>
                            <hr />
                            <div id="map" class="map-box"></div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 45px;">
                        <h2 class="gym-page-sub-heading" style="margin-left:10px;">{{ trans('web.schedule') }}</h2>
                        <div class="col-md-12" id="gridType">
                            <div class="row">
                                <div class="col-md-12  seven-cols" style="margin-bottom: 10px;">
                                    <div class="col-md-1" style="padding:2px;">
                                      <label id="headerDate_0" style="width:100%" class="btn list-btn btn-sm">
                                          {{ trans('web.prev') }}
                                      </label>
                                    </div>
                                            <?php
                                    for ($i = 1; $i < 8; $i++) {
                                        ?>
                                        <div class="col-md-1" style="padding:2px;">
                                            <label id="headerDate_<?php echo $i; ?>" style="width:100%"  class="btn list-btn btn-sm">

                                            </label>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="col-md-1" style="padding:2px;">
                                        <label id="headerDate_8" style="width:100%" class="btn list-btn btn-sm">
                                    <?php echo trans('web.next'); ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <form id="searchForm">
        <input type="text" name="_token" id="token" style="visibility: hidden; width: 1px; height: 1px" value="{{ csrf_token() }}">
        <input type="hidden" name="classDate" id="classDate" style="visibility: hidden; width: 1px; height: 1px" value="{{ csrf_token() }}">
        <input type="hidden" name="gid" id="gym_no" value="<?php echo $gymData[0]['gid']; ?>" style="visibility: hidden; width: 1px; height: 1px" value="{{ csrf_token() }}">
    </form>
</div>
<script src="<?php echo url('/') . "/"; ?>js/jquery.min.js"></script>
<script>
    var today = new Date();
    reDrawDate(today);
    var DD = today.getDay();
    var element = document.getElementById('headerDate_' + DD);
    element.className = "btn list-btn btn-sm active";
    var dateElement = document.getElementById("classDate");
    dateElement.value = getDateFormat(today, DD);
    onSearch();
</script>
    <script>
        var map;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {{ '{lat:' . $gymData[0]['lat'] . ', lng:' . $gymData[0]['lng'] . '},' }}
                zoom: 15
            });
        }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDhEEZzM5yUrauTUGqQex6i4z2DfKwQ9A8&callback=initMap"></script>
