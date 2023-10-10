@extends('website.layouts.master')
@section('pageTitle', __('website.home'))
@section('content')

<section class="tp-banner">
    <div class="container">
        <div id="rev_slider_1078_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container"
            data-alias="classic4export" data-source="gallery"
            style="margin:0px auto;background-color:transparent;padding:0px;margin-top:0px;margin-bottom:0px;">
            <!-- START REVOLUTION SLIDER 5.3.0.2 auto mode -->
            <div id="rev_slider_1078_1" class="rev_slider fullwidthabanner" style="display:none;"
                data-version="5.3.0.2">
                <div class="slotholder"></div>
                <ul>
                    <?php $count = 1 ?>
                    @foreach ($sliders as $slider)
                    <!-- SLIDE  -->
                    <li data-index="rs-{{$count}}" data-transition="fade" data-slotamount="default"
                        data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default"
                        data-masterspeed="300" data-rotate="0" data-saveperformance="off" data-title="Slide"
                        data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6=""
                        data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
                        <!-- MAIN IMAGE -->
                        <img src="{{asset('storage/'.$slider->image)}}" alt="" title="slider7" width="1920" height="870"
                            data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat"
                            class="rev-slidebg" data-no-retina>
                        <!-- LAYERS -->

                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption title-slide   tp-resizeme" id="slide-1-layer-1"
                            data-x="['95','95','125','20']" data-y="['187','150','100','50']" data-width="['auto']"
                            data-height="['auto']" data-fontsize="['73','50','45','26']"
                            data-lineheight="['83','60','50','32']" data-type="text" data-responsive_offset="on"
                            data-frames='[{"delay":500.000305176,"speed":890,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":310,"frame":"999","to":"opacity:0;","ease":"nothing"}]'
                            data-textAlign="['left','left','left','center']" data-paddingtop="[0,0,0,0]"
                            data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                            style="color:#4e5355; ">
                            {{$slider->Trans('title')}}
                        </div>

                        <!-- LAYER NR. 6 -->
                        <div class="tp-caption content-slide   tp-resizeme" id="slide-2-layer-2"
                            data-x="['95','95','126','0']" data-y="['385','310','250','150']" data-height="['auto']"
                            data-fontsize="['21','21','18','15']" data-lineheight="['31','31','27','20']"
                            data-width="['800', '600', '600', '300']"
                            data-whitespace="['nowrap', 'nowrap', 'nowrap', 'normal']" data-type="text"
                            data-responsive_offset="on"
                            data-frames='[{"delay":1000.00030518,"speed":910,"frame":"0","from":"y:-50px;opacity:0;","to":"o:1;","ease":"Power2.easeInOut"},{"delay":"wait","speed":310,"frame":"999","to":"opacity:0;","ease":"nothing"}]'
                            data-textAlign="['left','left','left','center']" data-paddingtop="[0,0,0,0]"
                            data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                            style="z-index: 6; white-space: nowrap; font-weight: 400; color: rgba(255,255,255,1); letter-spacing: px;font-family:Karla;">
                            {{$slider->Trans('details')}} </div>

                        @if ($slider->Trans('btn_title'))
                        <!-- LAYER NR. 7 -->
                        <a target="_blank" href="{{$slider->btn_link}}">
                            <div class="tp-caption button-slide rev-btn  tp-resizeme" id="slide-2-layer-3"
                                data-x="['94','94','124','5']" data-y="['496','423','353','263']"
                                data-width="['163', '163', '156', '131']" data-height="['50','50','48','44']"
                                data-fontsize="['15','15','14','13']" data-lineheight="['24','24','23','20']"
                                data-type="button" data-responsive_offset="on"
                                data-frames='[{"delay":1500.00030518,"speed":890,"frame":"0","from":"x:-50px;opacity:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":310,"frame":"999","to":"opacity:0;","ease":"nothing"},{"frame":"hover","speed":"0","ease":"Linear.easeNone","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgba(255,255,255,1);bs:solid;bw:0 0 0 0;"}]'
                                data-textAlign="['left','left','center','center']" data-paddingtop="[14,14,14,14]"
                                data-paddingright="[10,10,10,10]" data-paddingbottom="[14,14,14,14]"
                                data-paddingleft="[27,20,20,15]"
                                style="z-index: 7; white-space: nowrap; color: rgba(255,255,255,1); letter-spacing: px; border-color:rgba(0,0,0,1);border-width:0px 0px 0px 0px;outline:none;box-shadow:none;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;cursor:pointer;">
                                {{$slider->Trans('btn_title')}}
                            </div>
                        </a>
                        <!-- LAYER NR. 8 -->
                        @endif
                    </li>
                    <?php $count++ ?>
                    @endforeach
                </ul>
            </div>
        </div><!-- END REVOLUTION SLIDER -->
    </div>
