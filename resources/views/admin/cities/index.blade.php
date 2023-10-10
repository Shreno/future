@extends('layouts.master')
@section('pageTitle', 'Cities')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
 
 
 


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
                  <th>City</th>
                  <th>longitude</th>
                  <th>latitude</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $count = 1 ?>
                @foreach ($cities as $city)
                <tr>
                  <td>{{$count}}</td>
                  <td>{{$city->title}}</td>
                  <td>{{$city->longitude}}</td>
                  <td>{{$city->latitude}}</td>
                  <td>
                    @if (in_array('edit_city', $permissionsTitle))
                     <a href="{{route('cities.edit', $city->id)}}" title="Edit" class="btn btn-sm btn-primary"
                      style="margin: 2px;"><i class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">Edit</span></a>   
                    @endif
                    
                      @if (in_array('delete_city', $permissionsTitle))
                      <form class="pull-right" style="display: inline;" action="{{route('cities.destroy', $city->id)}}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Do you want Delete This Record ?');">
                            <i class="fa fa-trash" aria-hidden="true"></i> Delete
                          </button>
                        </form>  
                      @endif
                      @if (in_array('edit_city', $permissionsTitle))
                     <a href="{{route('regions.city', $city->id)}}" title="Edit" class="btn btn-sm btn-primary"
                      style="margin: 2px;"><i class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">الأحياء</span></a>   
                    @endif
                    
                  </td>
                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th>City</th>
                  <th>longitude</th>
                  <th>latitude</th>
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