@extends('layouts.master')
@section('pageTitle', 'Dashboard')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
        @lang('app.dashboard')
    </h1>
     
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="row">
       
        
            <div class="col-lg-6 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>{{auth()->user()->orders()->count()}}</h3>

            <p>@lang('app.orders', ['attribute' => ''])</p>
          </div>
          <div class="icon">
            <i class="fa fa-shopping-bag"></i>
          </div>
          
        </div>
      </div>
         
               
         <div class="col-lg-6 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red ">
          <div class="inner">
            <h3>{{($balance == null) ? '0' : $balance}}</h3>

            <p>@lang('app.balance', ['attribute' => '' ])</p>
          </div>
          <div class="icon">
            <i class="fa fa-money"></i>
          </div>
          
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
   
    
  </ul>


<div class="tab-content">
       <div id="menu1" class="tab-pane fade in active">
           
                             <?php $today = (new \Carbon\Carbon)->today(); ?>
                  @foreach($statuses as $status)
                      <div class="col-sm-4 col-md-2 ">
                       <div class="small-box  bg-gray box_status" style="    height: 120px !important;padding:10px; background-color: {{$status->color}} !important;    height: 150px;">
                          <div class="icon">
                                  <i class="fa fa-shopping-bag"></i>
                              </div>
                              <a style="color:#000" href="{{url('/client/orders?status_id='.$status->id .'&&bydate=Today' )}}">
                              <h4 class="text-center" >

                                  {{$status->orders()->where('user_id', Auth()->user()->id)->whereDate('updated_at', $today)->count()}}
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
                          <a style="color:#000" href="{{url('/client/orders?status_id='.$status->id .'&&bydate=All' )}}">
                          <h4 class="text-center" >

                              {{$status->orders()->where('user_id', Auth()->user()->id)->count()}}
                          </h4>
                          <p class="text-center" >{{$status->title}}</p>
                          </a>
                      </div>
                  </div>
                  @endforeach
              </div>
      
             
          </div>


      </div>
     
       
   
    </div>

     
    <!-- /.row -->

   
  </section>
  <!-- /.content -->
</div>
@endsection
@section('js')
{!! $orderChart->script() !!}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
@endsection
