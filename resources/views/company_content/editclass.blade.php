<meta name="csrf-token" content="{{ csrf_token() }}" />


<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
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
    function updateClass()
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
        formElement.action = "/company/actionUpdateClass";
        formElement.submit();
        return;
    }
</script>
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.editClass');?></h3>
    </div>
    <div class="box box-primary">
        <form role="form" method="post" id="profileForm">
            <input type="text" name="_token" id="token" style="visibility: hidden; width: 1px; height: 1px">
            <div class="box-body">
                <input type="hidden" name="class_no" id="class_no" value="<?php echo $classInfo->id; ?>" style="visibility: hidden; width: 1px; height: 1px">
                <input type="hidden" name="imagepath" id="imagePath" style="visibility: hidden; width: 1px; height: 1px">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.name');?></label>
                            <input type="email" class="form-control" value="<?php echo $classInfo->name; ?>" id="class_name" name="class_name" placeholder="<?php echo trans('web.name');?>">
                        </div>
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.spot');?></label>
                            <input type="email" class="form-control" id="class_value" onkeypress='return event.charCode >= 48 && event.charCode <= 57' value="<?php echo $classInfo->value; ?>" name="class_value" placeholder="<?php echo trans('web.spot');?>">
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
                                    <input type="text" class="form-control pull-right" value="<?php echo $classInfo->date; ?>" name="class_date" id="reservation">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label><?php echo trans('web.startTime');?></label>
                                    <?php
                                    $stimeArray = explode(":", $classInfo->starthour);
                                    $stime = "";
                                    if ($stimeArray[0] > 12)
                                        $stime = ($stimeArray[0] - 12) . ":" . $stimeArray[1] . " PM";
                                    else
                                        $stime = ($stimeArray[0]) . ":" . $stimeArray[1] . " AM";
                                    ?>
                                    <div class="input-group">
                                        <input type="text" name="class_starttime" value="<?php echo $stime; ?>" id="class_starttime" class="form-control timepicker">

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
                                        <?php
                                        $etimeArray = explode(":", $classInfo->endhour);
                                        $etime = "";
                                        if ($etimeArray[0] > 12)
                                            $etime = ($etimeArray[0] - 12) . ":" . $etimeArray[1] . " PM";
                                        else
                                            $etime = ($etimeArray[0]) . ":" . $etimeArray[1] . " AM";
                                    ?>
                                    <div class="input-group">
                                        <input type="text" name="class_endtime" value="<?php echo $etime;?>" id="class_endtime" class="form-control timepicker" onchange="changeEndTime('class_starttime','class_endtime');">

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
                                    if ($categoryInfo->id == $classInfo->category) {
                                        ?>
                                        <option selected value="<?php echo $categoryInfo->id; ?>"><?php echo $categoryInfo->category; ?></option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="<?php echo $categoryInfo->id; ?>"><?php echo $categoryInfo->category; ?></option>
                                        <?php
                                    }
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
                            <input type="email" class="form-control" id="class_description" value="<?php echo $classInfo->description;?>" placeholder="<?php echo trans('web.description');?>" name="class_description">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.gyms');?></label>
                            <select class="form-control" name="class_gym">
                                <?php
                                for ($i = 0; $i < count($gymInfos); $i++) {
                                    $gymInfo = $gymInfos[$i];
                                    if ($gymInfo->id == $classInfo->gym) {
                                        ?>
                                        <option selected value="<?php echo $gymInfo->id; ?>"><?php echo $gymInfo->name; ?></option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="<?php echo $gymInfo->id; ?>"><?php echo $gymInfo->name; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.recurring');?></label>
                            <select class="form-control" name="class_recurring">
                                <?php
                                if ($classInfo->recurring == 0)
                                    echo "<option value='0' selected>".trans('web.none')."</option>";
                                else
                                    echo "<option value='0' >".trans('web.none')."</option>";
                                if ($classInfo->recurring == 1)
                                    echo "<option value='1' selected>".trans('web.daily')."</option>";
                                else
                                    echo "<option value='1' >".trans('web.daily')."</option>";
                                if ($classInfo->recurring == 2)
                                    echo "<option value='2' selected>".trans('web.weekly')."</option>";
                                else
                                    echo "<option value='2' >".trans('web.weekly')."</option>";
                                if ($classInfo->recurring == 3)
                                    echo "<option value='3' selected>".trans('web.monthly')."</option>";
                                else
                                    echo "<option value='3' >".trans('web.monthly')."</option>";
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
        </form>
        <div class="box-footer">
            <button class="btn btn-primary" onclick="updateClass()"><?php echo trans('web.update');?></button>
            <a href="/company/classes"><button class="btn btn-primary"><?php echo trans('web.cancel');?></button></a>
        </div>
        <!-- /.box-body -->
        <table id="example1" class="table table-bordered table-striped" >
            <thead>
                <tr>
                    <th><?php echo trans('web.no');?></th>
                    <th><?php echo trans('web.visitor');?></th>
                    <th><?php echo trans('web.bookDate');?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                //var_dump($classInfo->book);
                for ($i = 0; $i < count($classInfo->book); $i++) {
                    $bookInfo = $classInfo->book[$i];
                    ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $bookInfo->consumer->name; ?></td>
                        <td><?php echo $bookInfo->date; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
