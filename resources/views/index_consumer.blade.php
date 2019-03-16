@extends('default')

@section('content')
<script>
    function detectmob() {
        if( navigator.userAgent.match(/Android/i)
        || navigator.userAgent.match(/webOS/i)
        || navigator.userAgent.match(/iPhone/i)
        || navigator.userAgent.match(/iPad/i)
        || navigator.userAgent.match(/iPod/i)
        || navigator.userAgent.match(/BlackBerry/i)
        || navigator.userAgent.match(/Windows Phone/i)
        ){
          return true;
        }
        else {
          return false;
        }
    }
    function scrollPos()
    {
        if (!detectmob())
        {
        var element = document.getElementById('bodyId').scrollTop;
        if (element > 100)
        {
            var navBar = document.getElementById('headersticky');
            navBar.style.backgroundColor = "#2798c6";
        }
        else
        {
            var navBar = document.getElementById('headersticky');
            navBar.style.backgroundColor = "transparent";
        }
        console.log(element);
      }
    }
</script>
<body id="bodyId" onscroll="scrollPos()">
    <div class="collapse" id="searcharea"><!-- top search -->
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">
                <button class="btn tp-btn-primary" type="button">Search</button>
            </span> </div>
    </div>

    <!-- /.top search -->
    @include('layout.consumer_header')
    @include('layout.consumer_content')
    @include('layout.consumer_footer')

    <script src="<?php echo url('/')  . "/"; ?>js/sweetalert2.min.js"></script>

    <!-- Include this after the sweet alert js file -->
    
    @include('sweet::alert')


    <script src="<?php echo url('/')  . "/"; ?>js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo url('/') . "/"; ?>js/bootstrap.min.js"></script>
    <script src="<?php echo url('/')  . "/"; ?>js/nav.js"></script>
    <script type="text/javascript" src="<?php echo url('/')  . "/"; ?>js/bootstrap-select.js"></script>
    <script src="<?php echo url('/') . "/"; ?>js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="<?php echo url('/')  . "/"; ?>js/slider.js"></script>
    <script type="text/javascript" src="<?php echo url('/')  . "/"; ?>js/testimonial.js"></script>

    <script src="<?php echo url('/')  . "/"; ?>js/jquery.sticky.js"></script>
    <script src="<?php echo url('/')  . "/"; ?>js/header-sticky.js"></script>
@endsection
