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
        var passwordElement = document.getElementById("company_password");
        passwordElement.value = retVal;
        return retVal;
    }
    function updateProfile()
    {

        var nameElement = document.getElementById("company_name");
        var ownerElement = document.getElementById("company_owner");
        var accountElement = document.getElementById("company_account");
        var passwordElement = document.getElementById("company_password");
        var locationElement = document.getElementById("company_location");


        var formElement = document.getElementById("profileForm");

        if ((nameElement.value == "") || (ownerElement.value == "")
                || (accountElement.value == "") || (passwordElement.value == "")
                || (locationElement.value == ""))
        {
            alert("Please fill Input");
            return;
        }
        formElement.action = "/company/actionEditProfile";
        formElement.submit();
        return;
    }   
    function uploadLogo()
    {
        var fileElement = document.getElementById("form_logo");
        var preview = document.getElementById('imgBusinessLogo'); //selects the query named img
        var formData = new FormData(fileElement);
        $.ajax({
            type: 'POST',
            data: formData,
            url: '/admin/ajaxUploadCompanyLogo',
            contentType: false,
            processData: false,
            success: function (data)
            {
                obj = JSON.parse(data);
                preview.src = <?php echo "\"" . url('/')  . "/" . "\""; ?> + obj.path;
                var imgPath = document.getElementById("imagePath");
                imgPath.value = obj.path;
            }
        });
    }

    function previewFile() {
        var preview = document.getElementById('imgBusinessLogo'); //selects the query named img
        var file = document.querySelector('input[type=file]').files[0]; //sames as here
        var reader = new FileReader();
        reader.onloadend = function () {
            uploadLogo();
            //preview.src = reader.result;
        }
        if (file) {
            reader.readAsDataURL(file); //reads the data as a URL
        } else {
            preview.src = "";
        }
    }
</script>
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.editCompany');?></h3>
    </div>    
    <div class="box box-primary">
        <form name="form_logo" style="margin-left:10px;" id="form_logo" method="post" action="/admin/ajaxUploadCompanyLogo">
            <input type="text" name="_token" id="token" value="{{ csrf_token() }}" style="visibility: hidden; width: 1px; height: 1px">
            <input type="file" accept="image/*" name="uploadLogo" id="upload" style="visibility: hidden; width: 1px; height: 1px" multiple onchange="previewFile()">
            <!-- SIDEBAR USERPIC -->
            <div class="profile-userpic"> <img src="<?php echo url('/')  . "/" . $companyInfo->image; ?>" style="height:159px;width:350px;"id="imgBusinessLogo" onclick="document.getElementById('upload').click();
                    return false" class="img-responsive " alt=""> </div>
            <div class="profile-usertitle">
                <div class="profile-usertitle-name">

                </div>                            
            </div>                                 
        </form>
        <form role="form" method="post" id="profileForm">
            <input type="hidden" name="company_image" id="imagePath" value="<?php echo $companyInfo->image; ?>" style="visibility: hidden; width: 1px; height: 1px">
            <input type="text" name="_token" id="token" style="visibility: hidden; width: 1px; height: 1px">
            <div class="box-body">
                <input type="hidden" name="cmopany_no" value="<?php echo $companyInfo->no;?>" id="cmopany_no" style="visibility: hidden; width: 1px; height: 1px">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.name');?></label>
                            <input type="email" class="form-control" value="<?php echo $companyInfo->name;?>" id="company_name" name="company_name" placeholder="<?php echo trans('web.name');?>">
                        </div>
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.owner');?></label>
                            <input type="email" class="form-control" id="company_owner" value="<?php echo $companyInfo->owner;?>" name="company_owner" placeholder="<?php echo trans('web.owner');?>">
                        </div>                                       
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.email');?></label>
                            <input type="email" class="form-control"  value="<?php echo $companyInfo->email; ?>" id="company_email" name="company_email" placeholder="<?php echo trans('web.email');?>">
                        </div> 
                    </div>  
                </div>                 
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.account');?></label>
                            <input type="email" class="form-control" id="company_account" value="<?php echo $companyInfo->account;?>" disabled name="company_account" placeholder="<?php echo trans('web.account');?>">
                        </div>
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.password');?>  <a href="#" onclick="generatePassword()">(<?php echo trans('web.generate');?>)</a></label>
                            <input type="email" class="form-control" id="company_password" value="<?php echo $companyInfo->password;?>" name="company_password" placeholder="<?php echo trans('web.password');?>">                            
                        </div>                           
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.location');?></label>
                            <input type="email" class="form-control" id="company_location" value="<?php echo $companyInfo->location;?>" name="company_location" placeholder="<?php echo trans('web.location');?>">
                        </div>   
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.phone');?></label>
                            <input type="email" class="form-control" id="company_phone"  value="<?php echo $companyInfo->phone;?>" name="company_phone" placeholder="<?php echo trans('web.phone');?>">
                        </div> 
                    </div>                    
                </div>  
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.city');?></label>
                            <input type="email" class="form-control" value="<?php echo $companyInfo->city;?>" id="company_city" name="company_city" placeholder="<?php echo trans('web.city');?>">
                        </div>
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.zipCode');?> </label>
                            <input type="email" class="form-control" value="<?php echo $companyInfo->zipcode;?>" id="company_zip" name="company_zip" placeholder="<?php echo trans('web.zipCode');?>">                            
                        </div>                           
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.latitude');?></label>
                            <input type="email" class="form-control" value="<?php echo $companyInfo->lat;?>" id="company_lat" name="company_lat" placeholder="<?php echo trans('web.latitude');?>">
                        </div>   
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.longitude');?></label>
                            <input type="email" class="form-control" value="<?php echo $companyInfo->lng;?>" id="company_lng" name="company_lng" placeholder="<?php echo trans('web.longitude');?>">
                        </div>   
                    </div>                    
                </div>   
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.bank');?></label>
                            <input type="email" class="form-control" id="company_bank" name="company_bank"  value="<?php echo $companyInfo->bank;?>" placeholder="<?php echo trans('web.bank');?>">
                        </div>
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.vatNumber');?> </label>
                            <input type="email" class="form-control" id="company_vat" name="company_vat"  value="<?php echo $companyInfo->vat;?>" placeholder="<?php echo trans('web.vatNumber');?>">                            
                        </div>                                                   
                    </div>                    
                </div> 
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1"><?php echo trans('web.description');?></label>
                            <input type="email" class="form-control" id="company_description" name="company_description" value="<?php echo $companyInfo->description; ?>" placeholder="<?php echo trans('web.description');?>">
                        </div>                                                                         
                    </div>                    
                </div> 
            </div>
            <input type="text" name="_token" id="token" style="visibility: hidden; width: 1px; height: 1px" value="{{ csrf_token() }}">
        </form>
        <div class="box-footer">
            <button class="btn btn-primary" onclick="updateProfile()"><?php echo trans('web.update');?></button>
            <a href="/company/visitors"><button class="btn btn-primary"><?php echo trans('web.cancel');?></button></a>
        </div>
        <!-- /.box-body -->
    </div>
</div>

