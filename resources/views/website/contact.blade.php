@extends('website.layouts.master')
@section('pageTitle', __('website.contact_us'))
@section('content')
<style>
    textarea#message {
    padding: 5px;
    border: 2px solid #f9b233;
    font-weight: bold;
}
input{
     padding: 5px;
    border: 2px solid #f9b233;
    font-weight: bold;
}
.flat-contact {
    padding: 10px;
}
</style>
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

    <section class="flat-row flat-contact">
          <div class="container">
            <div class="row"> 
            <div class="col-xs-12 flat-row-title" style="margin-bottom:0px">
                <h2>تواصل معنا</h2>
                </div>
                  
                     <div class="col-sm-12 text-center" style="padding-top:50px;">
                    <div class="contact-form">
                        <form  method="post" action="{{route('contact.store')}}"> 
                            @csrf
                            <div class="flat-one-half floatright">
                                <div class="input-name">
                                    <input type="text"  tabindex="1" placeholder="@lang('website.name')" value="{{ old('name') }}" name="name" id="name" required>
                                    @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                </div>
                                    <div class="input-subject">
                                    <input type="text" placeholder="@lang('website.subject')" value="{{ old('subject') }}" name="subject" id="subject" required />
                                    @error('subject')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                </div>
                              
                                <div class="input-submit">
                                    <button type="submit" class="btn-contact-form btn-block">@lang('website.send')</button>
                                </div>
                            </div>
                            <div class="flat-one-half">
                                 <div class="input-email">
                                    <input type="email"  tabindex="2" placeholder="@lang('website.email')" value="{{ old('email') }}" name="email" id="email" required>
                                    @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                </div>
                             
                                <textarea name="message" id="message" placeholder="@lang('website.message')" required>{{ old('message') }}</textarea>
                                @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="clearfix"></div>
                        </form><!-- /form -->
                    </div><!-- /.contact-form -->
                </div><!-- /.col-md-8 -->
            </div>
      </div>
      
         
    </section><!-- /.flat-contact -->

      <section class="flat-row flat-contact" style="background:#f7f7f7">
         
      
        <div class="container" >
            <div class="row">
                
     <div class="col-xs-12" style="background:#f3f3f3">
           <div class="col-md-4 col-xs-12 floatright text-center">
                <div class="iconbox style4" style="background:#fff;">
                        <div class="iconbox-icon" style="margin-bottom: 0;">
                           <i class="fa fa-2x fa-map-marker"  style="color:#ffc107;"></i>
                        </div>
                   
                          <h3 class="iconbox-title">@lang('website.address')  </h3>
                    <div class="iconbox-content text-center">
                    
                        <div class="iconbox-desc">
                            {{$webSetting->Trans('address')}}
                        </div>
                    </div>
                </div><!-- /.iconbox style4 -->
            </div><!-- /.col-sm-4 -->
              <div class="col-md-4 col-xs-12 floatright text-center">
                <div class="iconbox style4" style="background:#fff;">
                  <div class="iconbox-icon" style="margin-bottom: 0;">
                           <i class="fa fa-2x fa-mobile"  style="color:#ffc107;"></i>
                        </div>
                   
                          <h3 class="iconbox-title"> @lang('website.phone') </h3>
                    <div class="iconbox-content text-center">
                    
                        <div class="iconbox-desc">
                            @lang('website.call_us_now'): {{$webSetting->phone}}
                        </div>
                    </div>
                </div><!-- /.iconbox style4 -->
            </div><!-- /.col-sm-4 -->
              <div class="col-md-4 col-xs-12 floatright text-center">
                <div class="iconbox style4" style="background:#fff;">
                   <div class="iconbox-icon" style="margin-bottom: 0;">
                           <i class="fa fa-2x fa-envelope" style="color:#ffc107;"></i>
                        </div>
                  
                          <h3 class="iconbox-title"> @lang('website.email') </h3>
                    <div class="iconbox-content text-center">
                    
                        <div class="iconbox-desc">
                            {{$webSetting->email}}
                        </div>
                    </div>
                </div><!-- /.iconbox style4 -->
            </div><!-- /.col-sm-4 -->
     </div>
                
                
                
                
                
                
                
     
                
                
             
           
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.flat-contact -->

@endsection

@section('js')

<script type="text/javascript" src="{{asset('assets/website/javascript/jquery-validate.js')}}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtRmXKclfDp20TvfQnpgXSDPjut14x5wk&region=GB"></script>
<script type="text/javascript" src="{{asset('assets/website/javascript/gmap3.min.js')}}"></script>

@endsection