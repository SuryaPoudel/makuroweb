
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>N&S Cleaning Services</title>
<!-- Bootstrap -->
<link href="/inspection/css/bootstrap.min.css" rel="stylesheet">
<!--====================
Icon Font Css 
=====================-->
<link href="/inspection/css/font-awesome.css" rel="stylesheet">
<!--====================
Plugins Css 
=====================-->
<!-- Owl Stylesheets -->
<link rel="stylesheet" href="/inspection/css/owl.carousel.min.css">
<link rel="stylesheet" href="/inspection/css/owl.theme.default.min.css">
<!--====================
Core Css 
=====================-->
<link href="/inspection/css/style.css" rel="stylesheet">
<link href="/inspection/css/responsive.css" rel="stylesheet">
</head>
<body>
<!-- scrollToTop --> 
<!-- ================ -->
<div class="scrollToTop"><i class="fa fa-angle-up"></i></div>
<!--====================
Hero Section Start
=====================-->
<section class="hero-section">
    <div class="circle right-circle"></div>
    <div class="container"> 
        <!--====================
			Navbar Start
			=====================-->
            @include('layouts.frontend-include.header')
            @if (Request::is('/'))

            @include('layouts.frontend-include.slider')

            @endif
          
       
    </div>
<!--====================
Popup Menu Start 
=====================-->
   @include('layouts.frontend-include.nav')
</section>


@yield('content')


<!--====================

Information section Start
=====================-->
@if (Request::is('/'))
@include('layouts.frontend-include.information')
@endif
<!--====================
Newsletter Start

Footer Start
=====================-->
@include('layouts.frontend-include.footer')
<script src="/inspection/js/jquery.min.js"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="/inspection/js/bootstrap.min.js"></script> 
<!-- Owl Jquery --> 
<script src="/inspection/js/owl.carousel.js"></script> 
<script src="/inspection/js/script.js"></script>
</body>
</html>
