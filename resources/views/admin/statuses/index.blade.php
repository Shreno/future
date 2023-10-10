@extends('layouts.master')
@section('pageTitle', 'Statuses')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection
@section('css')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <style>
        .toggle.ios, .toggle-on.ios, .toggle-off.ios {
            border-radius: 20px;
        }

        .toggle.ios .toggle-handle {
            border-radius: 20px;
        }
    </style>
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('layouts._header-index', ['title' => 'الحالات', 'iconClass' => 'fa-bookmark-o', 'addUrl' => route('statuses.create'), 'multiLang' => 'false'])

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
                  <th>الحالات</th>
                  <th>التفاصيل</th>
                  <th>إظهار للمندوب</th>
                  <!--<th>إظهار للعميل</th>-->
                  <th>إظهار للمطعم</th>
                  <th>إظهار للمتجر</th>

                  <th>الإجراءات</th>
                </tr>
              </thead>
              <tbody>
                <?php $count = 1 ?>
                @foreach ($statuses as $status)
                <tr>
                  <td style="background-color:{{$status->color}}">{{$count}}</td>
                  <td style="background-color:{{$status->color}}">{{$status->title}}</td>
                  <td style="background-color:{{$status->color}}">{{$status->description}}</td>
                  <td>
                    <input data-id="{{$status->id}}" data-size="mini" class="toggle publish" 
                    {{$status->delegate_appear == 1 ? 'checked' : ''}} data-onstyle="success" type="checkbox" data-style="ios">
                    </td>
      
                    <!-- <td>-->
                    <!--<input data-id="{{$status->id}}" data-size="mini" class="toggle client_appear" -->
                    <!--{{$status->client_appear == 1 ? 'checked' : ''}} data-onstyle="success" type="checkbox" data-style="ios">-->
                    <!--</td>-->
                     <td>
                    <input data-id="{{$status->id}}" data-size="mini" class="toggle restaurant_appear" 
                    {{$status->restaurant_appear == 1 ? 'checked' : ''}} data-onstyle="success" type="checkbox" data-style="ios">
                    </td> <td>
                    <input data-id="{{$status->id}}" data-size="mini" class="toggle shop_appear" 
                    {{$status->shop_appear == 1 ? 'checked' : ''}} data-onstyle="success" type="checkbox" data-style="ios">
                    </td>
                  <td> 
                    @if (in_array('edit_status', $permissionsTitle))
                        
                    <a href="{{route('statuses.edit', $status->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">تعديل</span></a>
                    
                    @endif
                     @if (in_array('delete_status', $permissionsTitle))
                     <form class="pull-right" style="display: inline;" action="{{route('statuses.destroy', $status->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                          <i class="fa fa-trash" aria-hidden="true"></i> حذف
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
                  <th>الحالات</th>
                  <th>التفاصيل</th>
                  <th>إظهار للمندوب</th>
                  <th>إظهار للمطعم</th>
                  <th>إظهار للمتجر</th>
                  <th>الإجراءات</th>
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

@section('js')
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script>
     $('.toggle').bootstrapToggle();
      $(document).on('change','.publish',function(){
        let id = $(this).attr('data-id');
        $.ajax({
            url: '{{url("/admin/delegate_appear")}}',
            type: 'post',
            data: {id: id, _token: "{{csrf_token()}}"},
            success: function (data) {
                //$('.toggle').bootstrapToggle();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

      $(document).on('change','.client_appear',function(){
        let id = $(this).attr('data-id');
        $.ajax({
            url: '{{url("/admin/client_appear")}}',
            type: 'post',
            data: {id: id, _token: "{{csrf_token()}}"},
            success: function (data) {
                //$('.toggle').bootstrapToggle();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
     $(document).on('change','.restaurant_appear',function(){
        let id = $(this).attr('data-id');
        $.ajax({
            url: '{{url("/admin/restaurant_appear")}}',
            type: 'post',
            data: {id: id, _token: "{{csrf_token()}}"},
            success: function (data) {
                //$('.toggle').bootstrapToggle();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }); $(document).on('change','.shop_appear',function(){
        let id = $(this).attr('data-id');
        $.ajax({
            url: '{{url("/admin/shop_appear")}}',
            type: 'post',
            data: {id: id, _token: "{{csrf_token()}}"},
            success: function (data) {
                //$('.toggle').bootstrapToggle();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
  </script>


@endsection