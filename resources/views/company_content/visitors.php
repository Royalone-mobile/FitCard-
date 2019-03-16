<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.dashboard');?></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-lg-3 col-xs-3">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?php echo $countVisit; ?></h3>

                        <p><?php echo trans('web.visits');?></p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-3">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php echo $countReview; ?></h3>

                        <p><?php echo trans('web.reviews');?></p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-star"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-3">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?php echo $amountPayment; ?>€</h3>

                        <p><?php echo trans('web.amount');?></p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-3">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?php echo $averageRating; ?></h3>

                        <p><?php echo trans('web.averageRating');?></p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-star"></i>
                    </div>                    
                </div>
            </div>

        </div>

        <div class="row" style="margin:10px;">
            <!-- ./col -->
            <h2><?php echo trans('web.activeGymUsers');?></h2>
            <div class="row" style="margin-bottom:10px;">
                <div class="col-md-4" >
                    <input id='showua' type="checkbox" onchange="showUnavailable()"/>
                    <label><?php echo trans('web.showUnavailable');?></label>
                </div>
            </div>
            <table  class="table table-bordered table-striped" >
                <thead>
                    <tr>
                        <th><?php echo trans('web.no');?></th>
                        <th><?php echo trans('web.name');?></th>
                        <th><?php echo trans('web.date');?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < count($bookVisits); $i++) {
                        $bookInfo = $bookVisits[$i];
                        if ($bookInfo->consumer == "")
                            continue;
                        $timestamp = strtotime($bookInfo->date) + 60 * 60 * 3;
                        $time = date('d/m/Y H:i', $timestamp);
                        $curTime = new \DateTime();
                        $curTime->setTimezone(new \DateTimeZone('Europe/Helsinki'));
                        $today = strtotime($curTime->format('Y-m-d H:i:m'));
                        if ($timestamp < $today) {
                            echo "<tr class='uavailable'>";
                        } else
                            echo "<tr class='available'>";
                        ?>
                    <td><?php echo $i + 1; ?></td>
                    <td><?php echo $bookInfo->consumer->name; ?></td>
                    <td>
                        <?php
                        echo $time;
                        ?>
                    </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            <!-- ./col -->
        </div>
        <div class="row" style="margin:10px;">
            <!-- ./col -->
            <h2><?php echo trans('web.classThisweek');?></h2>
            <table  class="table table-bordered table-striped" >
                <thead>
                    <tr>
                        <th><?php echo trans('web.no');?></th>
                        <th><?php echo trans('web.classBook');?></th>
                        <th><?php echo trans('web.name');?></th>
                        <th><?php echo trans('web.gymName');?></th>
                        <th><?php echo trans('web.date');?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < count($classes); $i++) {
                        $classInfo = $classes[$i];
                        if ($classInfo->gymInfo == "")
                            continue;
                        ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo $countBook[$i] . " / " . $classInfo->value; ?></td>
                            <td><?php echo $classInfo->name; ?></td>
                            <td><?php echo $classInfo->gymInfo->name; ?></td>
                            <td><?php echo date("d/m/Y", strtotime($classInfo->date)); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <!-- ./col -->
        </div>
        <!-- /.box-body -->
        <!--
        <label>Register Graph</label>
        <div class="chart">
            <canvas id="lineChart" style="height:300px"></canvas>
        </div>
        <label>Visit Graph</label>
        <div class="chart">
            <canvas id="lineChart1" style="height:300px"></canvas>
        </div>
        <label>Revenue Graph</label>
        <div class="chart">
            <canvas id="lineChart2" style="height:300px"></canvas>
        </div>
        -->



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
