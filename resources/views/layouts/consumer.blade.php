<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FitCard</title>

    <!-- favicon icon -->
    <link rel="shortcut icon" href="{{ url('images/icon.png') }}" type="image/x-icon">

    <!-- Bootstrap -->
    {!! Html::style('css/bootstrap.min.css') !!}

    <!-- Template style.css -->
    {!! Html::style('css/style.css') !!}
    {!! Html::style('css/owl.carousel.css') !!}
    {!! Html::style('css/owl.theme.css') !!}
    {!! Html::style('css/owl.transitions.css') !!}
    {!! Html::style('css/bootstrap-select.min.css') !!}
    {!! Html::style('css/sweetalert2.min.css') !!}

    <!--font awesome icon -->
    {!! Html::style('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css') !!}

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    {!! Html::script('https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js') !!}
    {!! Html::script('https://oss.maxcdn.com/respond/1.4.2/respond.min.js') !!}
    <![endif]-->

    <!-- Fonts -->
    {!! Html::style('https://fonts.googleapis.com/css?family=Oswald|Source+Sans+Pro') !!}

    <!-- Site custom stylesheet -->
    {!! Html::style('/css/main.css') !!}

    <!-- Site javascript files -->
    {{ Html::script('js/jquery.min.js') }}

    {{ Html::script('js/sweetalert2.min.js') }}

    <script type="text/javascript">
        $(document).on({
            ajaxStart: function () {
                $('body').addClass("loading");
            },
            ajaxStop: function () {
                $('body').removeClass("loading");
            }
        });
    </script>
</head>
<body>

<!-- top search -->
<div class="collapse" id="searcharea">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for...">
        <span class="input-group-btn"><button class="btn tp-btn-primary" type="button">Search</button></span>
    </div>
</div>
<!-- /.top search -->

@include('sweet::alert')

@include('consumer.header')

@yield('content')

@include('consumer.footer')
</body>
</html>