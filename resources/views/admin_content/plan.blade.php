<meta name="csrf-token" content="{{ csrf_token() }}" />
<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    function createClass()
    {
        var formElement = document.getElementById("profileForm");

        
        formElement.action = "/admin/actionPlanUpdate";
        formElement.submit();
        return;
    }
</script>
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.plan');?></h3>
    </div>    
    <div class="box box-primary">        
        <form role="form" method="post" id="profileForm">
            <input type="text" name="_token" id="token" style="visibility: hidden; width: 1px; height: 1px" value="{{ csrf_token() }}">
            <div class="box-body">
                <input type="hidden" name="imagepath" id="imagePath" style="visibility: hidden; width: 1px; height: 1px">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.name');?></label>
                            <input type="email" class="form-control" id="class_name" name="planName1" placeholder="<?php echo trans('web.name');?>" value="<?php echo $planInfos[0]->plan;?>">
                        </div>
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.value');?></label>
                            <input type="email" class="form-control" id="class_value" name="planPrice1" placeholder="<?php echo trans('web.value');?>" value="<?php echo $planInfos[0]->price;?>">
                        </div>                                                
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.credit');?></label>
                            <input type="email" class="form-control" id="class_value" name="planCredit1" placeholder="<?php echo trans('web.credit');?>" value="<?php echo $planInfos[0]->credit;?>">
                        </div>                                                
                    </div>  
                </div>                 
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.name');?></label>
                            <input type="email" class="form-control" id="class_name" name="planName2" placeholder="<?php echo trans('web.name');?>" value="<?php echo $planInfos[1]->plan;?>">
                        </div>
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.value');?></label>
                            <input type="email" class="form-control" id="class_value" name="planPrice2" placeholder="<?php echo trans('web.value');?>" value="<?php echo $planInfos[1]->price;?>">
                        </div>                                                
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.credit');?></label>
                            <input type="email" class="form-control" id="class_value" name="planCredit2" placeholder="<?php echo trans('web.credit');?>" value="<?php echo $planInfos[1]->credit;?>">
                        </div>                                                
                    </div>  
                </div>       
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.name');?></label>
                            <input type="email" class="form-control" id="class_name" name="planName3" placeholder="<?php echo trans('web.name');?>" value="<?php echo $planInfos[2]->plan;?>">
                        </div>
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.value');?></label>
                            <input type="email" class="form-control" id="class_value" name="planPrice3" placeholder="<?php echo trans('web.value');?>" value="<?php echo $planInfos[2]->price;?>">
                        </div>                                                
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.credit');?></label>
                            <input type="email" class="form-control" id="class_value" name="planCredit3" placeholder="<?php echo trans('web.credit');?>" value="<?php echo $planInfos[2]->credit;?>">
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

