@extends('admin.master')

@section('title','Quản lý tài khoản')

<?php 
$name = Auth::user()->getRoleNames();
$id = \Spatie\Permission\Models\Role::whereIn('name',$name)->pluck('id');
$rolePermission = \Spatie\Permission\Models\Permission::join('role_has_permissions','role_has_permissions.permission_id','=','permissions.id')->whereIn('role_has_permissions.role_id',$id)->pluck('name');
?>
@if($rolePermission->contains('user-create'))
@section('search-add')
  <div class="panel-body">
    <form action="" method="POST" class="form-inline" role="form">
      <a href="" class="btn btn-success" id="users_add">Thêm mới</a>
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
              <h3 class="box-title">Quản lý tài khoản quản trị</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="users_table">
                <thead>
                <tr>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Ngày tạo</th>
                    <th>hành động</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($data as $key => $user)
                    <tr>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->email }}</td>
                      <td>
            						@if(!empty($user->getRoleNames()))
            							@foreach($user->getRoleNames() as $v)
            								<label class="badge badge-success">{{ $v }}</label>
            							@endforeach
            						@endif
                      </td>
                      <td>{{ date('d-m-Y',strtotime($user->created_at)) }}</td>
                      <td>
                          <a href="{{ route('users.show',['user'=>$user->id]) }}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                          @if($rolePermission->contains('user-edit'))
                          <a href="{{ route('users.edit',['user' => $user->id]) }}" class="btn btn-primary edit" id="{{ $user->id }}"><i class="fa fa-edit"></i></a>
                          @endif
                          @if($rolePermission->contains('user-delete'))
                          <a href="" class="btn btn-danger delete" id="{{ $user->id }}"><i class="fa fa-remove"></i></a>
                          @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th rowspan="1" colspan="1">Tên</th>
                    <th rowspan="1" colspan="1">Email</th>
                    <th rowspan="1" colspan="1">Vai trò</th>
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
            <label for="name" class="control-label">Tên tài khoản</label>
            <input type="text" class="form-control" id="name" name="name">
          </div>
          <div class="form-group">
            <label for="email" class="control-label">Email</label>
            <input type="text" class="form-control" id="email" name="email">
          </div>
          <div class="form-group">
            <label for="password" class="control-label">Mật khẩu</label>
            <input type="password" class="form-control" id="password" name="password">
          </div>
          <div class="form-group">
            <label for="confirm_password" class="control-label">Xác nhận mật khẩu</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Vai trò</label>
            <select class="form-control" name="roles" id="role">
            	<option value="">--Chọn vai trò--</option>
	            @foreach($roles as $role)
	            	<option value="{{ $role->name }}">{{ $role->name }}</option>
	            @endforeach
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

@endsection
@section('js')
<script>
    $('#users_table').DataTable();
</script>
<script>
	$('#users_add').on('click',function(event){
        event.preventDefault();
        $('.modal-title').text('Thêm mới tài khoản quản trị');
        $('#form_demo').attr('id', 'form_add');
        $('#form_edit').attr('id', 'form_add');
        $('#name').val('');
        $('#email').val('');
        $('#password').val('');
        $('#role').val('');
        $('#action').text('Thêm');
        $('#action').val('Add');
        $('#myModal').modal('show');
    });

    $(document).on('click','.edit',function(event){
      event.preventDefault();
      var id = $(this).attr('id');
      $.ajax({
        url: "users/"+id+"/edit",
        dataType: "json",
        success:function(html){
          $('.modal-title').text('Chỉnh sửa tài khoản quản trị');
          $('#form_demo').attr('id', 'form_edit');
          $('#form_add').attr('id', 'form_edit');
          $('#name').val(html.data.name);
          $('#email').val(html.data.email);
          $('#pass').val(html.data.password);
          $('#hidden_id').val(html.data.id);
          $('#form_result').html('');
          $('#role option[value="'+html.data.roleName+'"]').prop('selected',true);
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
                url: "users/"+id,
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
        var data = new FormData(this);
        for (var value of data.values()) {
             console.log(value); 
          }
          $.ajax({
              url: "{{ route('users.store') }}",
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
      if ($('#action').val() == 'Edit') {
      var id = $('#hidden_id').val();
      var data = new FormData(this);
      data.append('id',id);
      data.append('_token',$("meta[name='csrf-token']").attr("content"));
      data.append('_method','PUT');
      $.ajax({
        url: "users/"+id,
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
