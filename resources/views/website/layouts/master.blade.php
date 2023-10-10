<!DOCTYPE html>
<!--[if IE 8 ]><html class="ie" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<!--<![endif]-->

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<!-- Basic Page Needs -->
	
	<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
	<title>{{$webSetting->Trans('title')}} | @yield('pageTitle')</title>

	<meta name="author" content="">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Boostrap style -->
	<link rel="stylesheet" type="text/css" href="{{asset('assets/website/stylesheets/bootstrap.min.css')}}">

	<!-- Ionicons style -->
	<link rel="stylesheet" type="text/css" href="{{asset('assets/website/stylesheets/ionicons.min.css')}}">

	<!-- REVOLUTION LAYERS STYLES -->
	<link rel="stylesheet" type="text/css" href="{{asset('assets/website/revolution/css/layers.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/website/revolution/css/settings.css')}}">

	<!-- Theme style -->
	<link rel="stylesheet" type="text/css" href="{{asset('assets/website/stylesheets/style.css')}}">

	<!-- Reponsive -->
	<link rel="stylesheet" type="text/css" href="{{asset('assets/website/stylesheets/responsive.css')}}">

	<!-- Colors -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 
	<link href="{{asset('assets/website/images/facion.jpg')}}" rel="shortcut icon">

	@if ($lang == 'ar')
	<link rel="stylesheet" type="text/css" href="{{asset('assets/website/stylesheets/rtl-style.css')}}">
	@endif
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-206615504-1">
</script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-206615504-1');
</script>

</head>

