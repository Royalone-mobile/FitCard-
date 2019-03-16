<script>
    var markers = [];
    function showGrid()
    {
        var listElement = document.getElementById("listType");
        var gridElement = document.getElementById("gridType");
        var listButton = document.getElementById("listMode");
        var gridButton = document.getElementById("gridMode");
        var btnMap = document.getElementById("google")

        gridElement.style.display = "inline";
        listElement.style.display = "none";
        btnMap.style.display = "none";
        gridButton.className = "btn  grid-btn active  btn-sm";
        listButton.className = "btn list-btn btn-sm";

        var btnMap1 = document.getElementById("mapMode")
        var btnList = document.getElementById("itemMode");
        btnMap1.className = "btn  grid-btn btn-sm-6";
        btnList.className = "btn  grid-btn btn-sm-6 active";




    }
    function showList()
    {
        var listElement = document.getElementById("listType");
        var gridElement = document.getElementById("gridType");
        var listButton = document.getElementById("listMode");
        var gridButton = document.getElementById("gridMode");
        var btnMap = document.getElementById("google")
        gridElement.style.display = "none";
        listElement.style.display = "inline";

        var btnMap1 = document.getElementById("mapMode")
        var btnList = document.getElementById("itemMode");
        btnMap1.className = "btn  grid-btn btn-sm-6";
        btnList.className = "btn  grid-btn btn-sm-6 active";

        gridButton.className = "btn  grid-btn btn-sm";
        btnMap.style.display = "none";
        listButton.className = "btn list-btn btn-sm active";
    }
    function onSearch()
    {
        var formElement = document.getElementById("searchForm");
        var formData = new FormData(formElement);
        $.ajax({
            type: 'POST',
            data: formData,
            url: '/consumer/ajaxSearchGym',
            contentType: false,
            processData: false,
            success: function (data)
            {
                var element = document.getElementById("gymCount");
                element.innerHTML = "(" + data.length + ") GYMS";
                appendGymsGrid(data);
                appendGymsList(data);
            }
        });
        return false;
    }
    function appendGymsGrid(vendors)
    {

        var gridContainer = document.getElementById("ias-vendor-list");
        gridContainer.innerHTML = "";
        for (i = 0; i < vendors.length; i++)
        {
            vendorUser = vendors[i];
            var vendorContent = document.implementation.createHTMLDocument("New Document");
            var containerDiv = vendorContent.createElement("div");
            containerDiv.className = "col-md-4 vendor-box";
            gridContainer.appendChild(containerDiv);
            var imageElement = vendorContent.createElement("img");
            var aElement = vendorContent.createElement("a");
            var divFavElement = vendorContent.createElement("div");
            var aFavElement = vendorContent.createElement("a");
            var imgFavElement = vendorContent.createElement("i");
            aFavElement.appendChild(imgFavElement);
            imgFavElement.className = "fa fa-heart";
            divFavElement.className = "favourite-bg";
            divFavElement.appendChild(aFavElement);
            aElement.href = "/consumer/detailgym/" + vendorUser.gid;
            imageElement.src = <?php echo "'" . url('/')  . "/'"; ?> + vendorUser.image;
            if (vendorUser.image == "")
            {
                imageElement.src = "";
                imageElement.style = "width:100%;height:120px;";
            }
            imageElement.className = "img-responsive";
            imageElement.alt = "";
            var divImage = vendorContent.createElement("div");
            divImage.className = "vendor-image";
            aElement.appendChild(imageElement);
            divImage.appendChild(aElement);
            divImage.appendChild(divFavElement);
            containerDiv.appendChild(divImage);
            var divDetail = vendorContent.createElement("div");
            divDetail.className = "vendor-detail";
            containerDiv.appendChild(divDetail);
            var divCaption = vendorContent.createElement("div");
            var divPrice = vendorContent.createElement("div");
            var divCategory = vendorContent.createElement("div");
            divPrice.appendChild(divCategory);
            divCategory.className = "price";
            divCategory.style = "height:30px;font-size:12px;";
            divCategory.innerHTML = vendorUser.category;
            divPrice.className = "vendor-price";
            divCaption.className = "caption";
            divDetail.appendChild(divCaption);
            divDetail.appendChild(divPrice);
            var h2Element = vendorContent.createElement("h2");
            var pElement = vendorContent.createElement("p");
            var divElement = vendorContent.createElement("div");
            divCaption.appendChild(h2Element);
            divCaption.appendChild(pElement);
            divCaption.appendChild(divElement);
            //h2
            var ah2Element = vendorContent.createElement("a");
            ah2Element.className = "title";
            ah2Element.innerHTML = vendorUser.name;
            ah2Element.href = "/consumer/detailgym/" + vendorUser.gid;
            h2Element.appendChild(ah2Element);
            pElement.className = "location";
            var iElement = vendorContent.createElement("i");
            iElement.className = "fa fa-map-marker";
            pElement.appendChild(iElement);
            pElement.innerHTML = pElement.innerHTML + " " + vendorUser.city;
            //div
            divElement.className = "rating";
            divElement.style.text_align = "center";

            var starCount = 0;
            var j = 0;
            for (j = 0; j < Math.floor(vendorUser.rating); j++)
            {
                var iElement = vendorContent.createElement("i");
                iElement.className = "fa fa-star";
                divElement.appendChild(iElement);
                starCount++;
            }
            if (starCount < 4) {
                dec = vendorUser.rating - Math.floor(vendorUser.rating);
                if (dec < 0.5)
                {
                    var iElement = vendorContent.createElement("i");
                    iElement.className = "fa fa-star-o";
                    divElement.appendChild(iElement);
                }
                else
                {
                    var iElement = vendorContent.createElement("i");
                    iElement.className = "fa fa-star-half-full";
                    divElement.appendChild(iElement);
                }
                starCount++;
            }
            for (j = starCount; j < 5; j++) {
                var iElement = vendorContent.createElement("i");
                iElement.className = "fa fa-star-o";
                divElement.appendChild(iElement);
            }
            var spanElement = vendorContent.createElement("span");
            spanElement.className = "rating-count";
            spanElement.innerHTML = " (" + vendorUser.reviews + <?php echo trans('web.consumerReviews');?>;
            divElement.appendChild(spanElement);
        }
    }
    function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
    }
    function appendGymsList(vendors)
    {

        var gridContainer = document.getElementById("ias-vendor-list1");
        gridContainer.innerHTML = "";
        for (i = 0; i < vendors.length; i++)
        {
            vendorUser = vendors[i];

            var vendorContent = document.implementation.createHTMLDocument("New Document");
            var parentDiv = vendorContent.createElement("div");
            var rowDiv = vendorContent.createElement("div");
            parentDiv.className = "col-md-12 vendor-box vendor-box-grid";
            rowDiv.className = "row";
            parentDiv.appendChild(rowDiv);
            gridContainer.appendChild(parentDiv);

            var containerDiv = vendorContent.createElement("div");
            containerDiv.className = "col-md-6 no-right-pd";
            gridContainer.appendChild(containerDiv);
            var imageElement = vendorContent.createElement("img");
            var aElement = vendorContent.createElement("a");
            aElement.href = "/consumer/detailgym/" + vendorUser.gid;
            imageElement.src = <?php echo "'" . url('/')  . "/'"; ?> + vendorUser.image;
            imageElement.className = "img-responsive";
            imageElement.alt = "";
            var divImage = vendorContent.createElement("div");
            divImage.className = "vendor-image";
            aElement.appendChild(imageElement);
            divImage.appendChild(aElement);
            containerDiv.appendChild(divImage);
            rowDiv.appendChild(containerDiv);

            var divFavElement = vendorContent.createElement("div");
            var aFavElement = vendorContent.createElement("a");
            var imgFavElement = vendorContent.createElement("i");
            aFavElement.appendChild(imgFavElement);
            imgFavElement.className = "fa fa-heart";
            divFavElement.className = "favourite-bg";
            divFavElement.appendChild(aFavElement);
            divImage.appendChild(divFavElement);

            var divDetail = vendorContent.createElement("div");
            divDetail.className = "col-md-6 vendor-detail";

            rowDiv.appendChild(divDetail);
            var divCaption = vendorContent.createElement("div");
            var divPrice = vendorContent.createElement("div");
            var divCategory = vendorContent.createElement("div");
            divCategory.className = "price";
            divCategory.style = "height:30px;font-size:12px;";
            divCategory.innerHTML = vendorUser.category;
            divPrice.appendChild(divCategory);
            divPrice.className = "vendor-price";
            divCaption.className = "caption";
            divDetail.appendChild(divCaption);
            divDetail.appendChild(divPrice);
            var h2Element = vendorContent.createElement("h2");
            var pElement = vendorContent.createElement("p");
            var divElement = vendorContent.createElement("div");
            divCaption.appendChild(h2Element);
            divCaption.appendChild(pElement);
            divCaption.appendChild(divElement);
            //h2
            var ah2Element = vendorContent.createElement("a");
            ah2Element.className = "title";
            ah2Element.innerHTML = vendorUser.name;
            ah2Element.href = "/consumer/detailgym/" + vendorUser.gid;
            h2Element.appendChild(ah2Element);
            pElement.className = "location";
            var iElement = vendorContent.createElement("i");
            iElement.className = "fa fa-map-marker";
            pElement.appendChild(iElement);
            pElement.innerHTML = pElement.innerHTML + " " + vendorUser.city;
            //div
            divElement.className = "rating";
            divElement.style.text_align = "center";

            var starCount = 0;
            var j = 0;
            for (j = 0; j < Math.floor(vendorUser.rating); j++)
            {
                var iElement = vendorContent.createElement("i");
                iElement.className = "fa fa-star";
                divElement.appendChild(iElement);
                starCount++;
            }
            if (starCount < 4) {
                dec = vendorUser.rating - Math.floor(vendorUser.rating);
                if (dec < 0.5)
                {
                    var iElement = vendorContent.createElement("i");
                    iElement.className = "fa fa-star-o";
                    divElement.appendChild(iElement);
                }
                else
                {
                    var iElement = vendorContent.createElement("i");
                    iElement.className = "fa fa-star-half-full";
                    divElement.appendChild(iElement);
                }
                starCount++;
            }
            for (j = starCount; j < 5; j++) {
                var iElement = vendorContent.createElement("i");
                iElement.className = "fa fa-star-o";
                divElement.appendChild(iElement);
            }
            var spanElement = vendorContent.createElement("span");
            spanElement.className = "rating-count";
            spanElement.innerHTML = " (" + vendorUser.reviews + <?php echo trans('web.consumerReviews');?>;
            divElement.appendChild(spanElement);
        }
        setMapOnAll(null);
        markers = [];
        addMarker(vendors);
    }
    function addMarker(vendors)
    {
        for (i = 0; i < vendors.length; i++)
        {
            var bounds = new google.maps.LatLngBounds();

            // for loop traverses markersData array calling createMarker function for each marker

            var latlng = new google.maps.LatLng(vendors[i].lat, vendors[i].lng);
            createMarker(latlng, vendors[i].name, vendors[i].rating, "", vendors[i].gid, vendors[i].image);



            // marker position is added to bounds variable
            bounds.extend(latlng);

            map.fitBounds(bounds);
        }
    }
    function showMap()
    {
        var mapElement = document.getElementById("google");
        var listElement = document.getElementById("listType");
        var gridElement = document.getElementById("gridType");

        var btnMap = document.getElementById("mapMode")
        var btnList = document.getElementById("itemMode");
        btnMap.className = "btn  grid-btn btn-sm-6 active";
        btnList.className = "btn  grid-btn btn-sm-6";

        mapElement.style.display = "inline";
        listElement.style.display = "none";
        gridElement.style.display = "none";
        initialize();
    }
    function showItem()
    {
        var mapElement = document.getElementById("google");
        var listElement = document.getElementById("listType");
        var gridElement = document.getElementById("gridType");

        var btnMap = document.getElementById("mapMode")
        var btnList = document.getElementById("itemMode");
        btnMap.className = "btn  grid-btn btn-sm-6";
        btnList.className = "btn  grid-btn active btn-sm-6";


        mapElement.style.display = "none";
        listElement.style.display = "none";
        gridElement.style.display = "inline";


    }
    function showDetailDialog(name, rating, gid, image)
    {
        var dialogElement = document.getElementById("dialog");
        var nameElement = document.getElementById("dialog_name");
        var imageElement = document.getElementById("dialog_image");
        var detailElement = document.getElementById("dialog_detail");
        imageElement.src = '<?php echo url('/') ; ?>/' + image;
        nameElement.innerHTML = name;
        dialogElement.style.display = "inline";
        detailElement.href = "/consumer/detailgym/" + gid;
    }
    function closeDialog()
    {
        var dialogElement = document.getElementById("dialog");
        dialogElement.style.display = "none";
    }
