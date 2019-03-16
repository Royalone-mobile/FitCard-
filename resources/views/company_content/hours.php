<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.hours');?></h3>
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

        <div class="row" style="margin-bottom:10px;">
            <div class="col-md-2" >
                <button type="button" class ="btn btn-block btn-success" onclick="document.getElementById('upload').click();
                        return false"><?php echo trans('web.createHour');?></button>
            </div>
        </div>

        <table id="example1" class="table table-bordered table-striped" >
            <thead>
                <tr>
                    <th><?php echo trans('web.no');?></th>
                    <th>Service</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>

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
