<meta name="csrf-token" content="{{ csrf_token() }}" />


<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    function createClass()
    {
        var formElement = document.getElementById("profileForm");
        formElement.action = "/admin/actionSetInvoice";
        formElement.submit();
        return;
    }
</script>
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.setInvoice'); ?></h3>
    </div>    
    <div class="box box-primary">
        <form role="form" method="post" id="profileForm">
            <input type="text" name="_token" id="token" style="visibility: hidden; width: 1px; height: 1px">
            <div class="box-body">
                <input type="hidden" name="user_no" id="class_no" value="<?php echo $userInfo->id; ?>" style="visibility: hidden; width: 1px; height: 1px">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo trans('web.startDate'); ?></label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <?php
                                    $start = $userInfo->invoice_start;
                                    if ($userInfo->invoice_start == "0000-00-00") {
                                        $now = new \DateTime();
                                        $now->setTimezone(new \DateTimeZone('Europe/Helsinki'));
                                        $start = $now->format('Y-m-d');
                                    }
                                    ?>
                                    <input type="text" class="form-control pull-right" value="<?php echo $start; ?>" name="startDate" id="reservation">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo trans('web.endDate'); ?></label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <?php
                                    $end = $userInfo->invoice_end;
                                    if ($userInfo->invoice_end == "0000-00-00") {
                                        $now = new \DateTime();
                                        $now->setTimezone(new \DateTimeZone('Europe/Helsinki'));
                                        $end = $now->format('Y-m-d');
                                    }
                                    ?>
                                    <input type="text" class="form-control pull-right" value="<?php echo $end;?>" name="endDate" id="reservation1">
                                </div>
                            </div>
                        </div>   
                        <div class="col-md-3">
                          <label><?php echo trans('web.businessUser'); ?></label>
                          <select class="form-control" name="business" onchange="selectGym()">
                            <?php
                            for ($i = 0; $i < count($business); $i++) {
                                $businessInfo = $business[$i];
                                ?>
                                <option value='<?php echo $businessInfo->id;?>'><?php echo $businessInfo->name;?></option>
                                <?php
                            }
                            ?>
                          </select>
                        </div>
                    </div>                    
                </div>   
            </div>
        </form>
        <div class="box-footer">
            <button class="btn btn-primary" onclick="createClass()"><?php echo trans('web.set'); ?></button>
        </div>
        <!-- /.box-body -->
    </div>
</div>

