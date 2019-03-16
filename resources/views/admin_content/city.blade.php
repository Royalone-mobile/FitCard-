<script>
    function clickCreate()
    {
        var formElement = document.getElementById("profileForm");
        formElement.submit();
    }
</script>
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.cityList');?></h3>
    </div>
    <!-- /.box-header -->

    <div class="box-body">
        <div class="row" style="margin-bottom:10px;">

        </div>

        <div class="box-body">
            <div class="form-group">
                <div class="row">
                    <form role="form" method="post" id="profileForm" action='/admin/actionCreateCity'>
                        <input type="text" name="_token" id="token" value="{{ csrf_token() }}" style="visibility: hidden; width: 1px; height: 1px">
                        <input type="hidden" name="imagepath" id="imagePath" style="visibility: hidden; width: 1px; height: 1px">
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="city_name" name="city_name" placeholder="Enter City">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="city_lat" name="city_lat" placeholder="Latitude">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="city_lon" name="city_lon" placeholder="Longitude">
                        </div>
                    </form>

                </div>
                <div class="row" style="margin-top:10px;">
                    <div class='col-md-2'>
                        <button  class ="btn btn-block btn-success" onclick="clickCreate()"><?php echo trans('web.createButton');?></button>
                    </div>
                </div>
            </div>

        </div>

        <table class="table table-bordered table-striped" >
            <thead>
                <tr>
                    <th><?php echo trans('web.no');?></th>
                    <th><?php echo trans('web.city');?></th>
                    <th><?php echo trans('web.action');?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < count($data); $i++) {
                    ?>
                    <tr>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $data[$i]->city_name; ?></td>
                        <td>
                            <a href='/admin/actionDeleteCity/<?php
                            echo $data[$i]->id;
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

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
<script type="text/javascript">
google.maps.event.addDomListener(window, 'load', function () {
    var places = new google.maps.places.Autocomplete(document.getElementById('city_name'));
    google.maps.event.addListener(places, 'place_changed', function () {

        var place = places.getPlace();
        var address = place.formatted_address;
        var latitude = place.geometry.location.lat();
        var longitude = place.geometry.location.lng();
        var mesg = "Address: " + address;
        document.getElementById('city_lat').value = latitude;
        document.getElementById('city_lon').value = longitude;
    });
});
</script>
