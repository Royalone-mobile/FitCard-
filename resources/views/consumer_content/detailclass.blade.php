
<div class="tp-breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <ol class="breadcrumb">
                    <li><a href="/consumer"><?php echo trans('web.home'); ?></a></li>
                    <li><a href="/consumer/detailgym/<?php echo $classData['gid']; ?>">GYM1</a></li>
                    <li class='active'><?php echo $classData['name']; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container venue-header">
    <div class="row venue-head">
        <div class="col-md-12 title">

        </div>
        <div class="col-md-8 rating-box">
            <div class="rating">
                <?php
                $starCount = 0;
                for ($j = 0; $j < (int) $classData['rating']; $j++) {
                    echo "<i class='fa fa-star'></i>";
                    $starCount++;
                }
                if ($starCount < 4) {
                    $dec = $classData['rating'] - (int) $classData['rating'];
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
            </div>
        </div>
        <?php
        if ($isLogin) {
            if ($isBook) {
                ?>
                <div class="col-md-4 venue-action"><a href="#" class="btn tp-btn-primary"><?php echo trans('web.booked'); ?></a> </div>
                <?php
            } else {
                if ($bookCount < $classData['value'])
                {
                ?>
                <div class="col-md-4 venue-action"><a href="/consumer/actionBookClass/<?php echo $classData['no']; ?>" class="btn tp-btn-default"><?php echo trans('web.book'); ?></a> </div>
                <?php
                }
                else
                {
                  ?>
                  <div class="col-md-4 venue-action"><a href="#" class="btn tp-btn-default"><?php echo trans('web.full'); ?></a> </div>
                <?php
              }
            }
        }
        ?>
    </div>
</div>
<div class="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-7 page-description">
              <div class="venue-details">
                  <h2><?php echo $classData['name']; ?></h2>
                  <p><?php echo trans('web.gymName'); ?>: <?php echo $classData['gymName']; ?></p>
                  <p><?php echo trans('web.category'); ?>: <?php echo $classData['category']; ?></p>
                  <p><?php echo trans('web.location'); ?>: <?php echo $classData['location']; ?></p>
                  <?php
                    $classDate = \DateTime::createFromFormat('Y-m-d',$classData['date']);
                    $classDate->setTimezone(new \DateTimeZone('Europe/Helsinki'));
                    $endTm = substr($classData['end'],0,5);
                    ?>
                  <p><?php echo trans('web.date'); ?>: <?php echo $classDate->format('d/m')." ".substr($classData['start'],5)."~".$endTm;?></p>
              </div>
                <div class="venue-details">
                    <h2><?php echo trans('web.description'); ?></h2>
                    <p><?php echo $classData['description']; ?></p>
                </div>
                <div id="googleMap" class="map"></div>

                <div class="customer-review">
                    <div class="row">
                        <div class="col-md-12">
                            <h2><?php echo trans('web.reviews'); ?></h2>
                            <div class="review-list">
                                <!-- First Comment -->
                                <?php
                                for ($i = 0; $i < count($classData['reviews']); $i++) {
                                    $reviewData = $classData['reviews'][$i];
                                    ?>
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10">
                                            <div class="panel panel-default arrow left">
                                                <div class="panel-body">
                                                    <?php echo $reviewData['title'] ?>
                                                    <?php
                                                    $starCount = 0;
                                                    for ($j = 0; $j < (int) $reviewData['rating']; $j++) {
                                                        echo "<i class='fa fa-star' style='color:#ffc513;'></i>";
                                                        $starCount++;
                                                    }
                                                    if ($starCount < 4) {
                                                        $dec = $reviewData['rating'] - (int) $reviewData['rating'];
                                                        if ($dec < 0.5)
                                                            echo "<i class='fa fa-star-o' style='color:#ffc513;'></i>";
                                                        else
                                                            echo "<i class='fa fa-star-half-full' style='color:#ffc513;'></i>";
                                                        $starCount++;
                                                    }
                                                    for ($j = $starCount; $j < 5; $j++) {
                                                        echo "<i class='fa fa-star-o' style='color:#ffc513;'></i>";
                                                    }
                                                    ?>
                                                    <span style="float:right;" class="review-date"><?php echo date("d/m/Y", strtotime($reviewData['date'])); ?></span>
                                                    <div class="review-post">
                                                        <p> <?php echo $reviewData['description'] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                            if ($isLogin == true) {
                                ?>
                                <div class="review">
                                    <a class="btn tp-btn-primary btn-block tp-btn-lg" role="button" data-toggle="collapse" href="#review" aria-expanded="false" aria-controls="review"> <?php echo trans('web.writeReview'); ?></a> </div>
                                <div class="collapse review-list review-form" id="review">
                                    <div class="panel panel-default">
                                        <div class="panel-body">

                                            <h1><?php echo trans('web.review'); ?></h1>
                                            <form class="" method="POST" action="/consumer/actionCreateReview">
                                                <input type="text" name="_token" id="token" style="visibility: hidden; width: 1px; height: 1px" value="{{ csrf_token() }}">
                                                <input type="hidden" name="class_id" value="<?php echo $classData['no']; ?>"/>
                                                <input type="hidden" name="gym_id" value="<?php echo $classData['gid']; ?>"/>
                                                <div class="rating-group">
                                                    <div class="radio radio-success radio-inline">
                                                        <input type="radio" name="radio1" id="radio1" value="1">
                                                        <label for="radio1" class="radio-inline"> <span class="rating"><i class="fa fa-star"></i></span> </label>
                                                    </div>
                                                    <div class="radio radio-success radio-inline">
                                                        <input type="radio" name="radio1" id="radio2" value="2">
                                                        <label for="radio2" class="radio-inline"> <span class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i></span> </label>
                                                    </div>
                                                    <div class="radio radio-success radio-inline">
                                                        <input type="radio" name="radio1" id="radio3" value="3">
                                                        <label for="radio3" class="radio-inline"> <span class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span> </label>
                                                    </div>
                                                    <div class="radio radio-success radio-inline">
                                                        <input type="radio" name="radio1" id="radio4" value="4">
                                                        <label for="radio4" class="radio-inline"> <span class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span> </label>
                                                    </div>
                                                    <div class="radio radio-success radio-inline">
                                                        <input type="radio" name="radio1" id="radio5" value="5">
                                                        <label for="radio5" class="radio-inline"> <span class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span> </label>
                                                    </div>
                                                </div>

                                                <!-- Text input-->
                                                <div class="form-group">
                                                    <label class=" control-label" for="reviewtitle"><?php echo trans('web.reviewTitle'); ?></label>
                                                    <div class=" ">
                                                        <input id="reviewtitle" name="reviewtitle" type="text" placeholder="<?php echo trans('web.reviewTitle'); ?>" class="form-control input-md" required>
                                                    </div>
                                                </div>

                                                <!-- Textarea -->
                                                <div class="form-group">
                                                    <label class=" control-label"><?php echo trans('web.reviewContent'); ?></label>
                                                    <div class="">
                                                        <textarea class="form-control" name="reviewcontent" rows="8"></textarea>
                                                    </div>
                                                </div>
                                                <!-- Button -->
                                                <div class="form-group">
                                                    <button name="submit" class="btn tp-btn-default tp-btn-lg"><?php echo trans('web.submit'); ?></button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- /.comments -->

            </div>
            <!--
            <div class="col-md-5 page-sidebar">
                <div class="row">
                    <div class="col-md-12" >
                        <div class="well-box" id="inquiry">
                            <h2>Visitors List</h2>
                            <form class="">
            <?php
            for ($i = 0; $i < count($visitors); $i++) {
                $visitor = $visitors[$i];
                ?>
                                        <div class="row" style="margin-top:5px;">
                                            <div class="col-md-12">
                                                <p><?php echo $visitor->name . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp" . $visitor->date; ?></p>
                                            </div>
                                        </div>
                <?php
            }
            ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            -->
        </div>
    </div>
</div>

<script src="http://maps.googleapis.com/maps/api/js"></script>
<script>
var myCenter = new google.maps.LatLng(<?php echo $classData['lat']; ?>, <?php echo $classData['lon']; ?>);
function initialize()
{
    var mapProp = {
        center: myCenter,
        zoom: 9,
        scrollwheel: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

    var marker = new google.maps.Marker({
        position: myCenter,
        icon: '<?php echo url('/') . "/images/map_icon.png"; ?>'
    });
    marker.setMap(map);
    var infowindow = new google.maps.InfoWindow({
        content: "Hello Address"
    });
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
