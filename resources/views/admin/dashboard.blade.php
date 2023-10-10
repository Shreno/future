@extends('layouts.master')
@section('pageTitle', 'لوحه التحكم')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      الرئيسية 
    </h1>
 
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Info boxes -->
    <div class="row">
      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        
            <div class="info-box  bg-gr1">
                <span class="info-box-icon  elevation-1"><i class="fa-solid  fa-basket-shopping"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">طلبات المتاجر</span>
                <span class="info-box-number">{{\App\Order::count()}}</span>
                </div>
            </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        
         <div class="info-box  bg-red">
                <span class="info-box-icon  elevation-1"><i class="fa-solid fa-truck"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">مناديب المتاجر </span>
                <span class="info-box-number">{{\App\User::where('user_type', 'delegate')->count()}}</span>
                </div>
            </div>
            
 
      </div>
      <!-- ./col -->
      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
          <div class="info-box  bg-green">
                <span class="info-box-icon"><i class="fa-solid fa-cart-plus"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">المتاجر المشتركة </span>
                <span class="info-box-number">{{\App\User::where('user_type', 'client')->count()}}</span>
                </div>
            </div>
        
      </div>
      
    </div>
        <div class="row">
      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        
            <div class="info-box bg-blue">
                <span class="info-box-icon  elevation-1"><i class="fa-solid  fa-utensils"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">طلبات المطاعم</span>
                <span class="info-box-number">{{\App\Order::count()}}</span>
                </div>
            </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        
         <div class="info-box  bg-gr2">
                <span class="info-box-icon bg-danger elevation-1"><i class="fa-solid fa-cart-plus"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">المناديب </span>
                <span class="info-box-number">{{\App\User::where('user_type', 'delegate')->count()}}</span>
                </div>
            </div>
            
 
      </div>
      <!-- ./col -->
      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
          <div class="info-box  bg-green">
                <span class="info-box-icon bg-danger elevation-1"><i class="fa-solid fa-cart-plus"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">المتاجر </span>
                <span class="info-box-number">{{\App\User::where('user_type', 'client')->count()}}</span>
                </div>
            </div>
        < 
      </div>
      
    </div>
  
  
       <div class="col-xs-12" style="background: #fff;">
           
     <ul class="nav nav-tabs" style="
    background: #fff;
    font-weight: bold;
    margin: 15px;
    margin-bottom: 3px;">
    <li class="active"><a style="color: #000;
    padding-right: 25px;" data-toggle="tab" href="#menu1">اليوم</a></li>
    <li><a style="color: #000;
    padding-right: 25px;"  data-toggle="tab" href="#menu2">الكل</a></li>
    <li><a style="color: #000;
    padding-right: 25px;" data-toggle="tab" href="#menu3">أمس</a></li>
    <li><a  style="color: #000;
    padding-right: 25px;" data-toggle="tab" href="#menu4">أخر 30 يوم</a></li>
  </ul>

  <div class="tab-content">
       <div id="menu1" class="tab-pane fade in active">
           
                  <?php $today = (new \Carbon\Carbon)->today(); ?>
                  @foreach($statuses as $status)
                      <div class="col-sm-4 col-md-2 ">
                         
                          <div class="small-box  bg-gray box_status" style="    height: 120px !important;padding:10px; background-color: {{$status->color}} !important;height: 150px;">
                               <div class="icon">
                                  <i class="fa fa-shopping-bag"></i>
                              </div>
                              <a style="color:#000" href="{{url('/admin/client-orders?status_id='.$status->id .'&&bydate=Today' )}}">
                              <h4 class="text-center" >

                                  {{$status->orders()->whereDate('updated_at', $today)->count()}}
                              </h4>
                              <p class="text-center" >{{$status->title}}</p>
                              </a>
                          </div>
                      </div>
                  @endforeach
              </div>
               <div id="menu2" class="tab-pane fade in ">
                  @foreach($statuses as $status)
                  <div class="col-sm-4 col-md-2 ">
                      <div class="small-box  bg-gray box_status" style="    height: 120px !important;padding:10px; background-color: {{$status->color}} !important;    height: 150px;">
                          <div class="icon">
                                  <i class="fa fa-shopping-bag"></i>
                              </div>
                          <a style="color:#000" href="{{url('/admin/client-orders?status_id='.$status->id .'&&bydate=All' )}}">
                          <h4 class="text-center" >

                              {{$status->orders()->count()}}
                          </h4>
                          <p class="text-center" >{{$status->title}}</p>
                          </a>
                      </div>
                  </div>
                  @endforeach
              </div>
              <div id="menu3" class="tab-pane fade in">
                  <?php $yesterday = (new \Carbon\Carbon)->yesterday(); ?>
                  @foreach($statuses as $status)
                      <div class="col-sm-4 col-md-2 ">
                          <div class="small-box  bg-gray box_status" style="    height: 120px !important;padding:10px; background-color: {{$status->color}} !important;">
                              <div class="icon">
                                  <i class="fa fa-shopping-bag"></i>
                              </div>
                              <a style="color:#000" href="{{url('/admin/client-orders?status_id='.$status->id .'&&bydate=Yesterday' )}}">
                              <h4 class="text-center" >

                                  {{$status->orders()->whereDate('updated_at', $yesterday)->count()}}
                              </h4>
                              <p class="text-center" >{{$status->title}}</p>
                              </a>
                          </div>
                      </div>
                  @endforeach
              </div>
              <div id="menu4" class="tab-pane fade in">
                  <?php $month = (new \Carbon\Carbon)->subMonth()->submonths(1); ?>
                  @foreach($statuses as $status)
                      <div class="col-sm-4 col-md-2 ">
                          <div class="small-box  bg-gray box_status" style="    height: 120px !important; padding:10px; background-color: {{$status->color}} !important;">
                              <div class="icon">
                                  <i class="fa fa-shopping-bag"></i>
                              </div>
                              <a style="color:#000"  href="{{url('/admin/client-orders?status_id='.$status->id .'&&bydate=LastMonth' )}}">
                              <h4 class="text-center"  >
                                  {{$status->orders()->whereDate('updated_at', '>', $month)->count()}}
                              </h4>
                              <p class="text-center" >{{$status->title}}</p>
                              </a>
                          </div>
                      </div>
                  @endforeach
              </div>
  </div>
 <div>
  </section>
  <!-- /.content -->
</div>
@endsection
@section('js')
{!! $orderChart->script() !!}
{!! $clientChart->script() !!}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>

@endsection
