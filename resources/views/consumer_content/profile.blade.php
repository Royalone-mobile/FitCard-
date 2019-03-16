<script>
    function uploadLogo()
    {
        var fileElement = document.getElementById("form_logo");
        var preview = document.getElementById('imgBusinessLogo'); //selects the query named img
        var formData = new FormData(fileElement);
        $.ajax({
            type: 'POST',
            data: formData,
            url: '/consumer/ajaxUploadConsumerLogo',
            contentType: false,
            processData: false,
            success: function (data)
            {
                obj = JSON.parse(data);
                preview.src = <?php echo "\"" . url('/')  . "/" . "\""; ?> + obj.path;
                var imgPath = document.getElementById("imagePath");
                imgPath.value = obj.path;

            }
        });
    }

    function previewFile() {
        var preview = document.getElementById('imgBusinessLogo'); //selects the query named img
        var file = document.querySelector('input[type=file]').files[0]; //sames as here
        var reader = new FileReader();
        reader.onloadend = function () {
            uploadLogo();
            //preview.src = reader.result;
        }
        if (file) {
            reader.readAsDataURL(file); //reads the data as a URL
        } else {
            preview.src = "";
        }
    }
    function updateProfile()
    {
        var nameElement = document.getElementById("profile_name");
        var emailElement = document.getElementById("profile_email");


        var formElement = document.getElementById("profileForm");

        if ((nameElement.value == "") || (emailElement.value == ""))
        {
            alert("Please fill Input");
            return;
        }
        if (emailElement.value.indexOf("@") < 0)
        {
            alert("Please input correct Email address.");
            return;
        }
        formElement.action = "/consumer/actionUpdateProfile";
        formElement.submit();
        return;
    }
</script>


<div class="tp-breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <ol class="breadcrumb">
                    <li><a href="/consumer"><?php echo trans('web.home');?></a></li>
                    <li class="active"><a href="#"><?php echo trans('web.profile');?></a></li>                                        
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="main-container">
    <div class="container tabbed-page st-tabs">
        <div class="row">
            <div class="col-md-4">
                <div class="profile-sidebar side-box"> 
                    <form name="form_logo" id="form_logo" method="post">
                        <input type="text" name="_token" id="token" style="visibility: hidden; width: 1px; height: 1px" value="{{ csrf_token() }}">
                        <input type="file" accept="image/*" name="uploadLogo" id="upload" style="visibility: hidden; width: 1px; height: 1px" multiple onchange="previewFile()">
                        <!-- SIDEBAR USERPIC -->
                        <div class="profile-userpic"> 
                            <?php
                            if ($userInfo->image != "") {
                                ?>
                                <img src="<?php echo url('/')  . "/"; ?><?php echo $userInfo->image; ?>" style="height:159px;width:159px;border:0px;"id="imgBusinessLogo" onclick="document.getElementById('upload').click();
                                        return false" class="img-responsive img-circle" alt=""> </div>                        
                                     <?php
                                 } else {
                                     ?>
                            <img src="" style="height:159px;width:159px;border:0px;"id="imgBusinessLogo" onclick="document.getElementById('upload').click();
                                    return false" class="img-responsive img-circle" alt=""> </div>                        
                                 <?php
                             }
                             ?>
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name">
                                <h2><?php echo $userInfo->name; ?></h2>


                                <h2><?php echo trans('web.currentCredit');?> <?php echo $userInfo->credit . " Käyntikertaa"; ?></h2>                                
                                <a href="#"><i style="font-size:37px;" class="fa fa-facebook-square"></i></a>
                                
                            </div>                            
                        </div>                                                                        
                    </form>
                </div>
            </div>      
            <div class="col-md-8" >
                <div class="side-box" id="inquiry">
                    <h2><?php echo trans('web.profile');?></h2>

                    <form class="" id="profileForm" method="post">
                        <input type="text" name="_token" id="token" style="visibility: hidden; width: 1px; height: 1px" value="{{ csrf_token() }}">
                        <input type="hidden" name="profile_image" id="imagePath" style="visibility: hidden; width: 1px; height: 1px" value="<?php echo $userInfo->image; ?>">

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="control-label" for="name-one"><?php echo trans('web.name');?><span class="required">*</span></label>
                            <div class="">
                                <input id="profile_name" name="profile_name" value="<?php echo $userInfo->name; ?>" type="text" placeholder="<?php echo trans('web.name');?>" class="form-control input-md" required>
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="control-label" for="email-one"><?php echo trans('web.email');?><span class="required">*</span></label>
                            <div class="">
                                <input id="profile_email" name="profile_email" disabled value="<?php echo $userInfo->email; ?>" type="text" placeholder="<?php echo trans('web.email');?>" class="form-control input-md" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="email-one"><?php echo trans('web.phone');?><span class="required">*</span></label>
                            <div class="">
                                <input id="profile_email" name="profile_phone" value="<?php echo $userInfo->phone; ?>" type="text" placeholder="<?php echo trans('web.phone');?>" class="form-control input-md" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="email-one"><?php echo trans('web.city');?><span class="required">*</span></label>
                            <div class="">
                                <input id="profile_email" name="profile_city" value="<?php echo $userInfo->city; ?>" type="text" placeholder="<?php echo trans('web.city');?>" class="form-control input-md" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="email-one"><?php echo trans('web.address');?><span class="required">*</span></label>
                            <div class="">
                                <input id="profile_email" name="profile_address" value="<?php echo $userInfo->address; ?>" type="text" placeholder="<?php echo trans('web.address');?>" class="form-control input-md" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="email-one"><?php echo trans('web.zipCode');?><span class="required">*</span></label>
                            <div class="">
                                <input id="profile_email" name="profile_zip" value="<?php echo $userInfo->zip; ?>" type="text" placeholder="<?php echo trans('web.zipCode');?>" class="form-control input-md" required>
                            </div>
                        </div>
                    </form>
                    <div class="form-group">
                        <button class="btn tp-btn-default tp-btn-lg btn-block" onclick="updateProfile()"><?php echo trans('web.update');?></button>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<script src="js/owl.carousel.min.js"></script> 
<script type="text/javascript" src="js/thumbnail-slider.js"></script> 
<script src="http://maps.googleapis.com/maps/api/js"></script> 
<script>
                            var myCenter = new google.maps.LatLng(42, 120);

                            function initialize()
                            {
                                var mapProp = {
                                    center: myCenter,
                                    zoom: 9,
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                };

                                var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

                                var marker = new google.maps.Marker({
                                    position: myCenter,
                                    icon: 'images/pinkball.png'
                                });

                                marker.setMap(map);
                                var infowindow = new google.maps.InfoWindow({
                                    content: "Hello Address"
                                });
                            }

                            google.maps.event.addDomListener(window, 'load', initialize);
</script>