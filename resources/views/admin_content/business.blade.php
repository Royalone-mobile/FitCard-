<script>
function generatePassword() {
    var length = 12,
            charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
            retVal = "";
    for (var i = 0, n = charset.length; i < length; ++i) {
        retVal += charset.charAt(Math.floor(Math.random() * n));
    }
    var passwordElement = document.getElementById("userPassword");
    passwordElement.value = retVal;
    return retVal;
}
function createBusiness()
{
  var nameElement = document.getElementById('userName');
  var emailElement = document.getElementById('userEmail');
  var passwordElement = document.getElementById('userPassword');

  if (nameElement.value == '' || emailElement.value =='' || passwordElement.value == '')
  {
    alert('Please Fill Input');
    return;
  }
  else if (emailElement.value.indexOf("@") < 0)
  {
      alert("Please input correct Email address.");
      return;
  }
  var formElement = document.getElementById("profileForm");
  formElement.action = "/admin/actionCreateBusiness";
  formElement.submit();
  return;
}
</script>
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.businessUser');?></h3>
    </div>
    <!-- /.box-header -->

    <div class="box-body">
      <div class="row" style="margin-bottom:10px;">
        <form name="form_logo" id="profileForm" method="post" action="index.php?c=main&m=uploadLogo">
           <input type="text" name="_token" id="token" style="visibility: hidden; width: 1px; height: 1px">
           <input type="file" accept=".csv" name="uploadLogo" id="upload" style="visibility: hidden; width: 1px; height: 1px" multiple onchange="upload_file()">
           <!-- SIDEBAR USERPIC -->

               <div class="col-md-3">
                   <div class="form-group">
                       <label><?php echo trans('web.name'); ?></label>
                       <input type="text" class="form-control pull-right" name="userName" id="userName">
                   </div>
               </div>
               <div class="col-md-3">
                   <div class="form-group">
                       <label><?php echo trans('web.email'); ?></label>
                       <input type="text" class="form-control pull-right" name="userEmail" id="userEmail">

                   </div>
               </div>
               <div class="col-md-3">
                   <div class="form-group">
                       <label><?php echo trans('web.password'); ?><a href="#" onclick="generatePassword()">(<?php echo trans('web.generate');?>)</a></label>
                       <input type="text" class="form-control pull-right" name="userPassword" id="userPassword">

                   </div>
               </div>
          </form>
          <div class="col-md-2" >
              <button type="button" class ="btn btn-block btn-success" onclick="createBusiness()"><?php echo trans('web.createBusinessUser');?></button>
          </div>
      </div>
        <table id="example1" class="table table-bordered table-striped" >
            <thead>
                <tr>
                    <th><?php echo trans('web.no');?></th>
                    <th><?php echo trans('web.name');?></th>
                    <th><?php echo trans('web.email');?></th>
                    <th><?php echo trans('web.acton');?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $k = 0;
                for ($i = 0; $i < count($business); $i++) {
                    $businessInfo = $business[$i];
                    ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $businessInfo->name; ?></td>
                        <td><?php echo $businessInfo->email; ?></td>
                        <td>
                            <a href='/admin/actionDeleteBusiness/<?php
                            echo $businessInfo->id;
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
