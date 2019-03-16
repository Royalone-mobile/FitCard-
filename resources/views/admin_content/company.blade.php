<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.companyList');?></h3>
    </div>
    <!-- /.box-header -->

    <div class="box-body">
        <div class="row" style="margin-bottom:10px;">      
            <div class="col-md-2" >
                <a href='/admin/createcompany'><button type="button" class ="btn btn-block btn-success"><?php echo trans('web.createCompany');?></button></a>
            </div>
        </div>                         
        <table id="example1" class="table table-bordered table-striped" >
            <thead>
                <tr>
                    <th><?php echo trans('web.no');?></th>                    
                    <th><?php echo trans('web.name');?></th>
                    <th><?php echo trans('web.account');?></th>                    
                    <th><?php echo trans('web.location');?></th>
                    <th><?php echo trans('web.action');?></th>                    
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < count($companyInfos); $i++) {
                    $companyInfo = $companyInfos[$i];
                    ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $companyInfo->name; ?></td>
                        <td><?php echo $companyInfo->account; ?></td>
                        <td><?php echo $companyInfo->location; ?></td>
                        <td>
                            <a href='/admin/viewEditCompany/<?php echo $companyInfo->id; ?>' >
                                <?php echo trans('web.edit');?></a>&nbsp;&nbsp;&nbsp;
                            <a href='/admin/actionDeleteCompany/<?php
                            echo $companyInfo->id;
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