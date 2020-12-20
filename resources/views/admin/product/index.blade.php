@extends('admin.master')

@section('title','Quản lý sản phẩm')

<?php 
$name = Auth::user()->getRoleNames();
$id = \Spatie\Permission\Models\Role::whereIn('name',$name)->pluck('id');
$rolePermission = \Spatie\Permission\Models\Permission::join('role_has_permissions','role_has_permissions.permission_id','=','permissions.id')->whereIn('role_has_permissions.role_id',$id)->pluck('name');
?>

@if($rolePermission->contains('product-create'))
@section('search-add')
  <div class="panel-body">
    <form action="" method="POST" class="form-inline" role="form">
      @can('product-create')
      <a href="{{ route('product.create') }}" class="btn btn-success" >Thêm mới</a>
      @endcan
    </form>
  </div>
@stop()
@endif

@section('main')
	
<section class="content">
  <div class="row">
      <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Quản lý sản phẩm</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="pro_table">
                <thead>
                <tr role="row">
                	<th>Tên sản phẩm</th>
                	<th>Tên danh mục</th>
                  <th>Trạng thái</th>
                	<th>Ngày tạo</th>
                	<th>hành động</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($listPro as $pro)
                    <tr>
                      <td>{{ $pro->name }}</td>
                      <td>{{ $pro->cat->name }}</td>
                      <td>
                        <input data-id="{{$pro->id}}" class="toggle-class" type="checkbox" data-onstyle="primary" data-offstyle="default" data-toggle="toggle" data-on="Hiển thị" data-off="Ẩn" {{ $pro->status ? 'checked' : '' }}>
                      </td>
                      <td>{{ date('d-m-Y',strtotime($pro->created_at)) }}</td>
                      <td>
                          <a href="{{ route('product.show',['product'=>$pro->id]) }}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                          @if($rolePermission->contains('product-edit'))<a href="{{ route('product.edit',['product' => $pro->id]) }}" class="btn btn-primary edit" id="{{ $pro->id }}"><i class="fa fa-edit"></i></a>
                          @endif
                          @if($rolePermission->contains('product-delete'))
                          <a href="" class="btn btn-danger delete" id="{{ $pro->id }}"><i class="fa fa-remove"></i></a>
                          @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                  	<th rowspan="1" colspan="1">Tên sản phẩm</th>
                  	<th rowspan="1" colspan="1">Tên danh mục</th>
                    <th rowspan="1" colspan="1">Trạng thái</th>
                  	<th rowspan="1" colspan="1">Ngày tạo</th>
                  	<th rowspan="1" colspan="1">Hành động</th>
                  </tr>
                </tfoot>
              </table>
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
<script src="{{url('/public/admin')}}/js/slug.js"></script>
<script src="{{url('/public/admin')}}/tinymce/tinymce.min.js"></script>
<script src="{{url('/public/admin')}}/tinymce/config.js"></script>

<script>
  $('#pro_table').DataTable();

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
        url: "product/"+id,
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
        url: "product/"+id,
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
      $.ajax({
        url: "{{ route('product.changeStatus') }}",
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
@stop
