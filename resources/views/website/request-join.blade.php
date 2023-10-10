@extends('website.layouts.master')
@section('pageTitle', __('website.request_join'))
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

<section class="flat-request-qoute" style="background: #fff;   padding-top: 50px;
    padding-bottom: 50px;"  >
    <div class="row">
        <div class="col-sm-6">
            <div class="image">
                <img src="https://dammany.engaaz.com/public/assets/website/images/parallax/ass.jpeg"  />
            </div>
        </div><!-- /.col-sm-6 -->
        <div class="col-sm-6">
                <form action="{{route('join.store')}}" method="POST" accept-charset="utf-8">
                        @csrf
                        <div class="form-request-qoute">
                            <div class="request-qoute-title">
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
                    </form><!-- /.form -->
        </div><!-- /.col-sm-6 -->
    </div>
</section>
@endsection