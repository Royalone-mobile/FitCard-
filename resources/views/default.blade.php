<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FitCard</title>

    <!-- Bootstrap -->
    <link href="<?php echo url('/') . "/"; ?>css/bootstrap.min.css" rel="stylesheet">

    <!-- Template style.css -->
    <link rel="stylesheet" type="text/css" href="<?php echo url('/')  . "/"; ?>css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo url('/')  . "/"; ?>css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="<?php echo url('/')  . "/"; ?>css/owl.theme.css">
    <link rel="stylesheet" type="text/css" href="<?php echo url('/') . "/"; ?>css/owl.transitions.css">
    <link rel="stylesheet" type="text/css" href="<?php echo url('/')  . "/"; ?>css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo url('/')  . "/"; ?>css/sweetalert2.min.css">

    <!--font awesome icon -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- favicon icon -->
    <link rel="shortcut icon" href="<?php echo url('/')  . "/"; ?>images/icon.png" type="image/x-icon">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Fonts --> 
    <link href="https://fonts.googleapis.com/css?family=Oswald|Source+Sans+Pro" rel="stylesheet">
    {!! Html::style('/css/main.css') !!}

	@yield('title')

</head>
<body>
	@yield('content')
</body>

</html>
