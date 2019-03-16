<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.reviewList');?></h3>
    </div>
    <!-- /.box-header -->

    <div class="box-body">
        <form name="form_logo" id="form_logo1" method="post" action="index.php?c=main&m=uploadLogo">
            <input type="text" name="_token" id="token" style="visibility: hidden; width: 1px; height: 1px">
            <input type="file" accept=".csv" name="uploadLogo" id="upload" style="visibility: hidden; width: 1px; height: 1px" multiple onchange="upload_file()">
            <!-- SIDEBAR USERPIC -->
        </form>
        <form name="form_logo" id="form_logo2" method="post" action="index.php?c=main&m=uploadLogo">
            <input type="text" name="_token" id="token2" style="visibility: hidden; width: 1px; height: 1px">
            <input type="file" accept=".csv" name="uploadLogo" id="upload2" style="visibility: hidden; width: 1px; height: 1px" multiple onchange="upload_file2()">
            <!-- SIDEBAR USERPIC -->
        </form>

        <table class="table table-bordered table-striped" >
            <thead>
                <tr>
                    <th><?php echo trans('web.no');?></th>
                    <th><?php echo trans('web.gymName');?></th>
                    <th><?php echo trans('web.reviewContent');?></th>
                    <th><?php echo trans('web.rating');?></th>
                    <th><?php echo trans('web.date');?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < count($reviews); $i++) {
                    $review = $reviews[$i];
                    if ($review->gym == null) {
                        continue;
                    }
                    ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $review->gym->name; ?></td>
                        <td><?php echo $review->gym->description; ?></td>
                        <td><?php echo $review->star;?></td>
                        <td><?php echo date("d/m/Y", strtotime($review->date)); ?></td>
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
