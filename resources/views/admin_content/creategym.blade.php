<meta name="csrf-token" content="{{ csrf_token() }}" />
<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    function disableTime(startId,endId,currentId)
    {
      var startElement = document.getElementById(startId);
      var endElement = document.getElementById(endId);
      var checkElement = document.getElementById(currentId);
      if (checkElement.checked == true)
      {
        startElement.disabled = true;
        endElement.disabled = true;
      }
      else {
        startElement.disabled = false;
        endElement.disabled = false;
      }
    }
    function createPlayer()
    {

        var nameElement = document.getElementById("gym_name");
        var bankElement = document.getElementById("gym_bankaccount");
        var descElement = document.getElementById("gym_description");
        var useElement = document.getElementById("gym_usability");


        var formElement = document.getElementById("profileForm");

        if ((nameElement.value == "")
                || (bankElement.value == "") || (descElement.value == "")
                || (useElement.value == ""))
        {
            alert("Please fill Input");
            return;
        }
        var activityElements = document.getElementsByClassName("activity");
        var activityIds = "";
        for (var i = 0; i < activityElements.length; i++)
        {
            if (activityElements[i].checked)
                activityIds = activityIds + "-" + activityElements[i].value;
        }
        var activityElement = document.getElementById("gym_activityid");
        activityElement.value = activityIds;

        var amentityElements = document.getElementsByClassName("amentity");
        var amentityIds = "";
        for (var i = 0; i < amentityElements.length; i++)
        {
            if (amentityElements[i].checked)
                amentityIds = amentityIds + "-" + amentityElements[i].value;
        }
        var amentityElement = document.getElementById("gym_amentityid");
        amentityElement.value = amentityIds;

        var studioElements = document.getElementsByClassName("studio");
        var studioIds = "";
        for (var i = 0; i < studioElements.length; i++)
        {
            if (studioElements[i].checked)
                studioIds = studioIds + "-" + studioElements[i].value;
        }
        var studioElement = document.getElementById("gym_studioid");
        studioElement.value = studioIds;

        var locationElements = document.getElementsByClassName("location");
        var locationIds = "";
        for (var i = 0; i < locationElements.length; i++)
        {
            if (locationElements[i].checked)
                locationIds = locationIds + "-" + locationElements[i].value;
        }
        var locationElement = document.getElementById("gym_locationid");
        locationElement.value = locationIds;

        var categoryElements = document.getElementsByClassName("category");
        var categoryIds = "";
        for (var i = 0; i < categoryElements.length; i++)
        {
            if (categoryElements[i].checked)
                categoryIds = categoryIds + "-" + categoryElements[i].value;
        }
        var categoryElement = document.getElementById("gym_categoryid");
        categoryElement.value = categoryIds;



        formElement.action = "/admin/actionCreateGym";
        formElement.submit();
        return;
    }
    function uploadImage()
    {
        var fileElement = document.getElementById("form_Image");
        var preview = document.getElementById('imgBusinessImage'); //selects the query named img
        var formData = new FormData(fileElement);
        $.ajax({
            type: 'POST',
            data: formData,
            url: '/admin/ajaxUploadGymImage',
            contentType: false,
            processData: false,
            success: function (data)
            {
                obj = JSON.parse(data);
                preview.src = <?php echo "\"" . url('/')  . "/" . "\""; ?> + obj.path;
                var imgPath = document.getElementById("imagePath1");
                imgPath.value = obj.path;
            }
        });
    }
    function uploadLogo()
    {
        var fileElement = document.getElementById("form_logo");
        var preview = document.getElementById('imgBusinessLogo'); //selects the query named img
        var formData = new FormData(fileElement);
        $.ajax({
            type: 'POST',
            data: formData,
            url: '/admin/ajaxUploadGymLogo',
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
    function previewImage() {
        var preview = document.getElementById('imgBusinessImage'); //selects the query named img
        var file = document.getElementById('uploadImage');
        var reader = new FileReader();
        reader.onloadend = function () {
            uploadImage();
            //preview.src = reader.result;
        }
        if (file) {
            reader.readAsDataURL(file.files[0]); //reads the data as a URL
        } else {
            preview.src = "";
        }
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

</script>
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.createGym');?></h3>
    </div>
    <div class="box box-primary">
        <div class="box-body">
            <form name="form_logo" id="form_logo" class="col-md-6" method="post" action="/admin/ajaxUploadGymLogo">
              <label style="margin-left:175px;"><?php echo trans('web.logoGym1');?></label>
                <input type="file" accept="image/*" name="uploadLogo" id="upload" style="visibility: hidden; width: 1px; height: 1px" multiple onchange="previewFile()">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic col-md-12"> <img src="" style="height:159px;width:350px;"id="imgBusinessLogo" onclick="document.getElementById('upload').click();
                        return false" class="img-responsive " alt=""> </div>
            </form>
            <form name="form_Image" id="form_Image" method="post" action="/admin/ajaxUploadGymImage">
              <label style="margin-left:70px;"><?php echo trans('web.logoGym2');?></label>
                <input type="file" accept="image/*" name="uploadImage" id="uploadImage" style="visibility: hidden; width: 1px; height: 1px" multiple onchange="previewImage()">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic col-md-6"> <img src="" style="height:159px;width:159px;"id="imgBusinessImage" onclick="document.getElementById('uploadImage').click();
                        return false" class="img-responsive " alt=""> </div>
            </form>
            <form role="form" method="post" id="profileForm">
                <input type="hidden" name="gym_image" id="imagePath" style="visibility: hidden; width: 1px; height: 1px">
                <input type="hidden" name="gym_image1" id="imagePath1" style="visibility: hidden; width: 1px; height: 1px">

                <input type="hidden" name="gym_activityid" id="gym_activityid" value="" style="visibility: hidden; width: 1px; height: 1px">
                <input type="hidden" name="gym_studioid" id="gym_studioid" value="" style="visibility: hidden; width: 1px; height: 1px">
                <input type="hidden" name="gym_locationid" id="gym_locationid" value="" style="visibility: hidden; width: 1px; height: 1px">
                <input type="hidden" name="gym_amentityid" id="gym_amentityid" value="" style="visibility: hidden; width: 1px; height: 1px">
                <input type="hidden" name="gym_categoryid" id="gym_categoryid" value="" style="visibility: hidden; width: 1px; height: 1px">



                <input type="text" name="_token" id="token" value="{{ csrf_token() }}" style="visibility: hidden; width: 1px; height: 1px">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.name');?></label>
                            <input type="email" class="form-control" id="gym_name" name="gym_name" placeholder="<?php echo trans('web.name');?>">
                        </div>
                        <!--
                        <div class="col-md-3">
                            <label for="exampleInputEmail1">City</label>
                            <select name="gym_city" class="form-control">
                        <?php
                        for ($i = 0; $i < count($cityInfos); $i++) {
                            ?>
                                        <option value="<?php echo $cityInfos[$i]->id ?>"><?php echo $cityInfos[$i]->city_name; ?></option>
                            <?php
                        }
                        ?>
                            </select>
                        </div>
                        -->
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.bank');?></label>
                            <input type="email" class="form-control" id="gym_bankaccount" name="gym_bankaccount" placeholder="<?php echo trans('web.bank');?>">
                        </div>
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.usuability');?></label>
                            <input type="email" class="form-control" id="gym_usability" name="gym_usability" placeholder="<?php echo trans('web.usuability');?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1"><?php echo trans('web.description');?></label>
                            <input type="email" class="form-control" id="gym_description" name="gym_description" placeholder="<?php echo trans('web.description');?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.country');?></label>
                            <input type="email" class="form-control" id="gym_country" oninput="getCoor()" name="gym_country" placeholder="<?php echo trans('web.country');?>">
                        </div>
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.city');?></label>
                            <input type="email" class="form-control" oninput="getCoor()" id="gym_city" name="gym_city" placeholder="<?php echo trans('web.city');?>">
                        </div>
                        <div class="col-md-3">
                            <label for="exampleInputEmail1" ><?php echo trans('web.address');?></label>
                            <input type="email" class="form-control" oninput="getCoor()" id="gym_address" name="gym_address" placeholder="<?php echo trans('web.address');?>">
                        </div>
                        <div class="col-md-3">
                            <!--<button class="btn btn-primary" onclick="createCompany()">Fetch Coordinate</button>-->
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.latitude');?></label>
                            <input type="email" class="form-control" id="gym_lat" name="gym_lat" placeholder="<?php echo trans('web.latitude');?>">
                        </div>
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.longitude');?></label>
                            <input type="email" class="form-control" id="gym_lng" name="gym_lng" placeholder="<?php echo trans('web.longitude');?>">
                        </div>
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.company');?></label>
                            <select class="form-control" name="gym_company">
                                <?php
                                for ($i = 0; $i < count($companyInfos); $i++) {
                                    $companyInfo = $companyInfos[$i];
                                    ?>
                                    <option value="<?php echo $companyInfo->id; ?>"><?php echo $companyInfo->name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                    </div>
                    <div class="row" style="margin-top:10px">
                        <div class="col-md-1">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label style="margin-top:8px;"><?php echo trans('web.monday');?></label>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="gym_starttime_mon" id="gym_starttime_mon" class="form-control timepicker">

                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="gym_endtime_mon" id="gym_endtime_mon" class="form-control timepicker">

                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="bootstrap-timepicker">
                                <div class="form-group" style="padding-top:7px;">
                                    <input type="checkbox" onclick="disableTime('gym_starttime_mon','gym_endtime_mon','gym_mon_close')" name="gym_mon_close" id="gym_mon_close" >  <?php echo trans('web.close');?></input>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px">
                        <div class="col-md-1">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label style="margin-top:8px;"><?php echo trans('web.tuesday');?></label>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="gym_starttime_tue" id="gym_starttime_tue" class="form-control timepicker">

                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="gym_endtime_tue" id="gym_endtime_tue" class="form-control timepicker">

                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="bootstrap-timepicker">
                                <div class="form-group" style="padding-top:7px;">
                                    <input type="checkbox" onclick="disableTime('gym_starttime_tue','gym_endtime_tue','gym_tue_close')" name="gym_tue_close" id="gym_tue_close" >  <?php echo trans('web.close');?></input>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px">
                        <div class="col-md-1">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label style="margin-top:8px;"><?php echo trans('web.wednesday');?></label>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="gym_starttime_wed" id="gym_starttime_wed" class="form-control timepicker">

                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="gym_endtime_wed" id="gym_endtime_wed" class="form-control timepicker">

                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="bootstrap-timepicker">
                                <div class="form-group" style="padding-top:7px;">
                                    <input type="checkbox" onclick="disableTime('gym_starttime_wed','gym_endtime_wed','gym_wed_close')" name="gym_wed_close" id="gym_wed_close" >  <?php echo trans('web.close');?></input>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px">
                        <div class="col-md-1">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label style="margin-top:8px;"><?php echo trans('web.thursday');?></label>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="gym_starttime_thu" id="gym_starttime_thu" class="form-control timepicker">

                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="gym_endtime_thu" id="gym_endtime_thu" class="form-control timepicker">

                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="bootstrap-timepicker">
                                <div class="form-group" style="padding-top:7px;">
                                    <input type="checkbox" onclick="disableTime('gym_starttime_thu','gym_endtime_thu','gym_thu_close')" name="gym_thu_close" id="gym_thu_close" >  <?php echo trans('web.close');?></input>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px">
                        <div class="col-md-1">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label style="margin-top:8px;"><?php echo trans('web.friday');?></label>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="gym_starttime_fri" id="gym_starttime_fri" class="form-control timepicker">

                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="gym_endtime_fri" id="gym_endtime_fri" class="form-control timepicker">

                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="bootstrap-timepicker">
                                <div class="form-group" style="padding-top:7px;">
                                    <input type="checkbox" onclick="disableTime('gym_starttime_fri','gym_endtime_fri','gym_fri_close')" name="gym_fri_close" id="gym_fri_close" >  <?php echo trans('web.close');?></input>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px">
                        <div class="col-md-1">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label style="margin-top:8px;"><?php echo trans('web.saturday');?></label>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="gym_starttime_sat" id="gym_starttime_sat" class="form-control timepicker">

                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="gym_endtime_sat" id="gym_endtime_sat" class="form-control timepicker">

                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="bootstrap-timepicker">
                                <div class="form-group" style="padding-top:7px;">
                                    <input type="checkbox" onclick="disableTime('gym_starttime_sat','gym_endtime_sat','gym_sat_close')" name="gym_sat_close" id="gym_sat_close" >  <?php echo trans('web.close');?></input>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px">
                        <div class="col-md-1">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label style="margin-top:8px;"><?php echo trans('web.sunday');?></label>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="gym_starttime_sun" id="gym_starttime_sun" class="form-control timepicker">

                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="gym_endtime_sun" id="gym_endtime_sun" class="form-control timepicker" >

                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="bootstrap-timepicker">
                                <div class="form-group" style="padding-top:7px;">
                                    <input type="checkbox" onclick="disableTime('gym_starttime_sun','gym_endtime_sun','gym_sun_close')" name="gym_sun_close" id="gym_sun_close" >  <?php echo trans('web.close');?></input>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="exampleInputEmail1"><?php echo trans('web.activity');?></label>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th><?php echo trans('web.activity');?></th>
                            </tr>
                            <tr>
                                <?php
                                for ($i = 0; $i < count($activityInfos); $i++) {
                                    ?>
                                <tr>
                                    <td><input class="activity" type="checkbox" value="<?php echo $activityInfos[$i]->id; ?>"/></td>
                                    <td><?php echo $activityInfos[$i]->name; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <label for="exampleInputEmail1"><?php echo trans('web.amenity');?></label>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th><?php echo trans('web.amenity');?></th>
                            </tr>
                            <tr>
                                <?php
                                for ($i = 0; $i < count($amentityInfos); $i++) {
                                    ?>
                                <tr>
                                    <td><input class="amentity" type="checkbox" value="<?php echo $amentityInfos[$i]->id; ?>"/></td>
                                    <td><?php echo $amentityInfos[$i]->name; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <label for="exampleInputEmail1"><?php echo trans('web.studio');?></label>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th><?php echo trans('web.studio');?></th>
                            </tr>
                            <tr>
                                <?php
                                for ($i = 0; $i < count($studioInfos); $i++) {
                                    ?>
                                <tr>
                                    <td><input class="studio" type="checkbox" value="<?php echo $studioInfos[$i]->id; ?>"/></td>
                                    <td><?php echo $studioInfos[$i]->name; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label for="exampleInputEmail1"><?php echo trans('web.location');?></label>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th><?php echo trans('web.location');?></th>
                            </tr>
                            <tr>
                                <?php
                                for ($i = 0; $i < count($locationInfos); $i++) {
                                    ?>
                                <tr>
                                    <td><input class="location" type="checkbox" value="<?php echo $locationInfos[$i]->id; ?>"/></td>
                                    <td><?php echo $locationInfos[$i]->name; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <label for="exampleInputEmail1"><?php echo trans('web.category');?></label>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th><?php echo trans('web.category');?></th>
                            </tr>
                            <tr>
                                <?php
                                for ($i = 0; $i < count($categoryInfos); $i++) {
                                    ?>
                                <tr>
                                    <td><input class="category" type="checkbox" value="<?php echo $categoryInfos[$i]->id; ?>"/></td>
                                    <td><?php echo $categoryInfos[$i]->category; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <input name="visitCode" value="1" type="checkbox"> Enable Visit Code</input>
                  </div>
                </div>
            </form>
        </div>

        <div class="box-footer">
            <button class="btn btn-primary" onclick="createPlayer()"><?php echo trans('web.create');?></button>
        </div>
        <!-- /.box-body -->
    </div>
</div>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
<script type="text/javascript">
    function getCoor()
    {
        var country = document.getElementById('gym_country');
        var location = document.getElementById('gym_address');
        var city = document.getElementById('gym_city');
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            "address": country.value + " " + city.value + " " + location.value
        }, function (results) {
            if (results != null && results.length > 0)
                document.getElementById('gym_lat').value = results[0].geometry.location.lat();
            document.getElementById('gym_lng').value = results[0].geometry.location.lng();
        });
    }
</script>
