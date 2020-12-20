@extends('admin.master')

@section('title','Quản lý danh sách ưa thích')

@section('css')
  <!-- Ionicons -->
  <link rel="stylesheet" href="http://localhost:88/project/public/admin/bower_components/Ionicons/css/ionicons.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="http://localhost:88/project/public/admin/plugins/iCheck/flat/blue.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
@stop()

<?php 
$name = Auth::user()->getRoleNames();
$id = \Spatie\Permission\Models\Role::whereIn('name',$name)->pluck('id');
$rolePermission = \Spatie\Permission\Models\Permission::join('role_has_permissions','role_has_permissions.permission_id','=','permissions.id')->whereIn('role_has_permissions.role_id',$id)->pluck('name');
?>

@section('main')
	<section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Quản lý danh sách ưa thích/h3>
          </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table" id="wish_table">
          <thead>
            <tr>
              <th>Tên sản phẩm</th>
              <th>Tên khách hàng</th>
              <th>Trạng thái</th>
              <th>Ngày tạo</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            @foreach($listWish as $wish)
            <tr>
              <td>{{ $wish->proName }}</td>
              <td>{{ $wish->cusName }}</td>
              <td>
                <input data-id="{{$wish->id}}" class="toggle-class" type="checkbox" data-onstyle="primary" data-offstyle="default" data-toggle="toggle" data-on="Hiển thị" data-off="Ẩn" {{ $wish->status ? 'checked' : '' }}>
              </td>
              <td>{{ date('d-m-Y',strtotime($wish->created_at)) }}</td>
              <td>
                @if($rolePermission->contains('permission-delete'))
                <a href="" class="btn btn-danger delete" id="{{ $wish->id }}"><i class="fa fa-remove"></i></a>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
              <tr>
                <th rowspan="1" colspan="1">Tên sản phẩm</th>
                <th rowspan="1" colspan="1">Tên khách hàng</th>
                <th rowspan="1" colspan="1">Trạng thái</th>
                <th rowspan="1" colspan="1">Ngày tạo</th>
                <th rowspan="1" colspan="1">Hành động</th>
              </tr>
          </tfoot>
         
          </table>
        </div>
        </div>
        <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>

@stop()
@section('js')
<script>
  $('#wish_table').DataTable();
</script>
<script>
  $(document).on('click','.delete',function(event){
    event.preventDefault();
    var id = $(this).attr('id');
    var token = $("meta[name='csrf-token']").attr("content");
    swal({
      title: "Bạn có muốn xóa không?",
      text: "Bấm có để xóa dữ liệu",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Có",
      cancelButtonText: "Không",
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm){
    if (isConfirm) {
      $.ajax({
        url: "wishlist/"+id,
        type: "DELETE",
        data: {"id":id,"_token":token,},
        success:function(data){
          if (data.errors) {
            swal({
              title: data.errors,
              icon: "warning",
              buttons: "Done",
              dangerMode: true,
              })
          }
          if (data.success) {
            location.reload();
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 1000
            });
            Toast.fire({
                type: 'success',
                title: data.success
            });
          }
        }
      });
    }else {
      swal("Đã hủy xóa!");
    }
    });
    });

    $(document).on('change','.toggle-class',function(event){
      event.preventDefault();
      var data = new FormData();
      data.append('status',$(this).prop('checked') == true ? 1 : 0);
      data.append('id',$(this).data('id'));
      data.append('_token',$("meta[name='csrf-token']").attr("content"));
      data.append('_method','PUT');
      // var status = $(this).prop('checked') == true ? 1 : 0;
      var id = $(this).data('id');
      // var token = $("meta[name='csrf-token']").attr("content");
      // var method = "PUT";
      $.ajax({
        url: "wishlist/"+id,
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(data){
          if(data.errors){
            alert(data.erros);
          }
          if (data.success) {
            location.reload();
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 1000
            });
            Toast.fire({
                type: 'success',
                title: data.success
            });
          }
        }
      });
    });


</script>
@stop()