</section><!-- /.tp-banner -->
<section class="flat-row flat-counter parallax " id="tracking" style="padding:0px; background:#f7f7f7" >
    <div class="container">
        <div class="row">
            <div class="col-md-6  col-xs-12  floatright" style="padding:40px">
                <div class="col-xs-12">
                    <div class="flat-row-title" >
                        <h2>@lang('website.enter_you_track_id')</h2>

                    </div>
                </div>

                <div class="col-xs-12" style="margin-top: 10px;">
                    <form method="get" action="{{route('track.order')}}" class="track-form" abineguid="48392415BB234142827D6C3C56D8151B">
                        <input type="text" name="tracking_id" placeholder="رقم تتبع للشحنة" required>
                        <i class="fa  fa-search "></i>
                    </form>
                </div>
                <!-- /.counter-title -->
            </div>
            <!-- /.col-sm-6 -->
            <div class="col-md-6 col-xs-12 text-center  floatright">
                               <img src="https://onmap.sa/public/assets/website/images/tracking.png"  />
            </div>

        </div><!-- /.row -->
    </div><!-- /.container -->
  
</section><!-- /.flat-counter parallax3 -->
 
<section class="flat-iconbox style4" id="services">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="flat-row-title">
                    <h2>@lang('website.what_we_services')</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($services as $service)

            <div class="col-md-4 col-xs-12 floatright text-center">
                <div class="iconbox style4">
                  
                    <div class="iconbox-icon">
                        <img src="{{asset('storage/'.$service->icon_class)}}" class="img-responsive " alt="{{$service->trans('title')}}">
                    </div>
                          <h3 class="iconbox-title">{{$service->trans('title')}}</h3>
                    <div class="iconbox-content text-center">
                    
                        <div class="iconbox-desc">
                            {{$service->trans('details')}}
                        </div>
                    </div>
                </div><!-- /.iconbox style4 -->
            </div><!-- /.col-sm-4 -->
            @endforeach
        </div><!-- /.row -->
    </div>
</section><!-- /.flat-iconbox  -->

