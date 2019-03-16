<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.users'); ?></h3>
    </div>
    <!-- /.box-header -->
    <div class="row" style="margin:10px;">      
        <div class="col-md-2">
            <a href='/admin/viewCreateUser'><button type="button" class ="btn btn-block btn-success"><?php echo trans('web.createUser'); ?></button></a>
        </div>
    </div>  
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped" >
            <thead>
                <tr>
                    <th><?php echo trans('web.no'); ?></th>                    
                    <th><?php echo trans('web.name'); ?></th>                   
                    <th><?php echo trans('web.email'); ?></th>                   
                    <th><?php echo trans('web.phone'); ?></th>
                    <th><?php echo trans('web.registerDate'); ?></th>
                    <th><?php echo trans('web.address'); ?></th>
                    <th><?php echo trans('web.plan'); ?></th>
                    <th><?php echo trans('web.credit'); ?></th>
                    <th><?php echo trans('web.invoice'); ?></th>
                    <th><?php echo trans('web.action'); ?></th>                    
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < count($users); $i++) {
                    $user = $users[$i];
                    ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $user->name; ?></td>
                        <td><?php echo $user->email; ?></td>
                        <td><?php echo $user->phone; ?></td>
                        <td><?php echo $user->registerdate; ?></td>
                        <td><?php echo $user->address; ?></td>
                        <td>
                            <?php
                            for ($j = 0; $j < count($plans); $j++) {
                                if ($plans[$j]->id == $user->plan)
                                    echo $plans[$j]->plan;
                            }
                            ?>
                        </td>
                        <td>
                            <?php echo $user->credit; ?>
                        </td>
                        <td>
                            <?php
                            $now = new \DateTime();
                            $now->setTimezone(new \DateTimeZone('Europe/Helsinki'));
                            $currentDate = $now->format('Y-m-d H:i:m');
                            if ($user->invoice_end < $currentDate)
                                echo trans('web.none');
                            else
                                echo trans('web.invoiced');
                            ?>
                        </td>
                        <td>
                            <a href='/admin/actionEditUser/<?php
                            echo $user->id;
                            ;
                            ?>'><?php echo trans('web.edit'); ?></a>&nbsp;&nbsp;&nbsp
                            <a href='/admin/viewInvoice/<?php
                            echo $user->id;
                            ;
                            ?>'><?php echo trans('web.setInvoice'); ?></a>
                        </td>
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