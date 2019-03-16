<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.gyms');?></h3>
    </div>
    <!-- /.box-header -->

    <div class="box-body">
        <div class="row" style="margin-bottom:10px;">
            <div class="col-md-2" >
                <a href='/admin/creategym'><button type="button" class ="btn btn-block btn-success"><?php echo trans('web.createGymAdmin');?></button></a>
            </div>
        </div>

        <table id="example1" class="table table-bordered table-striped" >
            <thead>
                <tr>
                    <th><?php echo trans('web.no');?></th>
                    <th><?php echo trans('web.name');?></th>
                    <th><?php echo trans('web.city');?></th>
                    <th><?php echo trans('web.joinDate');?></th>
                    <!--<th>Bookings</th>
                    <!--<th>Total Credits</th>-->
                    <!--<th>Usability</th>-->
                    <!--<th>Current Credits</th>-->
                    <th><?php echo trans('web.acton');?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < count($gymInfos); $i++) {
                    $gymInfo = $gymInfos[$i];
                    ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $gymInfo->name; ?></td>
                        <td><?php echo $gymInfo->city; ?></td>
                        <td><?php echo date("d/m/Y",strtotime($gymInfo->joindate)); ?></td>
                        <td>
                            <a href='/admin/viewEditGym/<?php echo $gymInfo->id; ?>' >
                                <?php echo trans('web.edit');?></a>&nbsp;&nbsp;&nbsp;
                            <a href='/admin/actionDeleteGym/<?php
                            echo $gymInfo->id;
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
