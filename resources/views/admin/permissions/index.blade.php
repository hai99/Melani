@extends('admin.master')

@section('title','Quản lý quyền')
@section('css')
<link rel="stylesheet" type="text/css" href="{{url('/public/admin')}}/css/bootstrap-duallistbox.css">
@stop()
<?php 
$name = Auth::user()->getRoleNames();
$id = \Spatie\Permission\Models\Role::whereIn('name',$name)->pluck('id');
$rolePermission = \Spatie\Permission\Models\Permission::join('role_has_permissions','role_has_permissions.permission_id','=','permissions.id')->whereIn('role_has_permissions.role_id',$id)->pluck('name');
?>

@if($rolePermission->contains('permission-create'))
@section('search-add')
  <div class="panel-body">
    <form action="" method="POST" class="form-inline" role="form">
      <a href="" class="btn btn-success" id="permission_add">Thêm mới</a>
    </form>
  </div>
@stop()
@endif
@section('main')


@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif


<section class="content">
  <div class="row">
      <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Quản lý quyền</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="roles_table">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên quyền</th>
                    <th>Ngày tạo</th>
                    <th>hành động</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($permissions as $key => $permission)
                    <tr>
                      <td>{{ ++$i }}</td>
                      <td>{{ $permission->name }}</td>
                      <td>{{ date('d-m-Y',strtotime($permission->created_at)) }}</td>
                      <td>
                          <a href="" class="btn btn-success"><i class="fa fa-eye"></i></a>
                          @if($rolePermission->contains('permission-edit'))
                          <a href="" class="btn btn-primary edit" id="{{ $permission->id }}"><i class="fa fa-edit"></i></a>
                          @endif
                          @if($rolePermission->contains('permission-edit'))
                          <a href="" class="btn btn-danger delete" id="{{ $permission->id }}"><i class="fa fa-remove"></i></a>
                          @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th rowspan="1" colspan="1">STT</th>
                    <th rowspan="1" colspan="1">Tên quyền</th>
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

<div class="modal" id="myModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" role="form" id="form_demo" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="" class="control-label">Tên quyền</label>
            <input type="text" readonly="true" class="form-control" id="name" name="name">
          </div>
          <div class="form-group">
            <label for="permissionFor" class="control-label">Quyền cho bảng</label>
            <select name="permissionFor" id="permissionFor" class="form-control">
              <option value="">--Chọn quyền cho bảng--</option>
              <option value="category">Danh mục</option>
              <option value="product">Sản phẩm</option>
              <option value="stocks">Kho hàng</option>
              <option value="color">Màu sản phẩm</option>
              <option value="size">Kích cỡ sản phẩm</option>
              <option value="customer">Tài khoản người dùng</option>
              <option value="user">Tài khoản quản trị</option>
              <option value="role">Vai trò của quản trị</option>
              <option value="permission">Quyền của quản trị</option>
              <option value="blog">Tin tức</option>
              <option value="catalogBlog">Danh mục tin tức</option>
              <option value="comment">Bình luận</option>
              <option value="delivery">Hình thức giao hàng</option>
              <option value="payment">Hình thức thanh toán</option>
              <option value="review">Đánh giá</option>
              <option value="wishlist">Danh sách ưa thích</option>
              <option value="order">Đơn hàng</option>
              <option value="banner">Banner</option>
              <option value="file">File</option>
            </select>
          </div>
          <div class="form-group" id="selectPermission">
            <label for="permissionType" class="control-label">Quyền</label>
            <select name="permissionType" id="permissionType" class="form-control">
              <option value="">--Chọn loại quyền--</option>
              <option value="list">Xem danh sách</option>
              <option value="create">Thêm mới</option>
              <option value="edit">Chỉnh sửa</option>
              <option value="delete">Xóa</option>
            </select>
          </div>
          <div class="form-group">
            <span id="form_result"></span>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
          <input type="hidden" name="hidden_id" id="hidden_id">
          <button type="submit" class="btn btn-success" value="" id="action"></button>
          </div>
        </form>
      </div>
      
    </div>
  </div>
</div>

<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: red !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        border: 1px solid white !important;
    }

    .select2-container--default .select2-selection--multiple {
      border-radius: 0 !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        color: black !important;
    }
</style>

@endsection

@section('js')
 <script src="{{url('/public/admin')}}/js/jquery.bootstrap-duallistbox.js"></script>
<script>
    $('#roles_table').DataTable();
