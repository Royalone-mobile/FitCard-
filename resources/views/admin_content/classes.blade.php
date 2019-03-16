<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.classes');?></h3>
    </div>
    <!-- /.box-header -->

    <div class="box-body">        
        <div class="row" style="margin-bottom:10px;">      
            <div class="col-md-2" >
                <a href='/admin/createclass'><button type="button" class ="btn btn-block btn-success"><?php echo trans('web.createClass');?></button></a>
            </div>
        </div>                         

        <table id="example1" class="table table-bordered table-striped" >
            <thead>
                <tr>
                    <th><?php echo trans('web.no');?></th>                    
                    <th><?php echo trans('web.name');?></th>
                    <th><?php echo trans('web.date');?></th>                    
                    <th><?php echo trans('web.gymName');?></th>
                    <th><?php echo trans('web.hours');?></th>
                    <th><?php echo trans('web.action');?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < count($classInfos); $i++) {
                    $classInfo = $classInfos[$i];
                    ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $classInfo->name; ?></td>
                        <td><?php echo date("d/m/Y",strtotime($classInfo->date));  ?></td>
                        <td>
                            <?php
                            for ($j=0;$j < count($gymInfos);$j++)
                            {
                                if ($gymInfos[$j]->id == $classInfo->gym)
                                {
                                    echo $gymInfos[$j]->name;
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $classInfo->starthour . "-" . $classInfo->endhour;
                            ?>
                        </td>
                        <td>
                            <a href='/admin/viewEditClass/<?php echo $classInfo->id; ?>' >
                                <?php echo trans('web.edit');?></a>&nbsp;&nbsp;&nbsp;
                            <a href='/admin/actionDeleteClass/<?php
                            echo $classInfo->id;
                            ;
                            ?>'><?php echo trans('web.delete');?></a>&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <!--/.box-body -->
</div>
<div class = "modal hide" id = "pleaseWaitDialog" data-backdrop = "static" data-keyboard = "false">
    <div class = "modal-header">
        <h1>Processing...</h1>
    </div>
    <div class = "modal-body">
        <div class = "progress progress-striped active">
            <div class = "bar" style = "width: 100%;"></div>
        </div>
    </div>
</div>
