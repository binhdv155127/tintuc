<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tin tức @yield('title')</title>

    <base href="{{asset('')}}">
    <!-- Bootstrap Core CSS -->
    <link href="user/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="user/css/shop-homepage.css" rel="stylesheet">
    <link href="user/css/my.css" rel="stylesheet">
    @yield('css')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

   @include('layout.header')
    
   @yield('content')

    @include('layout.footer')
    <!-- jQuery -->
    <script src="user/js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="user/js/bootstrap.min.js"></script>
    <script src="user/js/my.js"></script>
 
    @yield('script')
</body>

</html>