</script>
<script>
    $('#permissionFor').on('change',function(event){
      event.preventDefault();
      var value = $(this).val();
      if (value == 'category') {
        $('input[name=name]').val('category-');
      }
      else if (value == 'product') {
        $('input[name=name]').val('product-');
      }
      else if (value == 'stocks') {
        $('input[name=name]').val('stocks-');
      }
      else if (value == 'color') {
        $('input[name=name]').val('color-');
      }
      else if (value == 'size') {
        $('input[name=name]').val('size-');
      }
      else if (value == 'customer') {
        $('input[name=name]').val('customer-');
      }
      else if (value == 'user') {
        $('input[name=name]').val('user-');
      }
      else if (value == 'role') {
        $('input[name=name]').val('role-');
      }
      else if (value == 'permission') {
        $('input[name=name]').val('permission-');
      }
      else if (value == 'blog') {
        $('input[name=name]').val('blog-');
      }
      else if (value == 'catalogBlog') {
        $('input[name=name]').val('catalogBlog-');
      }
      else if (value == 'comment') {
        $('input[name=name]').val('comment-');
      }
      else if (value == 'delivery') {
        $('input[name=name]').val('delivery-');
      }
      else if (value == 'payment') {
        $('input[name=name]').val('payment-');
      }
      else if (value == 'review') {
        $('input[name=name]').val('review-');
      }
      else if (value == 'wishlist') {
        $('input[name=name]').val('wishlist-');
      }
      else if (value == 'order') {
        $('input[name=name]').val('order-');
      }
      else if (value == 'banner') {
        $('input[name=name]').val('banner-');
      }
      else if (value == 'file') {
        $('input[name=name]').val('file-');
      }
      else{
        $('input[name=name]').val('');
      }
    });

    $('#permissionType').on('change',function(event){
      event.preventDefault();
      var value = $(this).val();
      var input = $('#name').val();
      if (input == '') {
        alert('Bạn phải chọn quyền cho bảng trước');
        $(this).val('');
      }
      else{
        var str = $('#permissionFor').val();
        var str1 = str+"-";
        if (value == 'list') {
          $('input[name=name]').val(str1+value);
        }else if (value == 'create') {
          $('input[name=name]').val(str1+value);
        }else if (value == 'edit') {
          $('input[name=name]').val(str1+value);
        }else if (value == 'delete') {
          $('input[name=name]').val(str1+value);
        }else{
          $('input[name=name]').val(str1);
        }
      }
    });

    $('#permission_add').on('click',function(event){
        event.preventDefault();
        $('.modal-title').text('Thêm mới quyền');
        $('#form_demo').attr('id', 'form_add');
        $('#form_edit').attr('id', 'form_add');
        $('#name').val('');
        $('#permissionFor').val('');
        $('#permissionType').val('');
        $('#form_result').text('');
        $('#action').text('Thêm');
        $('#action').val('Add');
        $('#myModal').modal('show');
    });

    $(document).on('click','.edit',function(event){
      event.preventDefault();
      var id = $(this).attr('id');
      $.ajax({
        url: "permissions/"+id+"/edit",
        dataType: "json",
        success:function(html){
          $('.modal-title').text('Chỉnh sửa quyền');
          $('#form_demo').attr('id', 'form_edit');
          $('#form_add').attr('id', 'form_edit');
          $('#name').val(html.data.name);
          $('#hidden_id').val(html.data.id);
          $('#permissionFor').val(html.data1[0]);
          $('#permissionType').val(html.data1[1]);
          $('#form_result').html('');
          $('#action').text('Sửa');
          $('#action').val('Edit');
          $('#myModal').modal('show');
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
                url: "roles/"+id,
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
    
    $('#form_demo').on('submit',function(event){
        event.preventDefault();
        if ($('#action').val() == 'Add') {
            var str = $('#permissionFor').val();
            var str1 = $('#permissionType').val();
            var str2 = str+"-"+str1;
            var data = new FormData(this);
            data.append('str2',str2);
            for (var value of data.values()) {
               console.log(value); 
            }
            $.ajax({
                url: "{{ route('permissions.store') }}",
                method: "POST",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success:function(data){
                    var html = '';
                    if(data.errors){
                        html = '<div class="alert alert-danger">';
                        for(var count = 0;count<data.errors.length;count++){
                          html += '<p>'+data.errors[count]+'</p>';
                        }
                        html +='</div>';
                    }
                    if (data.success) {
                        $('#form_add')[0].reset();
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
                    $('#form_result').html(html);
                }
            });
        }
    });

</script>
@stop()