</script>
<!--
<div class="tp-page-head">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h1>GYMS</h1>
                </div>
            </div>
        </div>
    </div>
</div>-->
<div class="tp-breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="/consumer"><?php echo trans('web.home');?></a></li>
                    <li class="active"><?php echo trans('web.gyms');?></li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-8 tp-title">
                <h2 id="gymCount">(<?php echo count($gymInfos); ?>) <?php echo trans('web.gyms');?> </h2>
            </div>
            <div class="col-md-4 text-right">
                <div class="btn-group"> <a href="#" onclick="showList()" id="listMode" class="btn list-btn btn-sm"><span class="fa fa-th-list"> </span> </a> <a href="#" onclick="showGrid()" id="gridMode" class="btn  grid-btn active  btn-sm"><span class="fa fa-th"></span> </a> </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="filter-sidebar">

                    <div class="col-md-12 text-right">

                        <a href="#" onclick="showMap()" id="mapMode" class="btn list-btn btn-sm">
                            <?php echo trans('web.map');?>
                        </a>
                        <a href="#" onclick="showItem()" id="itemMode" class="btn  grid-btn active btn-sm-6">
                            <?php echo trans('web.list');?>
                        </a>
                    </div>

                    <form id="searchForm" >
                        <input type="text" name="_token" id="token" style="visibility: hidden; width: 1px; height: 1px" value="{{ csrf_token() }}">
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
                                    <option value="<?php echo $cityInfos[$i]->city_name; ?>"><?php echo $cityInfos[$i]->city_name; ?></option>
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
                                                    <input type="checkbox" name="location_<?php echo $locationInfos[$i]->no ?>" id="weddinghall" class="styled">
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
                                                    <input type="checkbox" name="studio_<?php echo $studioInfos[$i]->no ?>" id="weddinghall" class="styled">
                                                    <label for="weddinghall" class="control-label"> <?php echo $studioInfos[$i]->name; ?> </label>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> <?php echo trans('web.category');?> </a> </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                        <div class="panel-body">
                                            <?php
                                            for ($i = 0; $i < count($activityInfos); $i++) {
                                                ?>
                                                <div class="checkbox checkbox-success">
                                                    <input type="checkbox" name="activity_<?php echo $activityInfos[$i]->no ?>" id="weddinghall" class="styled">
                                                    <label for="weddinghall" class="control-label"> <?php echo $activityInfos[$i]->category; ?> </label>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingFour">
                                        <h4 class="panel-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree"><?php echo trans('web.amenity');?></a> </h4>
                                    </div>
                                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                        <div class="panel-body">
                                            <?php
                                            for ($i = 0; $i < count($amentityInfos); $i++) {
                                                ?>
                                                <div class="checkbox checkbox-success">
                                                    <input type="checkbox" name="amentity_<?php echo $amentityInfos[$i]->no ?>" id="weddinghall" class="styled">
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
                    <div id="ias-vendor-list">
                        <?php
                        for ($i = 0; $i < count($gymInfos); $i++) {
                            $gymInfo = $gymInfos[$i];
                            ?>
                            <div class="col-md-4 vendor-box"><!-- venue box start-->
                                <div class="vendor-image"><!-- venue pic -->
                                    <a href="/consumer/detailgym/{{ $gymInfo['gid'] }}">
                                        @if ($gymInfo['image'] == "")
                                            <img src="" style="width:100%;height:120px;"  class="img-responsive">
                                        @else
                                            <img src="{{ url($gymInfo['image']) }}"  class="img-responsive">
                                        @endif
                                    </a>
                                    @if ($isLogin)
                                        <div class="favourite-bg"><a href="/consumer/detailgym/{{ $gymInfo['gid'] }}" class=""><i class="fa fa-star"></i></a></div>
                                    @endif
                                </div>
                                <!-- /.venue pic -->
                                <div class="vendor-detail"><!-- venue details -->
                                    <div class="caption"><!-- caption -->
                                        <h2><a href="/consumer/detailgym/<?php echo $gymInfo['gid'] ?>" class="title"><?php echo $gymInfo['name']; ?></a></h2>
                                        <p class="location"><i class="fa fa-map-marker"></i>
                                            <?php echo $gymInfo['city']; ?>
                                        </p>
                                        <div class="rating pull-left">
                                            <?php
                                            $starCount = 0;
                                            for ($j = 0; $j < (int) $gymInfo['rating']; $j++) {
                                                echo "<i class='fa fa-star'></i>";
                                                $starCount++;
                                            }
                                            if ($starCount < 4) {
                                                $dec = $gymInfo['rating'] - (int) $gymInfo['rating'];
                                                if ($dec < 0.5)
                                                    echo "<i class='fa fa-star-o'></i>";
                                                else
                                                    echo "<i class='fa fa-star-half-full'></i>";
                                                $starCount++;
                                            }
                                            for ($j = $starCount; $j < 5; $j++) {
                                                echo "<i class='fa fa-star-o'></i>";
                                            }
                                            ?>
                                            <span class="rating-count">(<?php echo $gymInfo['reviews']; ?> <?php echo trans('web.consumerReviews');?>)</span>
                                        </div>
                                    </div>
                                    <div class="vendor-price">
                                        <div class="price" style="height:30px; font-size:12px;"><?php echo $gymInfo['category']; ?></div>
                                    </div>
                                </div>
                                <!-- venue details -->
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-9" id="google" style="display:none; height:610px;margin-bottom: 20px;">
                <div class="find-section" id="dialog" style="margin:0px; display:none; width:250px;"><!-- Find search section-->
                    <div class="container col-md-12">
                        <div class="row" class="container col-md-12">
                            <div class="finder-block col-md-12">
                                <div class="col-md-12" style="padding:0px;">
                                    <div class="col-md-12 vendor-box" style="padding:0px;"><!-- venue box start-->
                                        <div class="vendor-image"><!-- venue pic -->
                                            <a href="#"><img id="dialog_image" src="<?php echo url('/')  . "/"; ?>images/gym/gym_1463382500.jpg" alt="wedding venue" class="img-responsive"></a>
                                        </div>
                                        <!-- /.venue pic -->
                                        <div class="vendor-detail"><!-- venue details -->
                                            <div class="caption" style="padding:10px;"><!-- caption -->
                                                <p><a href="#" id="dialog_name" >Gym1</a></p>
                                                <!--<div class="rating pull-left"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <span class="rating-count">(22)</span> </div>-->
                                            </div>
                                            <div class="row" style="margin-left: 10px;margin-right: 10px;">
                                                <p class="pull-left"><a href="#" id="dialog_detail" >More Info</a></p>
                                                <p class="pull-right"><a href="#" onclick="closeDialog()" id="dialog_name" >Close</a></p>
                                            </div>
                                        </div>
                                        <!-- venue details -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.Find search section-->
                <div id="googleMap" class="map" style="height:100%;"></div>
            </div>
            <div class="col-md-9" id="listType" style="display:none;">

                <div class="row" id="ias-vendor-list1">
                    <?php
                    for ($i = 0; $i < count($gymInfos); $i++) {
                        $gymInfo = $gymInfos[$i];
                        ?>
                        <div class="col-md-12 vendor-box vendor-box-grid">
                            <div class="row">
                                <div class="col-md-6 no-right-pd">
                                    <div class="vendor-image">
                                        <a href="/consumer/detailgym/<?php echo $gymInfo['gid'] ?>"><img src="<?php echo url('/')  . "/" . $gymInfo['image']; ?>"  class="img-responsive"></a>
                                        <?php
                                        if ($isLogin) {
                                            ?>
                                            <div class="favourite-bg"><a href="#" class="/consumer/detailgym/<?php echo $gymInfo['gid'] ?>"><i class="fa fa-star"></i></a></div>
                                            <?php
                                        }
                                        ?>

                                    </div>
                                </div>
                                <div class=" col-md-6 vendor-detail">
                                    <div class="caption">
                                        <h2><a href="/consumer/detailgym/<?php echo $gymInfo['gid'] ?>" class="title"><?php echo $gymInfo['name']; ?></a></h2>
                                        <p class="location"><i class="fa fa-map-marker"></i> <?php echo $gymInfo['city']; ?></p>
                                        <div class="rating pull-left">
                                            <?php
                                            $starCount = 0;
                                            for ($j = 0; $j < (int) $gymInfo['rating']; $j++) {
                                                echo "<i class='fa fa-star'></i>";
                                                $starCount++;
                                            }
                                            if ($starCount < 4) {
                                                $dec = $gymInfo['rating'] - (int) $gymInfo['rating'];
                                                if ($dec < 0.5)
                                                    echo "<i class='fa fa-star-o'></i>";
                                                else
                                                    echo "<i class='fa fa-star-half-full'></i>";
                                                $starCount++;
                                            }
                                            for ($j = $starCount; $j < 5; $j++) {
                                                echo "<i class='fa fa-star-o'></i>";
                                            }
                                            ?>
                                            <span class="rating-count">(<?php echo $gymInfo['reviews']; ?> <?php echo trans('web.consumerReviews');?>)</span>
                                        </div>
                                    </div>
                                    <div class="vendor-price">
                                        <div class="price" style="height:30px; font-size:12px;"><?php echo $gymInfo['category']; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="http://maps.googleapis.com/maps/api/js"></script>
    <script>
                                                        var map;
                                                        var infoWindow;


                                                        function initialize() {
                                                            var mapOptions = {
                                                                center: new google.maps.LatLng(61.9241, 25.7482),
                                                                zoom: 2,
                                                                mapTypeId: 'roadmap',
                                                            };

                                                            map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);

                                                            // a new Info Window is created
                                                            infoWindow = new google.maps.InfoWindow();

                                                            // Event that closes the Info Window with a click on the map
                                                            google.maps.event.addListener(map, 'click', function () {
                                                                infoWindow.close();
                                                            });

                                                            // Finally displayMarkers() function is called to begin the markers creation
                                                            displayMarkers();
                                                        }
                                                        google.maps.event.addDomListener(window, 'load', initialize);



                                                        function displayMarkers() {

                                                            // this variable sets the map bounds according to markers position
                                                            var bounds = new google.maps.LatLngBounds();

                                                            // for loop traverses markersData array calling createMarker function for each marker
                                                            if (markers.length == 0)
                                                            {
<?php
for ($i = 0; $i < count($gymInfos); $i++) {
    $gymInfo = $gymInfos[$i];
    if ($gymInfo['lat'] !="" && $gymInfo['lng'] !="")
    {
    ?>
                                                                    var latlng = new google.maps.LatLng(<?php echo $gymInfo['lat'] . "," . $gymInfo['lng']; ?>);
                                                                    createMarker(latlng, "<?php echo $gymInfo['name']; ?>", "<?php echo $gymInfo['rating']; ?>"
                                                                            , "<?php echo $gymInfo['reviews']; ?>", "<?php echo $gymInfo['gid'] ?>", "<?php echo $gymInfo['image'] ?>");

                                                                    // marker position is added to bounds variable
                                                                    bounds.extend(latlng);
    <?php
    }
}
?>
                                                            }
                                                            else
                                                            {
                                                                setMapOnAll(map);
                                                            }

                                                            // Finally the bounds variable is used to set the map bounds
                                                            // with fitBounds() function
                                                            map.fitBounds(bounds);
                                                            map.setCenter(new google.maps.LatLng(61.9241, 25.7482));
                                                            map.setZoom(2);
                                                        }

                                                        function createMarker(latlng, name, address1, address2, postalCode, image) {
                                                            var marker = new google.maps.Marker({
                                                                map: map,
                                                                position: latlng,
                                                                title: name
                                                            });
                                                            markers.push(marker);

                                                            google.maps.event.addListener(marker, 'click', function () {

                                                                // Variable to define the HTML content to be inserted in the infowindow
                                                                var iwContent = '<div id="iw_container">' +
                                                                        '<div class="iw_title">' + name + '</div>' +
                                                                        '<div class="iw_content"> Rating:' + address1 + '<br /> <a href="/consumer/detailgym/' + postalCode + '">More Info</a><br /></div></div>';

                                                                // including content to the infowindow
                                                                infoWindow.setContent(iwContent);

                                                                // opening the infowindow in the current map and at the current marker location
                                                                //infoWindow.open(map, marker);
                                                                showDetailDialog(name, address1, postalCode, image);
                                                            });
                                                        }


    </script>
