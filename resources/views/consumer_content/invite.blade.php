<script>
    function sendEmail()
    {
        var emailElement = document.getElementById("forget_email");
        var formElement = document.getElementById("forgetForm");
        if (emailElement.value == "")
            alert("Please Input Email Address");        
        formElement.action = "/consumer/actionInviteFriend";
        formElement.submit();
    }
</script>
<!-- /.page header -->
<div class="tp-breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <ol class="breadcrumb">
                    <li><a href="index.php"><?php echo trans('web.home');?></a></li>
                    <li class="active"><?php echo trans('web.inviteFriend');?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12 tp-title-center">
                <h1> <?php echo trans('web.inviteFriend');?></h1>
            </div>
        </div>
        <div class="col-md-offset-3 col-md-6 well-box">
            <form method="post" id="forgetForm">

                <!-- Text input-->
                <?php
                if ($pageName = "FORGETPASSWORDVENDOR") {
                    echo "<input id='type' name='type' value='1' type='hidden'/>";
                } else if ($pageName = "FORGETPASSWORDUSER") {
                    echo "<input id='type' name='type' value='2' type='hidden'/>";
                }
                ?>             
                <input type="text" name="_token" id="token" style="visibility: hidden; width: 1px; height: 1px" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label class="control-label" for="email"><?php echo trans('web.email');?><span class="required">*</span></label>
                    <input id="forget_email" name="forget_email" type="text" placeholder="<?php echo trans('web.email');?>" class="form-control input-md" required/>
                </div>                
                <div class="form-group">
                    <button onclick="sendEmail()" class="btn tp-btn-primary tp-btn-lg"><?php echo trans('web.submit');?></button>
                </div>
            </form>

            <!-- Nav tabs --> 

            <!-- Tab panes --> 

        </div>
    </div>
</div>