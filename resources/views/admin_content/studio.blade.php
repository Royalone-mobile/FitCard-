<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.studio');?></h3>
    </div>
    <!-- /.box-header -->

    <div class="box-body">
        <div class="row" style="margin-bottom:10px;">

        </div>
        <form role="form" method="post" id="profileForm" action='/admin/actionCreateStudio'>
            <input type="text" name="_token" id="token" value="{{ csrf_token() }}" style="visibility: hidden; width: 1px; height: 1px">
            <div class="box-body">
                <input type="hidden" name="imagepath" id="imagePath" style="visibility: hidden; width: 1px; height: 1px">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="studio_name" name="studio_name" placeholder="Enter Studio">
                        </div>
                        <div class='col-md-2'>
                            <input type="submit" class ="btn btn-block btn-success" value='<?php echo trans('web.createButton');?>'>
                        </div>

                    </div>
                </div>

            </div>
        </form>
        <table class="table table-bordered table-striped" >
            <thead>
                <tr>
                    <th><?php echo trans('web.no');?></th>
                    <th><?php echo trans('web.name');?></th>
                    <th><?php echo trans('web.action');?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < count($data); $i++) {
                    ?>
                    <tr>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $data[$i]->name; ?></td>
                        <td>
                            <a href='/admin/actionDeleteStudio/<?php
                            echo $data[$i]->id;
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
