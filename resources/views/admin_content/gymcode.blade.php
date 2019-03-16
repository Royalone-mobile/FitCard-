<script>
var myApp;
myApp = myApp || (function() {
        var pleaseWaitDiv = $('<div class="modal hide" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false"><div class="modal-header"><h1>Processing...</h1></div><div class="modal-body"><div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div></div></div>');
        return {
            showPleaseWait: function() {
                pleaseWaitDiv.modal();
            },
            hidePleaseWait: function() {
                pleaseWaitDiv.modal('hide');
            },
        };
    })();
function selectGym()
{

}
function upload_file()
  {
      waitingDialog.show('Processing File');
      var fileElement = document.getElementById("form_logo1");
      var formData = new FormData(fileElement);
      $.ajax({
          type: 'POST',
          data: formData,
          url: '/admin/ajaxAddGymCode',
          contentType: false,
          processData: false,
          success: function(data)
          {
              waitingDialog.hide();
              location.href = "/admin/gymCode";
          }
      });
  }
</script>
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.gymCode');?></h3>
    </div>
    <!-- /.box-header -->

    <div class="box-body">
      <div class="row" style="margin-bottom:10px;">
        <form name="form_logo" id="form_logo1" method="post" action="index.php?c=main&m=uploadLogo">
           <input type="text" name="_token" id="token" style="visibility: hidden; width: 1px; height: 1px">
           <input type="file" accept=".csv" name="uploadLogo" id="upload" style="visibility: hidden; width: 1px; height: 1px" multiple onchange="upload_file()">
           <!-- SIDEBAR USERPIC -->

          <div class="col-md-2"  >
              <select class="form-control" name="gymId" onchange="selectGym()">
                <?php
                for ($i = 0; $i < count($gymInfos); $i++) {
                    $gymInfo = $gymInfos[$i];
                    ?>
                    <option value='<?php echo $gymInfo->id;?>'><?php echo $gymInfo->name;?></option>
                    <?php
                }
                ?>
              </select>
          </div>
          </form>
          <div class="col-md-2" >
              <button type="button" class ="btn btn-block btn-success" onclick="document.getElementById('upload').click();
                     return false">Import Code List(CSV)</button>
          </div>
      </div>
        <table id="example1" class="table table-bordered table-striped" >
            <thead>
                <tr>
                    <th><?php echo trans('web.no');?></th>
                    <th><?php echo trans('web.name');?></th>
                    <th><?php echo trans('web.code');?></th>
                    <th><?php echo trans('web.use');?></th>
                    <th><?php echo trans('web.acton');?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $k = 0;
                for ($i = 0; $i < count($gymInfos); $i++) {
                    $gymInfo = $gymInfos[$i];
                    for ($j = 0; $j < count($gymInfo->gymCode); $j++) {
                    ?>
                    <tr>
                        <td><?php echo $k + 1; ?></td>
                        <td><?php echo $gymInfo->name; ?></td>
                        <td><?php echo $gymInfo->gymCode[$j]->code; ?></td>
                        <td>
                          <?php
                            if ($gymInfo->gymCode[$j]->use == 1)
                            {
                              echo "Used";
                            }
                            else echo "Unused";
                          ?>
                        </td>
                        <td>
                            <a href='/admin/actionDeleteCode/<?php
                            echo $gymInfo->gymCode[$j]->id;
                            ;
                            ?>'><?php echo trans('web.delete');?></a>&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <?php
                    $k++;
                    }
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
