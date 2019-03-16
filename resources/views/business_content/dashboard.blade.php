<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo trans('web.dashboard');?></h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="box-body">
            <div class="row">
                <div class="col-lg-4 col-xs-4">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?php echo $countCredit; ?></h3>

                            <p><?php echo trans('web.credits');?></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-xs-4">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?php echo $countVisit; ?></h3>

                            <p><?php echo trans('web.visits');?></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-star"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-4">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?php echo $averageBook; ?></h3>

                            <p><?php echo trans('web.book');?></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                    </div>
                </div>

            </div>

            <label><?php echo trans('web.visitGraph');?></label>
            <div class="chart">
                <canvas id="lineChart1" style="height:300px"></canvas>
            </div>
        </div>
        <!--
        <div class="chart">
            <canvas id="lineChart" style="height:400px"></canvas>
        </div>
        -->
    </div>
    <!-- /.box-body -->
</div>

<script>
    $(function () {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */

        //--------------
        //- AREA CHART -
        //--------------

        // Get context with jQuery - using jQuery's .get() method.
        function getdate(baseDate, delta)
        {
            var tt = baseDate

            var date = new Date(tt);
            var newdate = new Date(date);

            newdate.setDate(newdate.getDate() + delta);

            var dd = newdate.getDate();
            var DD = newdate.getDay();
            var mm = newdate.getMonth() + 1;
            var y = newdate.getFullYear();
            var keyword = ["MON", "TUE", "WED", "THU", "FRI", "SAT", "SUN"];
            var someFormattedDate = mm + '/' + dd;
            return someFormattedDate;
        }
        function getdate(baseDate, delta)
        {
            var tt = baseDate

            var date = new Date(tt);
            var newdate = new Date(date);

            newdate.setDate(newdate.getDate() + delta);

            var dd = newdate.getDate();
            var DD = newdate.getDay();
            var mm = newdate.getMonth() + 1;
            var y = newdate.getFullYear();
            var keyword = ["MON", "TUE", "WED", "THU", "FRI", "SAT", "SUN"];
            var someFormattedDate = mm + '/' + dd;
            return someFormattedDate;
        }
        var axis = ['Jan','Feb','Mar','Apr','May','Jue','Jul','Aug','Sep','Oct','Nov','Dec'];
        var areaChartOptions = {
            //Boolean - If we should show the scale at all
            showScale: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: false,
            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - Whether the line is curved between points
            bezierCurve: true,
            //Number - Tension of the bezier curve between points
            bezierCurveTension: 0.3,
            //Boolean - Whether to show a dot for each point
            pointDot: false,
            //Number - Radius of each point dot in pixels
            pointDotRadius: 4,
            //Number - Pixel width of point dot stroke
            pointDotStrokeWidth: 1,
            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius: 20,
            //Boolean - Whether to show a stroke for datasets
            datasetStroke: true,
            //Number - Pixel width of dataset stroke
            datasetStrokeWidth: 2,
            //Boolean - Whether to fill the dataset with a color
            datasetFill: true,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true
        };

        var areaChartData1 = {
            labels: axis,
            datasets: [
                {
                    label: "Electronics",
                    fillColor: "rgba(0, 255, 0, 1)",
                    strokeColor: "rgba(0, 255, 0, 1)",
                    pointColor: "rgba(0, 255, 0, 1)",
                    pointStrokeColor: "#c1c7d1",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: <?php echo $graphs; ?>
                }
            ]
        };
        var lineChartCanvas2 = $("#lineChart1").get(0).getContext("2d");
        var lineChart2 = new Chart(lineChartCanvas2);
        var lineChartOptions2 = areaChartOptions;
        lineChartOptions2.datasetFill = false;
        lineChart2.Line(areaChartData1, lineChartOptions2);
    });
</script>
