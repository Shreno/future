@extends('layouts.master')
@section('pageTitle', 'Add Address')
@section('css')
<link rel="stylesheet" href="{{asset('assets/bower_components/select2/dist/css/select2.min.css')}}">
@endsection
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => __('app.address'), 'type' => __('app.add'), 'iconClass' => 'fa-map-marker', 'url' =>
    route('addresses.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <form action="{{url('admin/clients/address_store')}}" method="POST" class="box  col-md-12"
                style="border: 0px; padding:10px;" >
                @csrf
                <input type="hidden" name="id" value={{$id}}>

                <div class="col-md-12 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">

                        <!-- form start -->

                        <div class="box-body">
                               <div class="form-group">
                                <label for="firstname" class="control-label">@lang('app.address') *</label>

                                <div class="">
                                    <input type="text" name="address" value="{{ old('address') }}" class="form-control"
                                         required>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lastname" class="control-label">@lang('app.city') *</label>
                                <div class="">
                                    <select id="city_id" class="form-control select2" name="city_id" required>
                                        <option value="">@lang('app.select', ['attribute' => __('app.city')])</option>
                                        @foreach ($cities as $city)
                                        <option value="{{$city->id}}">{{$city->title}}</option>
                                        @endforeach

                                    </select>
                                    @error('city_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                             <div class="form-group">
                                <label for="lastname" class="control-label">الحى *</label>
                                <div class="">
                                    <select id="region_id" class="form-control select2" name="region_id" required>
                                      

                                    </select>
                                    @error('region_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                              <div class="form-group">
                                    <label for="firstname" class="control-label">longitude</label>

                                    <div class="">
                                        <input type="text" name="longitude" value="" class="form-control" id="fullname"
                                            placeholder="longitude" required>
                                        @error('longitude')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                                                <div class="form-group">
                                    <label for="firstname" class="control-label">latitude</label>

                                    <div class="">
                                        <input type="text" name="latitude" value="" class="form-control" id="fullname"
                                            placeholder="latitude" required>
                                        @error('longitude')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                         

                            <div class="form-group">
                                <label for="email" class="control-label">@lang('app.detials', ['attribute' => '']) *</label>

                                <div class="">
                                    <textarea name="description" class="form-control" id="inputEmail"
                                 required>{{ old('description') }}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="control-label">@lang('app.phone')</label>

                                <div class="">
                                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" id="phone" >
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div><!-- /.box -->
                </div>

        </div>
        <div class=" footer">
            <button type="submit" class="btn btn-primary">@lang('app.save')</button>
        </div>
        </form> <!-- /.row -->
    </section>
    <!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

@section('js')
<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script>
$(function () {
         $('.select2').select2()
});
</script>

@endsection
