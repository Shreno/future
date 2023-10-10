@extends('layouts.master')
@section('pageTitle', 'الطلبات')
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

  @if (in_array('add_dailyReport', $permissionsTitle))

  @include('layouts._header-index', ['title' => 'تقرير', 'iconClass' => 'fa-black-tie', 'addUrl' => route('DailyReport.create'), 'multiLang' => 'false'])

  @endif
  

 
<style>
    /*div#example1_paginate{*/
    /*    display:block!important;*/
    /*}*/
    .paging_simple_numbers {
    display: block !important;
}
</style>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="nav-tabs-custom">
 
                <div class="tab-content">
                    <div class="active tab-pane" id="filter1">
                        <div class="row text-center">
                            <form action="{{route('DailyReport.index')}}" method="get">
                              <input type="hidden" name="type" value="0">

                                <div class="col-lg-3">
                                    <label>المناديب</label>
                                    <select class="form-control select2" id="delegate_id" name="delegate_id">
                                        <option value="">أختر المندوب</option>
                                        @foreach ($delegates as $delegate)
                                            <option   {{(isset($delegate_id) && ($delegate_id == $delegate->id))? 'selected' : ''}}     value="{{$delegate->id}}">{{$delegate->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                               



                                <div class="col-lg-3">
                                    <label>العملاء</label>
                                    <select id="client_id" class="form-control select2" name="client_id">
                                    
                                    <option value="">أختر العميل</option>
                                        @foreach ($clients as $client)
                                            <option   {{(isset($client_id) && ($client_id == $client->id))? 'selected' : ''}}    value="{{$client->id}}">{{$client->store_name}}</option>
                                        @endforeach
                                    

                                    </select>
                                </div>
                             
                                
                              
                                <div class="col-lg-2">
                                    <label>من</label>
                                    <input type="date" name="from" value="{{(isset($from))? $from :  date('Y-m-d ') }}" class="form-control" >
                                </div>
                                <div class="col-lg-2">
                                    <label>الى</label>
                                    <input type="date" name="to" value="{{(isset($to))? $to :  date('Y-m-d ') }}" class="form-control" >
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group ">
                                        <label>بحث</label>
                                        <input type="submit" value="بحث
                                        " class="btn btn-block btn-primary" />
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                    
                <div class="box">
          <div class="box-header">
            <h3 class="box-title"> </h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <table id="example1" class="table table-bordered table-striped table-hover data_table table-fixed-header responsive no-wrap">
              <thead>
                <tr>
                  <th>#</th>
                  <th>المندوب</th>

                  <th>العميل</th>
                  <th> طلبات المستلمة</th>
                  <th> طلبات تم تسليمها</th>
                  <th>الطلبات المسترجعة</th>
                  <th> المبلغ المتحصل</th>
                  <th>  التاريخ</th>
                  <th>  العمليات</th>



                </tr>
              </thead>
              <tbody>
                  <?php $count = 1 ?>
                @foreach ($reports as $report)
                <tr>
                  <td>{{$count}}</td>
                  <td>{{$report->delegate->name}}</td>

                  <td>{{$report->client->store_name}}</td>
                  <td>{{$report->Recipient}}</td>
                  <td>{{$report->Received}}</td>
                  <td>{{$report->Returned}}</td>
                  <td>{{$report->total}}</td>
                  <td>{{$report->date}}</td>
                  <td>
                  @if (in_array('delete_dailyReport', $permissionsTitle))

                  <form class="pull-right" style="display: inline;"
                                                  action="{{route('DailyReport.destroy', $report->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('هل تريد مسح هذا الصف ?');">
                                                    <i class="fa fa-trash" aria-hidden="true"></i> مسح
                                                </button>
                                            </form>
                                            @endif
                                            @if (in_array('edit_dailyReport', $permissionsTitle))

                                            <a href="{{route('DailyReport.edit', $report->id)}}" title="View" class="btn btn-sm btn-info"
                                               style="margin: 2px;"><i class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">تعديل</span>
                                            </a>
                                            @endif
                  </td>


        
                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                <th>الإجمالى</th>
                  <th>-----</th>

                  <th>------</th>
                  <th> {{$reports->sum('Recipient')}}</th>
                  <th> {{$reports->sum('Received')}} </th>
                  <th> {{$reports->sum('Returned')}}</th>
                  <th>  {{$reports->sum('total')}}</th>
                  <th>  ------</th>
                  <th>--------</th>
                </tr>
              </tfoot>
            </table>


          </div><!-- /.box-body -->
                  {!! $reports->appends($_GET)->links() !!}

          

        </div><!-- /.box -->
        



                
               
              
                
                    
            </div><!-- /.box -->
        </div><!-- /.col -->
      </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
@section('js')

<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>

<script>
  $(document).ready(function() {

    $(function () {
         $('.select2').select2()
});
} );


</script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="https://jquery-datatables-column-filter.googlecode.com/svn/trunk/media/js/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
<script>
    
    $(document).ready(function() {
        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);

            var arr = [];
            $('input:checkbox:checked').each(function () {
                arr.push($(this).val());
            });
          
            $('#ordersId').val(arr )
            $('#passordersId').val(arr )
        });
        $(".ordersId").on('change',function(){
            var arr = [];
            $('input:checkbox:checked').each(function () {
                arr.push($(this).val());
            });
          
            $('#ordersId').val(arr )
            
            $('#passordersId').val(arr )
            
            
        });
        $(function () {
             $('.select2').select2()
        });
    });
  $(document).ready(function() {
    $('#example1').DataTable( {
        //   "language": {
        //     "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
        // },

        retrieve: true,
        fixedColumns:   true,
        dom: 'Bfrtip',
        direction: "rtl",
        charset: "utf-8",
        direction: "ltr",
         pageLength : 50,
          scrollX: true,
             dom: 'lBfrtip',
   
              buttons: [
           {
               extend: 'print',
               footer: false,
                header: false,   
                title: "RUN SHEET",
                text: "RUN SHEET",
                exportOptions: {
                     stripHtml : false,
                    columns: [0,1,2,3,4,5,6]
                },
                "columnDefs": [
                { "width": "20%", "targets":6 }
              ]
               
              
           },
           
          
           {
               extend: 'excelHtml5',
               footer: false,
               
               exportOptions: {
                    columns: [0,6,7,8,9,10,11,12,13,14,15,16,17,18,19]
                }
           }         
        ],
 
        } );

    } );
</script>

@endsection
