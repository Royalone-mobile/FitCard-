<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.couponCode');?></h3>
    </div>
    <!-- /.box-header -->

    <div class="box-body">
        <div class="row" style="margin-bottom:10px;">      

        </div>                         
        <form role="form" method="post" id="profileForm" action='/admin/actionCreateCoupon'>
            <input type="text" name="_token" id="token" value="{{ csrf_token() }}" style="visibility: hidden; width: 1px; height: 1px">
            <div class="box-body">
                <input type="hidden" name="imagepath" id="imagePath" style="visibility: hidden; width: 1px; height: 1px">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">                            
                            <input type="text" class="form-control" id="location_name" name="coupon_code" placeholder="<?php echo trans('web.amount');?>">
                        </div>
                        <div class="col-md-3">                            
                            <input type="text" class="form-control" id="location_name" name="coupon_credit" placeholder="<?php echo trans('web.credit');?>">
                        </div>
                        <div class='col-md-2'>
                            <input type="submit" class ="btn btn-block btn-success" value='<?php echo trans('web.create');?>'>
                        </div>

                    </div>                    
                </div>                   

            </div>
        </form>
        <table id="example1" class="table table-bordered table-striped" >
            <thead>
                <tr>
                    <th><?php echo trans('web.no');?></th>                    
                    <th><?php echo trans('web.code');?></th>                    
                    <th><?php echo trans('web.credit');?></th>                    
                    <th><?php echo trans('web.usedField');?></th>                    
                    <th><?php echo trans('web.action');?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < count($coupons); $i++) {
                    ?>
                    <tr>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $coupons[$i]->code; ?></td>
                        <td><?php echo $coupons[$i]->credit; ?></td>
                        <td><?php 
                            if ($coupons[$i]->use == 0)
                                echo trans('web.unused');
                            else
                                echo trans('web.used');
                                
                        ?></td>
                        <td>                           
                            <a href='/admin/actionDeleteCoupon/<?php
                            echo $coupons[$i]->id;
                            ;
                            ?>'><?php echo trans('web.delete');?></a>&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>            
        </table>
    </div>
    <!-- /.box-body -->
</div>
<div class="modal hide" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
        <h1>Processing...</h1>
    </div>
    <div class="modal-body">
        <div class="progress progress-striped active">
            <div class="bar" style="width: 100%;"></div>
        </div>
    </div>
</div>