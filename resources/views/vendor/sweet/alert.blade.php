@if (Session::has('sweet_alert.alert'))
    <script>
        swal({
            text:"<?php echo Session::get('sweet_alert.text');?>",
            type:"<?php echo Session::get('sweet_alert.type');?>",
            timer:100000,
            showCloseButton:true,
            showConfirmButton:"<?php echo Session::get('sweet_alert.showConfirmButton');?>",
            confirmButtonText:"<?php echo Session::get('sweet_alert.confirmButtonText');?>",
        }).then(function()
        {
            location.href = "http://www.facebook.com/sharer.php?u=" + window.location.href;            
        });
    </script>
@endif
