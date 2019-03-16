<meta name="csrf-token" content="{{ csrf_token() }}" />


<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


    function changeEndTime(startId,endId)
    {
      var startElement = document.getElementById(startId);
      var endElement = document.getElementById(endId);
      var t1 = new Date();
      var parts1 = startElement.value.split(":");
      t1.setHours(parts1[0],parts1[1],0,0);
      var t2 = new Date();
      parts = endElement.value.split(":");
      t2.setHours(parts[0],parts[1],0,0);
      if (t1.getTime()>t2.getTime())
      {
        var newHour = parseInt(parts1[0]) + 1;
        endElement.value = newHour + ":" + parts1[1];
      }
    }
    function changeDate(id)
    {
      var element = document.getElementById(id);
      var currentDate = new Date();
      var inputDate = new Date(element.value);
      if (currentDate > inputDate)
      {
        var month = currentDate.getMonth() + 1;
        var day = currentDate.getDate();
        if (month < 10)
          month = "0" + month;
        if (day < 10)
          day = "0" + day;
        element.value = currentDate.getFullYear() + "-" + month  + "-" + day;
      }
    }
    function changeRecuring()
    {
        var selectElement = document.getElementById("class_recurring");
        var divElement = document.getElementById("divEndDate");
        if (selectElement.value == 0)
        {
          divElement.style.display = "none";
        }
        else
          divElement.style.display = "inline";

    }

    function createClass()
    {
        var tokenElement = document.getElementById("token");
        tokenElement.value = CSRF_TOKEN;

        var nameElement = document.getElementById("class_name");
        var valueElement = document.getElementById("class_value");
        var descriptionElement = document.getElementById("class_description");
        var stimeElement = document.getElementById("class_starttime");
        var etimeElement = document.getElementById("class_endtime");
        var dateElement = document.getElementById("reservation");


        var formElement = document.getElementById("profileForm");

        if ((nameElement.value == "") || (valueElement.value == "")
                || (descriptionElement.value == "") || (stimeElement.value == "")
                || (etimeElement.value == "")
                || (dateElement.value == ""))
        {
            alert("Please fill Input");
            return;
        }
        if (stimeElement.value == etimeElement.value)
        {
          alert("Start and End Time is Same.");
          return;
        }
        formElement.action = "/company/actionCreateClass";
        formElement.submit();
        return;
    }
</script>
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.createClass');?></h3>
    </div>
    <div class="box box-primary">
        <form role="form" method="post" id="profileForm">
            <input type="text" name="_token" id="token" style="visibility: hidden; width: 1px; height: 1px">
            <div class="box-body">
                <input type="hidden" name="imagepath" id="imagePath" style="visibility: hidden; width: 1px; height: 1px">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.name');?></label>
                            <input type="email" class="form-control" id="class_name" name="class_name" placeholder="<?php echo trans('web.name');?>">
                        </div>
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.spot');?></label>
                            <input type="email" class="form-control" id="class_value" onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="class_value" placeholder="<?php echo trans('web.spot');?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo trans('web.startDate');?></label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" name="class_date" id="reservation">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3" id="divEndDate">
                            <div class="form-group" >
                                <label><?php echo trans('web.endDate');?></label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" name="class_dateend" onchange="changeDate('reservation1')" id="reservation1">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label><?php echo trans('web.startTime');?></label>

                                    <div class="input-group">
                                        <input type="text" name="class_starttime" id="class_starttime" class="form-control timepicker">

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
                                    <label><?php echo trans('web.endTime');?></label>

                                    <div class="input-group">
                                        <input type="text" name="class_endtime" id="class_endtime" class="form-control timepicker" onchange="changeEndTime('class_starttime','class_endtime');">

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
                            <label for="exampleInputEmail1"><?php echo trans('web.category');?></label>
                            <select class="form-control" name="class_category">
                                <?php
                                for ($i = 0; $i < count($categoryInfos); $i++) {
                                    $categoryInfo = $categoryInfos[$i];
                                    ?>
                                    <option value="<?php echo $categoryInfo->id; ?>"><?php echo $categoryInfo->category; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1"><?php echo trans('web.description');?></label>
                            <input type="email" class="form-control" id="class_description" name="class_description" placeholder="<?php echo trans('web.description');?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.gym');?></label>
                            <select class="form-control" name="class_gym">
                                <?php
                                for ($i = 0; $i < count($gymInfos); $i++) {
                                    $gymInfo = $gymInfos[$i];
                                    ?>
                                    <option value="<?php echo $gymInfo->id; ?>"><?php echo $gymInfo->name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.recurring');?></label>
                            <select class="form-control" id="class_recurring" name="class_recurring" onchange="changeRecuring()">
                                <option value="0"><?php echo trans('web.none');?></option>
                                <option value="1"><?php echo trans('web.daily');?></option>
                                <option value="2"><?php echo trans('web.weekly');?></option>
                                <option value="3"><?php echo trans('web.monthly');?></option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
        </form>
        <div class="box-footer">
            <button class="btn btn-primary" onclick="createClass()"><?php echo trans('web.create');?></button>
        </div>
        <!-- /.box-body -->
    </div>
</div>
<script>
  changeRecuring();
</script>
