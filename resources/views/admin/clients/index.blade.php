@extends('layouts.master')

@if($work==1)
@section('pageTitle', 'المتاجر')

@elseif($work==2)
@section('pageTitle', 'المطاعم')

@endif
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @if($work==1)
  @if (in_array('add_client', $permissionsTitle))


  @include('layouts._header-index', ['title' => 'متجر', 'iconClass' => 'fa-black-tie', 'addUrl' => route('clients.create',['type'=>$work]), 'multiLang' => 'false'])
  @endif
  @else
  @if (in_array('add_resturant', $permissionsTitle))

    @include('layouts._header-index', ['title' => 'مطعم', 'iconClass' => 'fa-black-tie', 'addUrl' => route('clients.create',['type'=>$work]), 'multiLang' => 'false'])
@endif
  
  @endif
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">


        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> </h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <table id="example1" class="table   table-striped   data_table     ">
              <thead>
                <tr>
                  <th>#</th>
                  <th>الصورة</th>
                  <th>الاسم</th>
                  <th>العميل</th>
                  <th>البريد الالكترونى</th>
                  <th>رقم الجوال</th>
                  <th>الإجراءات</th>
                </tr>
              </thead>
              <tbody>
                  <?php $count = 1 ?>
                @foreach ($clients as $client)
                <tr>
                  <td>{{$count}}</td>
                  <td><img class="img-circle" src="{{asset('storage/'.$client->avatar)}}" height="75" width="75"></td>
                  <td>{{$client->name}}</td>
                  <td>{{$client->store_name}}</td>
                  <td>{{$client->email}}</td>
                  <td>{{$client->phone}}</td>
                  <td>
                  @if($work==1)

                    @if (in_array('show_client', $permissionsTitle))
                   

                    <a href="{{route('clients.show', $client->id)}}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-eye"></i> <span class="hidden-xs hidden-sm">مشاهده</span> </a>
                    @endif
                     @if (in_array('show_client', $permissionsTitle))
                    <a href="{{url('admin/clients/address/'. $client->id.'')}}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-location"></i> <span class="hidden-xs hidden-sm">الفروع</span> </a>
                    @endif
                    
                      @if (in_array('edit_client', $permissionsTitle))
                       <a href="{{route('clients.edit', $client->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">تعديل</span></a>   
                      @endif
                    
                    @if (in_array('delete_client', $permissionsTitle))
                     <form class="pull-right" style="display: inline;" action="{{route('clients.destroy', $client->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                          <i class="fa fa-trash" aria-hidden="true"></i> حذف
                        </button>
                      </form>   
                    @endif
                    @else

                    @if (in_array('show_resturant', $permissionsTitle))
                   

                    <a href="{{route('clients.show', $client->id)}}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-eye"></i> <span class="hidden-xs hidden-sm">مشاهده</span> </a>
                    @endif
                     @if (in_array('show_resturant', $permissionsTitle))
                    <a href="{{url('admin/clients/address/'. $client->id.'')}}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-location"></i> <span class="hidden-xs hidden-sm">الفروع</span> </a>
                    @endif
                    
                      @if (in_array('edit_resturant', $permissionsTitle))
                       <a href="{{route('clients.edit', $client->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">تعديل</span></a>   
                      @endif
                    
                    @if (in_array('delete_resturant', $permissionsTitle))
                     <form class="pull-right" style="display: inline;" action="{{route('clients.destroy', $client->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                          <i class="fa fa-trash" aria-hidden="true"></i> حذف
                        </button>
                      </form>   
                    @endif




                    @endif
                    
                  </td>
                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                 <th>#</th>
                  <th>الصورة</th>
                  <th>الاسم</th>
                  <th>العميل</th>
                  <th>البريد الالكترونى</th>
                  <th>رقم الجوال</th>
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
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example1').DataTable( {
                //   "language": {
                //     "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
                // },
             scrollX: true,
                retrieve: true,
                fixedColumns:   true,
                dom: 'Bfrtip',
                direction: "rtl",
                charset: "utf-8",
                direction: "ltr",
                pageLength : 50,
                dom: 'lBfrtip',
                buttons: [

                    'excel', 'print'
                ]
            } );
        } );
    </script>
@endsection