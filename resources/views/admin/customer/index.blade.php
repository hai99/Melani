@extends('admin.master')

@section('title','Quản lý tài khoản người dùng')

<?php 
$name = Auth::user()->getRoleNames();
$id = \Spatie\Permission\Models\Role::whereIn('name',$name)->pluck('id');
$rolePermission = \Spatie\Permission\Models\Permission::join('role_has_permissions','role_has_permissions.permission_id','=','permissions.id')->whereIn('role_has_permissions.role_id',$id)->pluck('name');
?>

@if($rolePermission->contains('customer-create'))
@section('search-add')
  <div class="panel-body">
    <form action="" method="POST" class="form-inline" role="form">
      <a href="" class="btn btn-success" id="cus_add">Thêm mới</a>
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
            <h3 class="box-title">Quản lý tài khoản người dùng</h3>
          </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table" id="color_table">
          <thead>
            <tr>
              <th>Tên</th>
              <th>Email</th>
              <th>Mật khẩu</th>
              <th>Trạng thái</th>
              <th>Ngày tạo</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            @foreach($listCus as $cus)
            <tr>
              <td>{{ $cus->name }}</td>
              <td>{{ $cus->email }}</td>
              <td>{{ $cus->pass }}</td>
              <td><span class="badge badge-success">{{ $cus->status?"Hiển thị" : "Ẩn" }}</span></td>
              <td>{{ date('d-m-Y',strtotime($cus->created_at)) }}</td>
              <td>
                @if($rolePermission->contains('customer-edit'))
                <a href="" class="btn btn-success edit" id="{{ $cus->id }}"><i class="fa fa-edit"></i></a>
                @endif
                @if($rolePermission->contains('customer-delete'))
                <a href="" class="btn btn-danger delete" id="{{ $cus->id }}"><i class="fa fa-remove"></i></a>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
              <tr>
                <th rowspan="1" colspan="1">Tên</th>
                <th rowspan="1" colspan="1">Email</th>
                <th rowspan="1" colspan="1">Mật khẩu</th>
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

    <style>
.md-avatar.size-4 {
  width: 80px;
  height: 80px;
  border-radius: 100%;
}
</style>
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
            <label for="" class="control-label">Tên</label>
            <input type="text" class="form-control" id="name" name="name">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Email</label>
            <input type="text" class="form-control" id="email" name="email">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Số điện thoại</label>
            <input type="text" class="form-control" id="phoneNumber" name="phoneNumber">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Địa chỉ</label>
            <input type="text" class="form-control" id="address" name="address">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Ảnh đại diện</label>
            <img src=""  alt="Avatar" id="avatar_recent" class="md-avatar rounded-circle size-4"/>
            <input type="file" name="avatar" id="avatar" placeholder="Input field">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Mật khẩu</label>
            <input type="text" class="form-control" id="pass" name="pass">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Trạng thái :</label>
            <input type="radio" value="1" name="status" class="status" id="status"> Hiển thị
            <input type="radio" value="0" name="status" class="status" id="status"> Ẩn
          </div>
          <div class="form-group">
            <span id="form_result"></span>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>
          <input type="hidden" name="hidden_id" id="hidden_id">
          <button type="submit" class="btn btn-success" value="" id="action"></button>
          </div>
        </form>
      </div>
      
    </div>
  </div>
</div>
@stop()
@section('js')
<script>
  $('#color_table').DataTable();
</script>
<script>
  $('#cus_add').on('click',function(event){
    event.preventDefault();
    $('.modal-title').text('Thêm mới người dùng');
    $('#form_demo').attr('id', 'form_add');
    $('#form_edit').attr('id', 'form_add');
    $('#name').val('');
    $('#avatar_recent').attr('hidden',true);
    $('#email').val('');
    $('#phoneNumber').val('');
    $('#address').val('');
    $('#pass').val('');
    $('#status').attr('checked',true);
    $('#action').text('Thêm');
    $('#action').val('Add');
    $('#myModal').modal('show');
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
        url: "customer/"+id,
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

     $(document).on('click','.edit',function(event){
      event.preventDefault();
      var id = $(this).attr('id');
      $.ajax({
        url: "customer/"+id+"/edit",
        dataType: "json",
        success:function(html){
          $('.modal-title').text('Chỉnh sửa người dùng');
          $('#form_demo').attr('id', 'form_edit');
          $('#form_add').attr('id', 'form_edit');
          $('#name').val(html.data.name);
          $('#email').val(html.data.email);
          $('#phoneNumber').val(html.data.phoneNumber);
          $('#address').val(html.data.address);
          $('#pass').val(html.data.pass);
          $('#avatar_recent').attr('src','{{ url('public') }}/user/img/avatar/'+html.data.avatar);
          $('#hidden_id').val(html.data.id);
          $('#form_result').html('');
          $('.form-group').find(':radio[name=status][value="'+html.data.status+'"]').prop('checked',true);
          $('#action').text('Sửa');
          $('#action').val('Edit');
          $('#myModal').modal('show');
        }
      });
    });

  $('#form_demo').on('submit',function(event){
    event.preventDefault();
    if ($('#action').val() == 'Add') {
      $.ajax({
        url: "{{ route('customer.store') }}",
        method: "POST",
        data: new FormData(this),
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
    if ($('#action').val() == 'Edit') {
      var id = $('#hidden_id').val();
      var data = new FormData(this);
      data.append('id',id);
      data.append('_token',$("meta[name='csrf-token']").attr("content"));
      data.append('_method','PUT');
      $.ajax({
        url: "customer/"+id,
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
            $('#form_edit')[0].reset();
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
