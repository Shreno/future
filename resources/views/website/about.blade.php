@extends('website.layouts.master')
@section('pageTitle', __('website.home'))
@section('content')

<section class="page-title style1">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                     
                     
                </div><!-- /.breadcrumbs -->
            </div><!-- /.col-md-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.page-title style1 -->

<section class="flat-row flat-counter style2">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 floatright">
                <div class="counter-box">
                    <div class="flat-text-box">
                          <h1  class="text-center">من نحن </h1>
                          <h3 class="iconbox-title large text-center">{{$webSetting->trans('about_description')}}</h3>
                            <h3 class="iconbox-title large">
                                
                    </div><!-- /.flat-text-box -->
                    <div class="height60"></div>
                    
                </div><!-- /.counter-box -->
            </div><!-- /.col-sm-6 -->
            <div class="col-sm-6 floatright">
                <div class="counter-slider">
                    <div class="flexslider">
                        <ul class="slides">
                            <li>
                                <a href="#" title="">
                                <img    width="100%" src="{{asset('storage/'.$webSetting->image)}}"  />
                                </a>
                            </li>
                        </ul><!-- /.slides -->
                    </div><!-- /.flexslider -->
                </div><!-- /.counter-slider -->
            </div><!-- /.col-sm-6 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.flat-counter style2 -->




@endsection