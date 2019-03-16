
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.classesCompany');?></h3>
    </div>
    <!-- /.box-header -->

    <div class="box-body">

        <div class="row" style="margin-bottom:10px;">
            <div class="col-md-2" >
                <a href='/company/creategym'><button type="button" class ="btn btn-block btn-success"><?php echo trans('web.classesCompany');?></button></a>
            </div>
        </div>

        <table class="table table-bordered table-striped" >
            <thead>
                <tr>
                    <th><?php echo trans('web.no');?></th>
                    <th><?php echo trans('web.name');?></th>
                    <th><?php echo trans('web.city');?></th>
                    <!--<th>Usability</th>                    -->
                    <th><?php echo trans('web.action');?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < count($gymInfos); $i++) {
                    $gymInfo = $gymInfos[$i];
                    ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $gymInfo->name; ?></td>
                        <td><?php echo $gymInfo->city; ?></td>
                        <td>
                            <a href='/company/viewEditGym/<?php echo $gymInfo->id; ?>' >
                                <?php echo trans('web.edit');?></a>&nbsp;&nbsp;&nbsp;
                            <a href='/company/actionDeleteGym/<?php
                            echo $gymInfo->id;
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
                <a href='/company/createclass'><button type="button" class ="btn btn-block btn-success"><?php echo trans('web.classesCompany2');?></button></a>
            </div>
        </div>
        <div class="row" style="margin-bottom:10px;">
            <div class="col-md-4" >
                <input id='showua' type="checkbox" onchange="showUnavailable()"/>
                <label><?php echo trans('web.showUnavailable');?></label>
            </div>
        </div>

        <table id="example1" class="table table-bordered table-striped" >
            <thead>
                <tr>
                    <th><?php echo trans('web.name');?></th>
                    <th><?php echo trans('web.date');?></th>
                    <th><?php echo trans('web.gym');?></th>
                    <th><?php echo trans('web.spot');?></th>
                    <th><?php echo trans('web.action');?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $k = 0;
                for ($i = 0; $i < count($classInfos); $i++) {
                    $classInfo = $classInfos[$i];
                    if (count($classInfo->classes) == 0)
                        continue;
                    foreach ($classInfo->classes as $classData) {
                        $k++;
                        $today = date("Y-m-d");
                        if ($today > date("Y-m-d", strtotime($classData->date))) {
                            echo "<tr class='uavailable' >";
                        } else
                            echo "<tr class='available'>";
                        ?>
                    <td><?php echo $classData->name; ?></td>
                    <td><?php echo date("d/m/Y", strtotime($classData->date)); ?></td>
                    <td>
                        <?php
                        for ($j = 0; $j < count($gymInfos); $j++) {
                            if ($gymInfos[$j]->id == $classData->gym) {
                                echo $gymInfos[$j]->name;
                            }
                        }
                        ?>
                    </td>
                    <td><?php echo $books[$k - 1] . " / " . $classData->value; ?></td>
                    <td>
                        <a href='/company/viewEditClass/<?php echo $classData->id; ?>' >
                            <?php echo trans('web.edit');?></a>&nbsp;&nbsp;&nbsp;
                        <a href='/company/actionDeleteClass/<?php
                echo $classData->id;
                ;
                ?>'><?php echo trans('web.delete');?></a>&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                        <?php
                       }
                   }
                   ?>
            </tbody>
        </table>
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

        $("#example1").DataTable();
    }
</script>
<script>
    showUnavailable();
</script>
