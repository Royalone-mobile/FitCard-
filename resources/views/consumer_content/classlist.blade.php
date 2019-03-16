<script>
    function showGrid()
    {
        var listElement = document.getElementById("listType");
        var gridElement = document.getElementById("gridType");
        var listButton = document.getElementById("listMode");
        var gridButton = document.getElementById("gridMode");
        gridElement.style.display = "inline";
        listElement.style.display = "none";
        gridButton.className = "btn  grid-btn active  btn-sm";
        listButton.className = "btn list-btn btn-sm";


    }
    function showList()
    {
        var listElement = document.getElementById("listType");
        var gridElement = document.getElementById("gridType");
        var listButton = document.getElementById("listMode");
        var gridButton = document.getElementById("gridMode");
        gridElement.style.display = "none";
        listElement.style.display = "inline";

        gridButton.className = "btn  grid-btn btn-sm";
        listButton.className = "btn list-btn btn-sm active";
    }
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
        var keyword = ["<?php echo trans('web.sun');?>", "<?php echo trans('web.mon');?>", "<?php echo trans('web.tue');?>", "<?php echo trans('web.wed');?>", "<?php echo trans('web.thu');?>", "<?php echo trans('web.fri');?>", "<?php echo trans('web.sat');?>", "<?php echo trans('web.sun');?>"];
        var someFormattedDate = keyword[DD] + dd + '/' + mm;
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
            {
                var bDate = getdate(baseDate, i);
                var bbDate = getDateFormat(baseDate, i);
                element.innerHTML = bDate;
                $.ajax({
                    type: 'GET',
                    mBaseDate: bDate,
                    indexValue: i,
                    url: '/consumer/ajaxClassCount/' + bbDate,
                    success: function (data)
                    {
                        idField = 'headerDate_' + (this.indexValue);
                        var element = document.getElementById(idField);
                        element.innerHTML = this.mBaseDate + "(" + data.length + ")";
                    }
                });
            }
            element.style.fontSize = 10;
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
                var element = document.getElementById("classCount");
                element.innerHTML = "<?php echo trans('web.classes');?>";
                appendClass(data.vendors, data.upcoming);
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
    function appendClass(vendors, upcomingData)
    {

        var gridContainer = document.getElementById("class_content");
        var upcoming = document.getElementById("upcomingDate");
        gridContainer.innerHTML = "";
        if (vendors.length == 0)
        {
            upcoming.href = "";
            if (upcomingData == "")
            {
                upcoming.innerHTML = "<?php echo trans('web.nothingClass');?>";
                upcoming.onclick = function ()
                {

                };
            }
            else
            {
                var date = new Date(upcomingData);
                var month = date.getMonth() + 1;
                var day = date.getDate();
                if (month < 10)
                    month = "0" + month;
                if (day < 10)
                    day =  "0" + day;
                upcoming.innerHTML = "<?php echo trans('web.upcomingClass');?>" + date.getDate() + "/" + month;
                var baseDate = "";
                baseDate = date.getFullYear() + "-" + month + "-" + day;
                upcoming.dataset.date = baseDate;
                upcoming.onclick = function ()
                {
                    var dateElement = document.getElementById("classDate");
                    dateElement.value = this.dataset.date;
                    reDrawDate(baseDate);
                    onSearch();
                    var date = new Date(baseDate);
                    var DD = date.getDay();
                    var element = document.getElementById('headerDate_' + DD);
                    element.className = "btn list-btn btn-sm active";

                };
            }
            return;
        }
        upcoming.href = "";
        upcoming.innerHTML = "";
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
            aElement.href = "/consumer/detailclass/" + vendorUser.cid;
            var spanElement = vendorContent.createElement("span");
            spanElement.className = "amount";
            spanElement.innerHTML = vendorUser.name;
            aElement.appendChild(spanElement);
            nameElement.appendChild(aElement);
            var spanElement1 = vendorContent.createElement("span");
            spanElement1.className = "amount";
            if (vendorUser.category != null)
            {
                //spanElement1.innerHTML = vendorUser.category;
            }
            categoryElement.appendChild(spanElement1);
            var spanElement2 = vendorContent.createElement("span");
            var aElement1 = vendorContent.createElement("a");
            spanElement2.className = "amount";
            spanElement2.innerHTML = vendorUser.gym;
            aElement1.appendChild(spanElement2);
            gymElement.appendChild(aElement1);

            var buttonElement = vendorContent.createElement("a");
            buttonElement.style = "height:30px;font-size:12px;text-align:center;padding-top:5px";
            buttonElement.className = "btn tp-btn-default tp-btn-lg btn-block";
<?php
if ($isLogin) {
    ?>
                if (vendorUser.isBook == 1)
                {
                    buttonElement.href = "#";
                    buttonElement.innerHTML = "<?php echo trans('web.booked');?>";
                }
                else
                {
                    if (vendorUser.value > vendorUser.bookCount)
                    {
                      buttonElement.href = "/consumer/actionBookClass/" + vendorUser.cid;
                      buttonElement.innerHTML = "<?php echo trans('web.book');?>";
                    }
                    else {
                      buttonElement.href = "#";
                      buttonElement.innerHTML = "<?php echo trans('web.full');?>";
                    }
                }
    <?php
} else {
    ?>
                buttonElement.href = "/consumer/login";
                buttonElement.innerHTML = "<?php echo trans('web.login');?>";
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
<!--
<div class="tp-page-head">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h1>CLASSES</h1>
                </div>
            </div>
        </div>
    </div>
</div>
-->
<div class="tp-breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="/consumer"><?php echo trans('web.home');?></a></li>
                    <li class="active"><?php echo trans('web.classes');?></li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-8 tp-title">
                <h2 id="classCount"><?php echo trans('web.classes');?> </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="filter-sidebar">
                    <form id="searchForm" method="POST" action="/consumer/ajaxSearchClass">
                        <input type="text" name="_token" id="token" style="visibility: hidden; width: 1px; height: 1px" value="{{ csrf_token() }}">
                        <input type="hidden" name="classDate" id="classDate" style="visibility: hidden; width: 1px; height: 1px">
                        <div class="col-md-12 form-group">
                            <label class="control-label" for="venuetype"><?php echo trans('web.keyword');?></label>
                            <input type="text" id="keyword" name="keyword" class="form-control" class="form-control"></input>
                        </div>
                        <div class="col-md-12 form-group" style="display:none;">
                            <label class="control-label" for="venuetype"><?php echo trans('web.selectCity');?></label>
                            <select id="searchCity" name="searchCity" class="form-control">
                                <option value=""><?php echo trans('web.all');?></option>
                                <?php
                                for ($i = 0; $i < count($cityInfos); $i++) {
                                    ?>
                                    <option value="<?php echo $cityInfos[$i]->id; ?>"><?php echo $cityInfos[$i]->city_name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12 st-accordion"> <!-- shortcode -->
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title"> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> <?php echo trans('web.location');?> </a> </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <?php
                                            for ($i = 0; $i < count($locationInfos); $i++) {
                                                ?>
                                                <div class="checkbox checkbox-success">
                                                    <input type="checkbox" name="location_<?php echo $locationInfos[$i]->id ?>" id="weddinghall" class="styled">
                                                    <label for="weddinghall" class="control-label"> <?php echo $locationInfos[$i]->name; ?> </label>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> <?php echo trans('web.studio');?> </a> </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                        <div class="panel-body">
                                            <?php
                                            for ($i = 0; $i < count($studioInfos); $i++) {
                                                ?>
                                                <div class="checkbox checkbox-success">
                                                    <input type="checkbox" name="studio_<?php echo $studioInfos[$i]->id ?>" id="weddinghall" class="styled">
                                                    <label for="weddinghall" class="control-label"> <?php echo $studioInfos[$i]->name; ?> </label>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default" style="display:none;">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> <?php echo trans('web.activity');?> </a> </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                        <div class="panel-body">
                                            <?php
                                            for ($i = 0; $i < count($activityInfos); $i++) {
                                                ?>
                                                <div class="checkbox checkbox-success">
                                                    <input type="checkbox" name="activity_<?php echo $activityInfos[$i]->id ?>" id="weddinghall" class="styled">
                                                    <label for="weddinghall" class="control-label"> <?php echo $activityInfos[$i]->name; ?> </label>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default" style="display:none;">
                                    <div class="panel-heading" role="tab" id="headingFour">
                                        <h4 class="panel-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree"><?php echo trans('web.amenity');?></a> </h4>
                                    </div>
                                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                        <div class="panel-body">
                                            <?php
                                            for ($i = 0; $i < count($amentityInfos); $i++) {
                                                ?>
                                                <div class="checkbox checkbox-success">
                                                    <input type="checkbox" name="amentity_<?php echo $amentityInfos[$i]->id ?>" id="weddinghall" class="styled">
                                                    <label for="weddinghall" class="control-label"> <?php echo $amentityInfos[$i]->name; ?> </label>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-12 form-group">
                        <button onclick="onSearch()"  class="btn tp-btn-default tp-btn-lg btn-block"><?php echo trans('web.refineSearch');?></button>
                    </div>

                </div>
            </div>
            <div class="col-md-9" id="gridType">
                <div class="row">
                    <div class="col-md-12 seven-cols" style="margin-bottom: 10px;">
                        <div class="col-md-1" style="padding:2px;" >
                            <label id="headerDate_0" style="width:100%" class="btn list-btn btn-sm">
                                <?php echo trans('web.prev');?>
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
                                <?php echo trans('web.next');?>
                            </label>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-12 view-cart" style='padding-left:25px;padding-right:25px;text-align:center;'><!-- view cart -->
                            <table class="shop_table">
                                <!-- shop table -->
                                <tbody id="class_content">

                                </tbody>
                            </table>
                            <label href="#" class="upcoming" style="font-size:30px;margin-top:20%;" id="upcomingDate"></label>

                            <!-- shop table end -->
                        </div>
                        <!-- view cart end -->
                    </div>
                </div>
            </div>

        </div>
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
