@extends('layouts.master')
@section('pageTitle', 'Edit settings')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('layouts._header-form', ['title' => 'settings', 'type' => 'Edit', 'iconClass' => 'fa fa-cog', 'url' =>
  route('settings.edit'), 'multiLang' => 'flase'])

  <!-- Main content -->

  <section class="content ">
    <div class="row">
      <div class="col-md-12">
        <!-- Custom Tabs -->
        <form action="{{route('settings.update')}}" method="post" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#Site" data-toggle="tab">Site</a></li>
              <li><a href="#SocialMedia" data-toggle="tab">Social Media</a></li>
              <li><a href="#Information" data-toggle="tab">Information</a></li>
              <li><a href="#AboutPage" data-toggle="tab">About Page</a></li>
              <li><a href="#shippingPage" data-toggle="tab">Shipping Page</a></li>
            </ul>
            <div class="tab-content">
              <!-- /.tab-pane -->
              <div class="tab-pane active" id="Site">
                <div class="form-group">
                  <label for="exampleInputEmail1"> Site Logo </label>
                  <img src="{{asset('storage/'.$settings->logo)}}" class="img-responsive" alt="Admin Icon Image"
                    width="120">
                  <input type="file" name="logo" class="form-control" id="exampleInputEmail1">
                  @error('logo')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                  <hr>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Title En</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" value="{{$settings->title_en}}"
                    name="title_en" placeholder="Title En" required>
                    @error('title_en')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"> </label>
                  <input type="text" class="form-control" id="exampleInputEmail1" value="{{$settings->title_ar}}"
                    name="title_ar" placeholder="Title Ar " required>
                    @error('title_ar')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1"> Description En </label>
                  <textarea class="form-control" name="description_en">{{$settings->description_en}}</textarea>
                  <hr>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"> Description AR </label>
                  <textarea class="form-control" name="description_ar">{{$settings->description_ar}}</textarea>
                  <hr>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">longitude </label>
                  <input type="text" class="form-control" value="{{$settings->longitude}}" name="longitude"
                    id="exampleInputEmail1" placeholder="longitude">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">latitude </label>
                  <input type="text" class="form-control" value="{{$settings->latitude}}" name="latitude"
                    id="exampleInputEmail1" placeholder="latitude">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Google Analytics Tracking ID </label>
                  <input type="text" class="form-control" id="exampleInputEmail1"
                    value="{{$settings->google_analytics_id}}" name="google_analytics_id"
                    placeholder="Google Analytics Tracking ID">
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="SocialMedia">
                <div class="form-group">
                  <label for="exampleInputEmail1">Facebook </label>
                  <input type="text" class="form-control" value="{{$settings->facebook}}" name="facebook"
                    id="exampleInputEmail1" placeholder="Facebook">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Instgram </label>
                  <input type="text" class="form-control" value="{{$settings->instgram}}" name="instgram"
                    id="exampleInputEmail1" placeholder="Instgram">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Twitter </label>
                  <input type="text" class="form-control" value="{{$settings->twitter}}" name="twitter"
                    id="exampleInputEmail1" placeholder="Twitter">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Youtube </label>
                  <input type="text" class="form-control" value="{{$settings->youtube}}" name="youtube"
                    id="exampleInputEmail1" placeholder="Youtube">
                </div>
              </div>
              <div class="tab-pane" id="Information">
                <div class="form-group">
                  <label for="exampleInputEmail1">Address En </label>
                  <input type="text" class="form-control" value="{{$settings->address_en}}" name="address_en"
                    id="exampleInputEmail1" placeholder="Address En">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Address Ar </label>
                  <input type="text" class="form-control" value="{{$settings->address_ar}}" name="address_ar"
                    id="exampleInputEmail1" placeholder="Address Ar ">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">email </label>
                  <input type="text" class="form-control" value="{{$settings->email}}" name="email"
                    id="exampleInputEmail1" placeholder="email">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">phone </label>
                  <input type="text" class="form-control" value="{{$settings->phone}}" name="phone"
                    id="exampleInputEmail1" placeholder="phone ">
                </div>

              </div>
              <div class="tab-pane" id="AboutPage">
                <div class="form-group">
                  <label for="exampleInputEmail1">about title en </label>
                  <input type="text" class="form-control" value="{{$settings->about_title_en}}" name="about_title_en"
                    id="exampleInputEmail1" placeholder="About us" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">about title ar </label>
                  <input type="text" class="form-control" value="{{$settings->about_title_ar}}" name="about_title_ar"
                    id="exampleInputEmail1" placeholder="عن الشركة" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">about description en </label>
                  <textarea class="form-control" name="about_description_en"
                    required>{{$settings->about_description_en}}</textarea>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">about description ar </label>
                  <textarea class="form-control" name="about_description_ar"
                    required>{{$settings->about_description_ar}}</textarea>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"> image </label>
                  <img src="{{asset('storage/'.$settings->image)}}" class="img-responsive" alt="image " width="120">
                  <input type="file" name="image" class="form-control" id="exampleInputEmail1">
                  @error('image')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                  <hr>
                </div>
              </div>
              
              
              <div class="tab-pane" id="shippingPage">
                <div class="form-group">
                  <label for="exampleInputEmail1">Standard Weight </label>
                  <input type="text" class="form-control" value="{{$settings->standard_weight}}" name="standard_weight"
                    id="exampleInputEmail1" placeholder="الوزن المثالي للشحن" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Overweight Price </label>
                  <input type="text" class="form-control" value="{{$settings->overweight_price}}" name="overweight_price"
                    id="exampleInputEmail1" placeholder="سعر الوزن الزائد " required>
                </div>
               
                  <hr>
                </div>
              </div>
              
              
              
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
          <div class=" footer">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>

    </div>

    <!-- /.row -->
  </section>
  <!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection