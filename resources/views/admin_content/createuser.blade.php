<meta name="csrf-token" content="{{ csrf_token() }}" />


<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    
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
    
    function generateEmail() {
        var length = 8,
                charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
                retVal = "";
        for (var i = 0, n = charset.length; i < length; ++i) {
            retVal += charset.charAt(Math.floor(Math.random() * n));
        }
        var passwordElement = document.getElementById("userEmail");
        passwordElement.value = retVal + "@fitcard.com";
        return retVal;
    }
    
    
    function createClass()
    {
        var userName = document.getElementById("userName");
        var userEmail = document.getElementById("userEmail");
        var userPassword = document.getElementById("userPassword");
        
        if (userName.value == "" || userEmail.value=="" || userPassword.value=="")
        {
            alert('Please fill input');
            return;
        }
        else if (userEmail.value.indexOf("@") < 0)
        {
            alert("Please input correct Email address.");
            return;
        }
        else if (userPassword.value.length < 6)
        {
            alert("Password Length must be over 6 characters");
            return;
        } 
        var formElement = document.getElementById("profileForm");
        formElement.action = "/admin/actionCreateUser";
        formElement.submit();
        return;
    }
</script>
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.createUser'); ?></h3>
    </div>    
    <div class="box box-primary">
        <form role="form" method="post" id="profileForm">
            <input type="text" name="_token" id="token" style="visibility: hidden; width: 1px; height: 1px">
            <div class="box-body">                
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo trans('web.name'); ?></label>
                                <input type="text" class="form-control pull-right" name="userName" id="userName">                                
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo trans('web.email'); ?><a href="#" onclick="generateEmail()">(<?php echo trans('web.generate');?>)</a></label>
                                <input type="text" class="form-control pull-right" name="userEmail" id="userEmail">

                            </div>
                        </div>                                                                                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo trans('web.password'); ?><a href="#" onclick="generatePassword()">(<?php echo trans('web.generate');?>)</a></label>
                                <input type="text" class="form-control pull-right" name="userPassword" id="userPassword">

                            </div>
                        </div>   
                    </div>    
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo trans('web.membership'); ?></label>
                                <select class="form-control" name="userPlan">
                                    <?php
                                    for ($i = 0; $i < count($plans); $i++) {
                                        ?>
                                        <option value="<?php echo $plans[$i]->id; ?>"><?php echo $plans[$i]->plan; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>                                
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo trans('web.startDate'); ?></label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>                                    
                                    <input type="text" class="form-control pull-right" name="startDate" id="reservation">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo trans('web.endDate'); ?></label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>                                    
                                    <input type="text" class="form-control pull-right" name="endDate" id="reservation1">
                                </div>
                            </div>
                        </div>                                                                                        
                    </div>                    
                </div>   
            </div>
        </form>
        <div class="box-footer">
            <button class="btn btn-primary" style="width:100px;" onclick="createClass()"><?php echo trans('web.create'); ?></button>
        </div>
        <!-- /.box-body -->
    </div>
</div>

