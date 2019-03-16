<meta name="csrf-token" content="{{ csrf_token() }}" />
<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    function createPlayer()
    {
        var tokenElement = document.getElementById("token");
        tokenElement.value = CSRF_TOKEN;

        var userIdElement = document.getElementById("pax_userid");
        var paxnameElement = document.getElementById("pax_paxname");
        var tdateElement = document.getElementById("pax_travel");
        var adateElement = document.getElementById("pax_arrival");
        var destElement = document.getElementById("pax_destination");
        var departElement = document.getElementById("pax_departuretrip");
        var etdElement = document.getElementById("pax_etd");
        var ataElement = document.getElementById("pax_ata");
        var visatypeElement = document.getElementById("pax_visatype");
        var accoElement = document.getElementById("pax_accomo");
        var staffElement = document.getElementById("pax_staff");
        var passportnoElement = document.getElementById("pax_passportno");
        var contactElement = document.getElementById("pax_contactno");
        var empoyerElement = document.getElementById("pax_employer");
        var requirementElement = document.getElementById("pax_requirement");
        var badgenoElement = document.getElementById("pax_badgeno");
        var passportElement = document.getElementById("pax_passportexpire");
        var visanoElement = document.getElementById("pax_visano");
        var visaexpireElement = document.getElementById("pax_visaexpire");
        var reqElement = document.getElementById("pax_requestid");
        var remarkElement = document.getElementById("pax_remark");
        var avElement = document.getElementById("pax_arrivaltrip");


        var formElement = document.getElementById("profileForm");

        if ((userIdElement.value == "") || (paxnameElement.value == "")
                || (tdateElement.value == "") || (adateElement.value == "")
                || (destElement.value == "")
                || (departElement.value == "") || (etdElement.value == "")
                || (ataElement.value == "")
                || (visatypeElement.value == "") || (accoElement.value == "")
                || (staffElement.value == "") || (passportnoElement.value == "")
                || (contactElement.value == "") || (empoyerElement.value == "")
                || (requirementElement.value == "") || (badgenoElement.value == "")
                || (passportElement.value == "") || (visanoElement.value == "")
                || (visaexpireElement.value == "") || (reqElement.value == "")
                || (remarkElement.value == "") || (avElement.value == ""))
        {
            alert("Please fill Input");
            return;
        }
        formElement.action = "createPaxUser";
        formElement.submit();
        return;
    }
    function changePsd()
    {
        var psdElement = document.getElementById("pax_psd");
        var vehicleElement = document.getElementById("pax_vehicle");
        var memSelect = psdElement.options[psdElement.selectedIndex].value;
        var elements = document.getElementsByClassName("vehicle");
        t = -1;
        for (j = 0; j < elements.length; j++)
        {
            if (elements[j].id != memSelect)
            {                
                elements[j].style.display = "none";
            }
            else
            {
                elements[j].style.display = "inline";
                if (t == -1)
                    t = j;
            }

        }
        vehicleElement.selectedIndex = t;
    }
</script>
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo trans('web.createLocation');?></h3>
    </div>    
    <div class="box box-primary">
        <form role="form" method="post" id="profileForm">
            <input type="text" name="_token" id="token" style="visibility: hidden; width: 1px; height: 1px">
            <div class="box-body">
                <input type="hidden" name="imagepath" id="imagePath" style="visibility: hidden; width: 1px; height: 1px">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.user');?></label>
                            <input type="email" class="form-control" id="pax_userid" name="pax_userid" placeholder="<?php echo trans('web.user');?>">
                        </div>
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"><?php echo trans('web.location');?></label>
                            <input type="email" class="form-control" id="pax_paxname" name="pax_paxname" placeholder="<?php echo trans('web.location');?>">
                        </div>                                                
                    </div>                    
                </div>                   

            </div>
        </form>
        <div class="box-footer">
            <button class="btn btn-primary" onclick="createPlayer()"><?php echo trans('web.create');?></button>
        </div>
        <!-- /.box-body -->
    </div>
</div>
<script>
    changePsd();
</script>


