<meta name="csrf-token" content="{{ csrf_token() }}" />
<script>
    function onSearch()
    {
    var formElement = document.getElementById("searchForm");
            var formData = new FormData(formElement);
            $.ajax({
            type: 'POST',
                    data: formData,
                    url: '/company/ajaxMonthPayment',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                    var element = document.getElementById("tableBody");
                    element.innerHTML = "";
                    for (i = 0; i < data.length; i++)
                    {
                        companyInfo = data[i];
                        var vendorContent = document.implementation.createHTMLDocument("New Document");
                        var trElement = vendorContent.createElement("tr");
                        element.appendChild(trElement);
                        var tdElement2 = vendorContent.createElement("td");
                        var tdElement3 = vendorContent.createElement("td");
                        var tdElement4 = vendorContent.createElement("td");

                        tdElement2.innerHTML = companyInfo.gym;
                        tdElement3.innerHTML = companyInfo.class;
                        tdElement4.innerHTML = companyInfo.gym * 5 + companyInfo.class * 5;
                        trElement.appendChild(tdElement2);
                        trElement.appendChild(tdElement3);
                        trElement.appendChild(tdElement4);
                    }
                }
                });
            }
</script>
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.payments');?></h3>
    </div>
    <!-- /.box-header -->

    <div class="box-body">
        <div class="row" style="margin-bottom:10px;">
            <form id="searchForm">
                <input type="text" name="_token" id="token" value="{{ csrf_token() }}" style="visibility: hidden; width: 1px; height: 1px">
                <div class="col-md-2">
                    <select class="form-control" name="year" onchange="onSearch()">
                        <option value="all"><?php echo trans('web.all');?></option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control" name="month" onchange="onSearch()">
                        <option value="all"><?php echo trans('web.all');?></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
            </form>
        </div>
        <table class="table table-bordered table-striped" >
            <thead>
                <tr>
                    <th><?php echo trans('web.gymVisits');?></th>
                    <th><?php echo trans('web.classBook');?></th>
                    <th><?php echo trans('web.amount');?></th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <tr>
                    <td><?php echo $gymVisits[0];?></td>
                    <td><?php echo $classCounts[0];?></td>
                    <td><?php echo $gymVisits[0] * 5 + $classCounts[0] * 5;?></td>
                </tr>
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
