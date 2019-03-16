<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.reviewsList'); ?></h3>
    </div>
    <!-- /.box-header -->

    <div class="box-body">

        <table id="example1" class="table table-bordered table-striped" >
            <thead>
                <tr>
                    <th><?php echo trans('web.no'); ?></th>                    
                    <th><?php echo trans('web.gym'); ?></th>                    
                    <th><?php echo trans('web.class'); ?></th>
                    <th><?php echo trans('web.date'); ?></th>
                    <th><?php echo trans('web.reviewContent'); ?></th>
                    <th><?php echo trans('web.rating'); ?></th>                    
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < count($reviews); $i++) {
                    $review = $reviews[$i];
                    if ($review->gym == null)continue;                    
                    ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $review->consumer->name; ?></td>
                        <td><?php echo $review->gym->name; ?></td>
                        <td>
                            <?php 
                                if ($review->gym->classes != null && count($review->gym->classes) > 0)
                                    echo $review->gym->classes[0]->name; ?>
                            </td>
                        <td><?php echo date("d/m/Y", strtotime($review->date)); ?></td>
                        <td><?php echo $review->gym->description; ?></td>
                        <td><?php echo $review->star; ?></td>
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
