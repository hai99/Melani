@extends('admin.master')

@section('title','Quản lý vai trò')
@section('css')
<link rel="stylesheet" type="text/css" href="{{url('/public/admin')}}/css/bootstrap-duallistbox.css">
@stop()
<?php 
  $name = Auth::user()->getRoleNames();
  $id = \Spatie\Permission\Models\Role::whereIn('name',$name)->pluck('id');
  $rolePermission = \Spatie\Permission\Models\Permission::join('role_has_permissions','role_has_permissions.permission_id','=','permissions.id')->whereIn('role_has_permissions.role_id',$id)->pluck('name');
?>
@if($rolePermission->contains('role-create'))
@section('search-add')
  <div class="panel-body">
    <form action="" method="POST" class="form-inline" role="form">
      <a href="" class="btn btn-success" id="roles_add">Thêm mới</a>
    </form>
  </div>
@stop()
@section('main')
@endif


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
              <h3 class="box-title">Quản lý vai trò</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="roles_table">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên</th>
                    <th>Ngày tạo</th>
                    <th>hành động</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($roles as $key => $role)
                    <tr>
                      <td>{{ ++$i }}</td>
                      <td>{{ $role->name }}</td>
                      <td>{{ date('d-m-Y',strtotime($role->created_at)) }}</td>
                      <td>
                          <a href="{{ route('roles.show',['role'=>$role->id]) }}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                          @if($rolePermission->contains('role-edit'))
                          <a href="{{ route('roles.edit',['role' => $role->id]) }}" class="btn btn-primary edit" id="{{ $role->id }}"><i class="fa fa-edit"></i></a>
                          @endif
                          @if($rolePermission->contains('role-delete'))
                          <a href="" class="btn btn-danger delete" id="{{ $role->id }}"><i class="fa fa-remove"></i></a>
                          @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th rowspan="1" colspan="1">STT</th>
                    <th rowspan="1" colspan="1">Tên</th>
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
            <label for="" class="control-label">Tên</label>
            <input type="text" class="form-control" id="name" name="name">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Quyền</label>
            <br>
            <select name="permission[]" id="" style="width: 570px !important;" class="permissions form-control select2" id="permission[]" multiple="multiple" >
              <?php foreach($permission as $value):?>
                <option value="{{ $value->id }}">{{ $value->name }}</option>
              <?php endforeach; ?>
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
    
    $('.select-all').click(function () {
    let $select2 = $(this).parent().siblings('.select2')
    $select2.find('option').prop('selected', 'selected')
    $select2.trigger('change')
  })
  $('.deselect-all').click(function () {
    let $select2 = $(this).parent().siblings('.select2')
    $select2.find('option').prop('selected', '')
    $select2.trigger('change')
  })

    $('#roles_add').on('click',function(event){
        event.preventDefault();
        $('.select2').select2();
        $('.modal-title').text('Thêm mới vai trò');
        $('#form_demo').attr('id', 'form_add');
        $('#form_edit').attr('id', 'form_add');
        $('#name').val('');
        $('#form_result').text('');
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
            var data = new FormData(this);
            for (var value of data.values()) {
               console.log(value); 
            }
            $.ajax({
                url: "{{ route('roles.store') }}",
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