<section class="flat-row flat-form-qoute parallax " style="background-position: 50% 2px;">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 floatright">
                <form action="{{route('join.store')}}" method="POST" accept-charset="utf-8">
                    @csrf
                    <div class="form-qoute">
                        <div class="form-qoute-title center">
                            @lang('website.request_join')
                        </div>
                        <div class="flat-wrap-form">
                            <div class="flat-wrap-input">
                                <input type="text" name="name" value="{{ old('name') }}" size="40" aria-invalid="false"
                                    placeholder="@lang('website.name')" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="flat-wrap-input">
                                <input type="email" name="email" value="{{ old('email') }}" size="40"
                                    aria-invalid="false" placeholder="@lang('website.email')" required>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="flat-wrap-input">
                                <input type="text" name="phone" value="{{ old('phone') }}" size="40"
                                    placeholder="@lang('website.phone')" required>
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="flat-wrap-input">
                                <input type="text" name="website" value="{{ old('website') }}" size="40"
                                    placeholder="@lang('website.website')">
                            </div>
                            <div class="flat-wrap-input">
                                <input type="text" name="store" value="{{ old('store') }}" size="40"
                                    placeholder="@lang('website.store')" required>
                                @error('store')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="flat-wrap-input">
                                <input type="text" name="address" value="{{ old('address') }}" size="40"
                                    placeholder="@lang('website.address')" required>
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div><!-- /.flat-wrap-form -->
                        <p class="center">
                            <button type="submit" class="button-form-qoute">@lang('website.send_request')</button>
                        </p>
                    </div><!-- /.form-qoute -->
                </form><!-- /form -->
            </div><!-- /.col-sm-12 -->
            <div class='col-sm-12 col-md-6 floatright'>
               <img src="https://onmap.sa/public/assets/website/images/applications.png"  style="padding-top:15px"    />
            </div>
        </div><!-- /.row -->
    </div><!-- /.container -->
    <div class="overlay"></div>
</section>

<section class="flat-iconbox style1" style="background:#fff;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="flat-row-title  ">
                    <h2>@lang('website.what_we_do')</h2>
                </div>
            </div>
        </div>
        <div class="row ">
             @foreach ($whatWeDo as $whatWeDoRow)
             <div class="col-xs-12 col-md-3 "  >
            <div class="col-xs-12">
                 
                <div class="iconbox style3 center">
                    <div class="iconbox-icon">
                           <img src="{{asset('storage/'.$whatWeDoRow->icon_class)}}" class=" " alt="User Image"
                             >
                    </div>
                    
                           <div class="iconbox-content ">
                        <h3 class="iconbox-title " style="padding-top: 20px;">{{$whatWeDoRow->trans('title')}}</h3>
                         
                     
                         
                    </div>
                     
                 
                    <div class="clearfix">

                    </div>
                </div>
                
 
            </div>
        </div>
          @endforeach
        </div>
        <div class="row">
            <div class="col-md-12 ">
                <div class="height70"></div>
            </div>
        </div>

    </div>
</section><!-- /.flat-icon style1 -->


@endsection
@section('js')
<!-- Revolution Slider -->
<script type="text/javascript" src="{{asset('assets/website/revolution/js/jquery.themepunch.tools.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/website/revolution/js/jquery.themepunch.revolution.min.js')}}">
</script>
<script type="text/javascript" src="{{asset('assets/website/revolution/js/slider.js')}}"></script>
<!-- SLIDER REVOLUTION 5.0 EXTENSIONS  (Load Extensions only on Local File Systems !  The following part can be removed on Server for On Demand Loading) -->
<script type="text/javascript"
    src="{{asset('assets/website/revolution/js/extensions/revolution.extension.actions.min.js')}}"></script>
<script type="text/javascript"
    src="{{asset('assets/website/revolution/js/extensions/revolution.extension.carousel.min.js')}}"></script>
<script type="text/javascript"
    src="{{asset('assets/website/revolution/js/extensions/revolution.extension.kenburn.min.js')}}"></script>
<script type="text/javascript"
    src="{{asset('assets/website/revolution/js/extensions/revolution.extension.layeranimation.min.js')}}"></script>
<script type="text/javascript"
    src="{{asset('assets/website/revolution/js/extensions/revolution.extension.migration.min.js')}}"></script>
<script type="text/javascript"
    src="{{asset('assets/website/revolution/js/extensions/revolution.extension.navigation.min.js')}}"></script>
<script type="text/javascript"
    src="{{asset('assets/website/revolution/js/extensions/revolution.extension.parallax.min.js')}}"></script>
<script type="text/javascript"
    src="{{asset('assets/website/revolution/js/extensions/revolution.extension.slideanims.min.js')}}"></script>
<script type="text/javascript"
    src="{{asset('assets/website/revolution/js/extensions/revolution.extension.video.min.js')}}"></script>
@endsection
