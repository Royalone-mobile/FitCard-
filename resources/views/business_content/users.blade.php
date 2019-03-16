<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.users'); ?></h3>
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
                    <th><?php echo trans('web.credit'); ?></th>                    
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < count($users); $i++) {
                    $user = $users[$i];
                    ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><a href='/business/profile/<?php echo $user->id;?>'><?php echo $user->name; ?></a></td>
                        <td><?php echo $user->email; ?></td>
                        <td><?php echo $user->phone; ?></td>
                        <td><?php echo $user->registerdate; ?></td>
                        <td><?php echo $user->address; ?></td>
                        <td>
                            <?php echo $user->credit; ?>
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
