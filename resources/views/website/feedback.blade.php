@extends('website.layouts.master')
@section('pageTitle', __('website.send_requests'))
@section('content')

<section class="page-title style1" >
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumbs">
                        <h1 class="page-title-heading textright">@lang('website.send_requests')</h1>
                        <ul class="trail-items">
                            <li class="trail-item">
                                <a href="{{route('home')}}" title="@lang('website.home')">@lang('website.home')</a>
                                <span>></span>
                            </li>
                            <li class="trail-end">
                                    @lang('website.send_requests')
                            </li>
                        </ul><!-- /.trail-items -->
                    </div><!-- /.breadcrumbs -->
                </div><!-- /.col-md-12 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.page-title style1 -->

    <section class="flat-row flat-contact">
        <div class="container-fuild" >
            <div class="row">
                <div class="container">
                       <div class="row ">
             <div class="col-xs-12 col-md-6 floatright"  >
              <h3 style="color: #ffc107;">@lang('website.send_requestsfast')</h3>
              <p style="font-size: 18px;
    line-height: 26px;">@lang('website.send_requestdetails')</p>
              <ul class="list-unstyled sendreq">
                  <li>@lang('website.send_requestdetails1')</li>
                   <li>@lang('website.send_requestdetails2')</li>
                    <li>@lang('website.send_requestdetails3')</li>
                     <li>@lang('website.send_requestdetails4')</li>
              </ul>
              <style>
                 .sendreq li{
                   font-size: 18px;
    line-height: 26px;  
                 } 
              </style>
 
          
        </div>
        <div class="col-xs-12 col-md-6 floatright">
       <img src="https://logexpro.com/assets/website/images/101010.jpg"/>
        </div>
        </div>
                    <div class="row"> 
                    
                          
                        <div class="col-sm-12 text-center" style="padding-top:50px;">
                        <div class="contact-form">
                            <form  method="post" action="{{route('feedback.store')}}"> 
                                @csrf
                                <div class="flat-one-half floatright">
                                    <h3>بيانات المرسل </h3>
                                    <div class="input-name form-group">
                                        <input type="text"  tabindex="1" placeholder="@lang('website.sender_name')" value="{{ old('sender_name') }}" name="sender_name" id="sender_name" required>
                                        @error('sender_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                    <div class="input-mobile form-group">
                                        <input type="tel"  tabindex="2" placeholder="@lang('website.sender_mobile')" value="{{ old('sender_mobile') }}" name="sender_mobile" id="sender_mobile" required>
                                        @error('sender_mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                    <div class="input-subject form-group">
                                        <input type="text" placeholder="@lang('website.sender_address')" value="{{ old('sender_address') }}" name="sender_address" id="sender_address" required />
                                        @error('sender_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                    <div class="input-content form-group">
                                    <textarea name="content" class="form-control" id="content" placeholder="@lang('website.content')" required>{{ old('content') }}</textarea>
                                    @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                    
                                    
                                </div>
                                <div class="flat-one-half">
                                     <h3>بيانات المستلم </h3>
                                    <div class="input-name form-group">
                                        <input type="text"  tabindex="4" placeholder="@lang('website.receiver_name')" value="{{ old('receiver_name') }}" name="receiver_name" id="receiver_name" required>
                                        @error('receiver_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                    <div class="input-mobile form-group">
                                        <input type="tel"  tabindex="5" placeholder="@lang('website.receiver_mobile')" value="{{ old('receiver_mobile') }}" name="receiver_mobile" id="receiver_mobile" required>
                                        @error('receiver_mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                    <div class="input-subject form-group">
                                        <input type="text" tabindex="6" placeholder="@lang('website.receiver_address')" value="{{ old('receiver_address') }}" name="receiver_address" id="receiver_address" required />
                                        @error('receiver_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                    
                                    <div class="input-subject form-group">
                            
                                {!! Captcha::display($attributes=[],$options= ['lang'=>  ! empty($lang) ? $lang : 'en' ]) !!}
                                @if($errors->has("g-recaptcha-response"))
                                    <span class="help-block" style="color:red">{{ $errors->first("g-recaptcha-response") }}</span>
                                @endif
                                
                            </div>
                                    
                                    <div class="input-submit form-group">
                                        <button type="submit" class="btn-contact-form btn-block">@lang('website.send')</button>
                                    </div>
                                    
                                    </div>
                                    
                                    
                                <div class="clearfix"></div>
                            </form><!-- /form -->
                        </div><!-- /.contact-form -->
                    </div><!-- /.col-md-8 -->
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.flat-contact -->

     

@endsection

@section('js')

<script type="text/javascript" src="{{asset('assets/website/javascript/jquery-validate.js')}}"></script>

@endsection