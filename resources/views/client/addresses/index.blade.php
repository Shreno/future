@extends('layouts.master')
@section('pageTitle', 'Addresses')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  @include('layouts._header-index', ['title' =>  __('app.address'), 'iconClass' => 'fa-map-marker', 'addUrl' => route('addresses.create'), 'multiLang' => 'false'])

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">


        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> </h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>@lang('app.city')</th>
                  <th>@lang('app.phone')</th>
                  <th>@lang('app.address')</th>
                  <th>@lang('app.detials', ['attribute' => ''])</th>
                  <th>@lang('app.control')</th>
                </tr>
              </thead>
              <tbody>
                  <?php $count = 1 ?>
                @foreach ($addresses as $address)
                <tr>
                  <td>{{$count}}</td>
                  <td>{{$address->city->title}}</td>
                  <td>{{$address->phone}}</td>
                  <td>{{$address->address}}</td>
                  <td>{{$address->description}}</td>
                  <td>
                    <a href="{{route('addresses.edit', $address->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">@lang('app.edit')</span></a>

                    <form style="display: inline;" action="{{route('addresses.destroy', $address->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                          <i class="fa fa-trash" aria-hidden="true"></i> @lang('app.delete')
                        </button>
                      </form>
                  </td>
                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                    <th>#</th>
                    <th>@lang('app.city')</th>
                    <th>@lang('app.phone')</th>
                    <th>@lang('app.address')</th>
                    <th>@lang('app.detials', ['attribute' => ''])</th>
                    <th>@lang('app.control')</th>
                </tr>
              </tfoot>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