<body class="header_sticky">

	<div class="boxed">
		<section class="header style3">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="header-wrap">
							<div id="logo" class="logo">
								<a href="{{route('home')}}" title="{{$webSetting->Trans('title')}}">
									<img width="100px" src="{{asset('storage/'.$webSetting->logo)}}"
										alt="{{$webSetting->Trans('title')}}">
								</a>
							</div><!-- /.logo -->
							<div class="nav-wrap">
								<div class="btn-menu">
									<span></span>
								</div><!-- //mobile menu button -->
								<nav id="mainnav" class="mainnav">
									<ul class="menu">
										<li class="active">
											<a href="{{route('home')}}" title="">@lang('website.home')</a>
										</li>
										<li>
											<a href="{{route('about')}}" title="">@lang('website.about_us')</a>
										</li>
										<li>
											<a href="{{route('home')}}#services" title="">@lang('website.services')</a>
										</li>

										<li>
											<a href="{{route('join')}}" title="">@lang('website.request_join')</a>
										</li>
											<li>
											<a href="{{route('home')}}#tracking" title="">@lang('website.tracking')</a>
										</li>
											<li>
											<a href="{{route('contact')}}" title="">@lang('website.contact_us')</a>
										</li>
										
									
									</ul><!-- /.menu -->
								</nav><!-- /.mainnav -->
							</div><!-- /.nav-wrap -->
							<div class="header-content">
								 
							</div><!-- /.header-content -->
						</div><!-- /.header-wrap -->
					</div><!-- /.col-md-12 -->
				</div><!-- /.row -->
			</div><!-- /.container -->
		</section><!-- /.header style3 -->
		@yield('content')
		<footer class="footer" style="background:#4e5355">
			<div class="container">
				<div class="row">
					<div class="footer-widgets">
						<div class="col-md-4 col-sm-6 floatright">
							<div class="widget widget_text">
							
								<div class="textwidget">
								  <img src="https://www.onmap.sa/public/storage/website/logo/r93QyitpMa3ZswnJIW6dSh2hkk5DtwfYo342SYTu.png"  />
									<p>
										{{$webSetting->Trans('description')}}
									</p>
								</div>
							
							</div>
						</div><!-- /.col-md-4 col-sm-6 -->
						<div class="col-md-4 col-sm-6 floatright">
							<div class="widget widget-nav-menu">
								<h4 class="widget-title">قائمه سريعه</h4>
								<ul class="menu-our-services">
										<li class="active">
											<a href="{{route('home')}}" title="">@lang('website.home')</a>
										</li>
										<li>
											<a href="{{route('about')}}" title="">@lang('website.about_us')</a>
										</li>
 		                                 <li>
											<a href="{{route('home')}}#services" title="">@lang('website.services')</a>
										</li>
										<li>
											<a href="{{route('join')}}" title="">@lang('website.request_join')</a>
										</li>
											<li>	<a href="{{route('home')}}#tracking" title="">@lang('website.tracking')</a>
										</li>
										<li>
											<a href="{{route('blog.index')}}" title="">@lang('website.blog')</a>
										</li>
										<li>
											<a href="{{route('contact')}}" title="">@lang('website.contact_us')</a>
										</li>
									</ul><!-- /.menu -->
							</div><!-- /.widget widget-nav-menu -->
						</div><!-- /.col-md-4 col-sm-6 -->
						<div class="col-md-4 col-sm-6 floatright">
							<div class="widget widget-contact">
							    				<h4 class="widget-title">تواصل معنا </h4>
							    	<ul class="list-unstyled col-xs-12 col-md-12 footer-link   contact_footer">
                                                    <li class=""><a href="">
                                                    <i class="fa fa-phone fa-fw "></i> {{$webSetting->phone}}
                                                </a></li>
                    
                                            <li class=""><a href=""><i class="fa fa-envelope fa-fw "></i> {{$webSetting->email}}</a></li>
                                           
                    
                                   </ul>
					
									<div class="widget widget_socials " style="padding-top:20px">
									<div class="socials">
										<a class="twitter" target="_blank" href="{{$webSetting->twitter}}"><i
												class="fa fa-twitter"></i></a>
										<a class="facebook" target="_blank" href="{{$webSetting->facebook}}"><i
												class="fa fa-facebook"></i></a>
										<a class="pinterest" target="_blank" href="{{$webSetting->instgram}}"><i
												class="fa fa-instagram"></i></a>

									</div>
								</div>
							
							
							</div><!-- /.widget widget-contact -->
						</div><!-- /.col-md-4 col-sm-6 -->
					</div><!-- /.footer-widgets -->
				</div><!-- /.row -->
			</div><!-- /.container -->
		</footer><!-- /footer -->
            
		<section class="footer-bottom" style="background:#000000">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="copyright">
							<p> <i class="fa fa-copyright"></i> 2020 جميع الحقوق محفوظه لشركة اون ماب للشحن<a href="https://onmap.sa"></a></p>
						</div><!-- /.copyright -->
						<a class="go-top">
							<i class="fa fa-chevron-up"></i>
						</a><!-- /.go-top -->
					</div><!-- /.col-md-12 -->
				</div><!-- /.row -->
			</div><!-- /.container -->
		</section><!-- /.footer-bottom -->
				</section><!-- /.footer-bottom -->

	<!-- Javascript -->
	<script type="text/javascript" src="{{asset('assets/website/javascript/jquery.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/website/javascript/bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/website/javascript/easing.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/website/javascript/waypoints.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/website/javascript/parallax.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/website/javascript/jquery.flexslider-min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/website/javascript/owl.carousel.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/website/javascript/jquery-countTo.js')}}"></script>

	<script type="text/javascript" src="{{asset('assets/website/javascript/jquery.cookie.js')}}"></script>


	<script type="text/javascript"
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtRmXKclfDp20TvfQnpgXSDPjut14x5wk&region=GB"></script>
	<script type="text/javascript" src="{{asset('assets/website/javascript/gmap3.min.js')}}"></script>


	<script type="text/javascript" src="{{asset('assets/website/javascript/main.js')}}"></script>

	@yield('js')

	<!-- sweetalert -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
	<script>
		@if(Session::has('message'))
    sweetAlert({
        type: "{{Session::get('alert-type')}}",
        title: "{{Session::get('message')}}",
})
    @endif
	</script>
</body>

</html>