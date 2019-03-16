
<!-- /.page header -->
<div class="tp-breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <ol class="breadcrumb">
                    <li><a href="#"><?php echo trans('web.home');?></a></li>
                    <li><a href="#" class="active"><?php echo trans('web.mybooks');?></a></li>                    
                </ol>
            </div>
        </div>
    </div>
</div>
<div id="main-container" class="main-container"><!-- main container -->
    <div class="st-tabs"><!-- shortcode -->
        <div class="container">
            <div class="row">
                <div class="col-md-12"> 
                    <!-- Nav tabs -->
                    <h2><a href="#" class="title"><?php echo trans('web.currentCredits');?> <?php echo $userInfo->credit; ?> <?php echo trans('web.credits');?> </a></h2>

                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><?php echo trans('web.gyms');?> </a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><?php echo trans('web.classes');?> </a></li>            
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <div class="row">
                                <div class="col-md-12 view-cart"><!-- view cart -->
                                    <label href="" style="float:right;" id="upcomingDate"></label>
                                    <table class="shop_table">
                                        <thead>
                                            <tr>
                                                <th class="product-remove" style="text-align:center;"><?php echo trans('web.bookDate');?> </th>
                                                <th class="product-thumbnail" style="text-align:center;"><?php echo trans('web.consumerTime');?> </th>
                                                <th class="product-name" style="text-align:center;"><?php echo trans('web.consumerValid');?> </th>
                                                <th class="product-price" style="text-align:center;"><?php echo trans('web.gymName');?> </th>
                                                <th class="product-quantity" style="text-align:center;"><?php echo trans('web.address');?> </th>
                                                <th class="product-subtotal" style="text-align:center;"><?php echo trans('web.city');?> </th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            for ($i = 0; $i < count($gymInfos); $i++) {
                                                $gymInfo = $gymInfos[$i];
                                                ?>
                                                <tr class="cart_item">
                                                    <td class="product-remove" style="text-align:center;"><?php echo date("d/m", strtotime($gymInfo->date)); ?></td>
                                                    <td class="product-thumbnail" style="text-align:center;"><?php echo date("H:i", strtotime($gymInfo->date));?> </td>
                                                    <td class="product-name" style="text-align:center;">
                                                        <?php                                                             
                                                            $time = strtotime($gymInfo->date) + 60 * 3 * 60;                                                            
                                                            echo date("H:i", $time);
                                                        ?>
                                                    </td>
                                                    <td class="product-price" style="text-align:center;"><?php echo $gymInfo->gym->name;?></td>
                                                    <td class="product-quantity" style="text-align:center;"><?php echo $gymInfo->gym->address;?></td>
                                                    <td class="product-subtotal" style="text-align:center;"><?php echo $gymInfo->gym->city;?></td>
                                                </tr>  
                                                <?php
                                            }
                                            ?>
                                        </tbody>                                                                    
                                    </table>
                                    <!-- shop table end --> 
                                </div>
                                <!-- view cart end --> 
                            </div>                                 
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile">
                            <div class="row">
                                <div class="col-md-12 view-cart"><!-- view cart -->
                                    <label href="" style="float:right;" id="upcomingDate"></label>
                                    <div class="row" style="margin-bottom:10px;">
                                        <div class="col-md-4" >
                                            <input id='showua' type="checkbox" onchange="showUnavailable()"/>
                                            <label><?php echo trans('web.showUnavailable');?></label>
                                        </div>
                                    </div>
                                    <table class="shop_table">
                                        <thead>
                                            <tr>
                                                <th class="product-remove" style="text-align:center;"><?php echo trans('web.date');?> </th>
                                                <th class="product-thumbnail" style="text-align:center;"><?php echo trans('web.startTime');?> </th>
                                                <th class="product-name" style="text-align:center;"><?php echo trans('web.gymName');?> </th>
                                                <th class="product-price" style="text-align:center;">Tunnin nimi</th>
                                                <th class="product-quantity" style="text-align:center;"><?php echo trans('web.className');?> </th>
                                                <th class="product-subtotal" style="text-align:center;"><?php echo trans('web.address');?> </th>
                                                <th class="product-subtotal" style="text-align:center;"><?php echo trans('web.city');?> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            for ($i = 0;$i < count($classInfos) - 1;$i++)
                                            {
                                                $classObj1 = $classInfos[$i];
                                                for ($j = $i + 1;$j < count($classInfos);$j++)
                                                {
                                                    $classObj2 = $classInfos[$j];
                                                    if ($classObj1->classModel->date > $classObj2->classModel->date)
                                                    {
                                                        $tempObj = $classInfos[$i];
                                                        $classInfos[$i] = $classInfos[$j];
                                                        $classInfos[$j] = $tempObj;
                                                    }
                                                }
                                            }
                                            for ($i = 0; $i < count($classInfos); $i++) {
                                                $classInfo = $classInfos[$i];
                                                $var = $classInfo->classModel->date." ".$classInfo->classModel->starthour;
                                                if((time()) < (strtotime($var)-(60*60*24)))
                                                {
                                                    echo "<tr class='available' >";
                                                }
                                                else
                                                {
                                                    echo "<tr class='uavailable' >";
                                                }
                                                ?>
                                                    <td class="product-remove" style="text-align:center;"><?php echo date("d/m/Y", strtotime($classInfo->classModel->date)); ?></td>
                                                    <td class="product-thumbnail" style="text-align:center;"><?php echo $classInfo->classModel->starthour . "~" . $classInfo->classModel->endhour; ?></td>
                                                    <td class="product-name" style="text-align:center;"><?php echo $classInfo->classModel->gymInfo->name; ?></td>
                                                    <td class="product-price" style="text-align:center;"><?php echo $classInfo->classModel->name; ?></td>
                                                    <td class="product-quantity" style="text-align:center;"><?php echo $classInfo->classModel->gymInfo->address; ?></td>
                                                    <td class="product-subtotal" style="text-align:center;"><?php echo $classInfo->classModel->gymInfo->city; ?></td>
                                                    <td class="product-subtotal" style="text-align:center;">
                                                      <?php
                                                        if((time()) < (strtotime($var)-(60*60*24)))
                                                        {
                                                          ?>
                                                            <a href="/consumer/actionCancelBook/<?php echo $classInfo->id; ?>" class="btn tp-btn-default tp-btn-lg btn-block"><?php echo trans('web.cancel');?> </a>
                                                          <?php
                                                        }
                                                       ?>
                                                    </td>
                                                </tr>  
                                                <?php
                                            }
                                            ?>
                                        </tbody>                                                                    
                                    </table>
                                    <!-- shop table end --> 
                                </div>
                                <!-- view cart end --> 
                            </div>                            
                        </div>            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function showUnavailable()
    {
        var element = document.getElementById('showua');
        var elements = document.getElementsByClassName('uavailable');
        if (element.checked)
        {
            for (j = 0; j < elements.length; j++)
            {
                elements[j].style.display = "";
            }
        }
        else
        {
            for (j = 0; j < elements.length; j++)
            {
                elements[j].style.display = "none";
            }
        }
    }
</script>
<script>
    showUnavailable();
</script>
