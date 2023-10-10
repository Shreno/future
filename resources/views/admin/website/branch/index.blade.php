@extends('layouts.master')
@section('pageTitle', 'branches')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  @include('layouts._header-index', ['title' => 'branches', 'iconClass' => 'fa fa-map', 'addUrl' =>
  route('branches.create'), 'multiLang' => 'true'])

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
                  <th>title</th>
                  <th>Address </th>
                  <th>email </th>
                  <th>phone </th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $count = 1 ?>
                @foreach ($branches as $branch)
               
                <tr>
                  <th>{{$count}}</th>

                  <td class="en ">{{$branch->title_en}}</td>
                  <td class="ar ">{{$branch->title_ar}}</td>
                  <td class="en ">{{$branch->address_en}}</td>
                  <td class="ar ">{{$branch->address_ar}}</td>
                  <td>{{$branch->email}}</td>
                  <td>{{$branch->phone}}</td>
                  <td>
                    @if (in_array('edit_branch', $permissionsTitle))
                        
                    <a href="{{route('branches.edit', $branch->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">Edit</span></a>
                    
                    @endif
                    @if (in_array('delete_branch', $permissionsTitle))
                      <form class="pull-right" style="display: inline;" action="{{route('branches.destroy', $branch->id)}}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                            <i class="fa fa-trash" aria-hidden="true"></i> Delete
                          </button>
                        </form>  
                    @endif
                      
                  </td>
                </tr>
                <?php $count++ ?>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th>#</th>
                    <th>title</th>
                    <th>Address </th>
                    <th>email </th>
                    <th>phone </th>
                    <th>Action</th>
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