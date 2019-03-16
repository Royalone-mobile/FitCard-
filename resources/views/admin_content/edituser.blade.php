<meta name="csrf-token" content="{{ csrf_token() }}" />


<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    function updateUser()
    {
        var formElement = document.getElementById("profileForm");
        formElement.action = "/admin/actionUpdateUser";
        formElement.submit();
        return;
    }
</script>
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.editUser');?></h3>
    </div>    
    <div class="box box-primary">
        <form role="form" method="post" id="profileForm">
            <input type="text" name="_token" id="token" value="{{ csrf_token() }}" style="visibility: hidden; width: 1px; height: 1px">
            <div class="box-body">
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $userInfo->id; ?>" style="visibility: hidden; width: 1px; height: 1px">
                <input type="hidden" name="imagepath" id="imagePath" style="visibility: hidden; width: 1px; height: 1px">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.name');?></label>
                            <input type="email" class="form-control" disabled value="<?php echo $userInfo->name; ?>" id="user_name" name="user_name" placeholder="<?php echo trans('web.name');?>">
                        </div>
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.email');?></label>
                            <input type="email" class="form-control" disabled id="user_email" value="<?php echo $userInfo->email; ?>" name="user_email" placeholder="<?php echo trans('web.email');?>">
                        </div>                                                
                    </div>  
                </div>                                 
                <div class="form-group">                           
                    <div class="row">
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.phone');?></label>
                            <input type="email" class="form-control" value="<?php echo $userInfo->phone; ?>" id="user_phone" name="user_phone" placeholder="<?php echo trans('web.phone');?>">
                        </div>                                                               
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.address');?></label>
                            <input type="email" class="form-control" value="<?php echo $userInfo->address; ?>" id="user_address" name="user_address" placeholder="<?php echo trans('web.address');?>">
                        </div>  
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.plan');?></label>
                            <select class="form-control" name="user_plan">
                                <?php
                                for ($i = 0; $i < count($plans); $i++) {
                                    $planInfo = $plans[$i];
                                    if ($planInfo->id == $userInfo->plan) {
                                        ?>
                                        <option selected value="<?php echo $planInfo->id; ?>"><?php echo $planInfo->plan; ?></option>                                    
                                        <?php
                                    } else {
                                        ?>
                                        <option value="<?php echo $planInfo->id; ?>"><?php echo $planInfo->plan; ?></option>                                    
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>                           
                    </div>  
                </div>       
            </div>
        </form>
        <div class="box-footer">
            <button class="btn btn-primary" onclick="updateUser()"><?php echo trans('web.update');?></button>
            <a href="/admin/users"><button class="btn btn-primary"><?php echo trans('web.cancel');?></button></a>
        </div>
        <div class="box-body">
        <h4><?php echo trans('web.gymVisits');?></h4>
        <table id="example1" class="table table-bordered table-striped" >
            <thead>
                <tr>
                    <th><?php echo trans('web.no');?></th>                    
                    <th><?php echo trans('web.gym');?></th>
                    <th><?php echo trans('web.bookDate');?></th>                                                            
                </tr>
            </thead>
            <tbody>
                <?php
                //var_dump($classInfo->book);
                    for ($i = 0; $i < count($bookgyms); $i++) {
                        $bookInfo = $bookgyms[$i];                        
                        ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo $bookInfo->gym->name; ?></td>
                            <td><?php echo $bookInfo->date; ?></td>                        
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
        
        <h4><?php echo trans('web.classBook');?></h4>
        <table id="example1" class="table table-bordered table-striped" >
            <thead>
                <tr>
                    <th><?php echo trans('web.no');?></th>                    
                    <th><?php echo trans('web.class');?></th>
                    <th><?php echo trans('web.bookDate');?></th>                                                            
                </tr>
            </thead>
            <tbody>
                <?php
                //var_dump($classInfo->book);
                    for ($i = 0; $i < count($bookclass); $i++) {
                        $bookInfo = $bookclass[$i];                        
                        ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo $bookInfo->classModel->name; ?></td>
                            <td><?php echo $bookInfo->date; ?></td>                        
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
        
        </div>

        <!-- /.box-body -->
    </div>
</div>

