@extends('admin.master')

@section('title','Quản lý màu của sản phẩm')

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

@if($rolePermission->contains('color-create'))
@section('search-add')
  <div class="panel-body">
    <form action="" method="POST" class="form-inline" role="form">
      <a href="" class="btn btn-success" id="color_add">Thêm mới</a>
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
            <h3 class="box-title">Quản lý màu</h3>
          </div>
        <!-- /.box-header -->
        <div class="box-body color_icheck">
          <table class="table" id="color_table">
          <thead>
            <tr>
              <th>
                <button type="button" class="btn btn-default btn-sm checkbox-toggle" ><i class="fa fa-square-o"></i></button>
              </th>
              <th>Tên</th>
              <th>Trạng thái</th>
              <th>Ngày tạo</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            @foreach($listColor as $color)
            <tr>
              <td>
                <input type="checkbox" class="color_checkbox" value="{{ $color->id }}">
              </td>
              <td>{{ $color->name }}</td>
              <td><span class="badge badge-success">{{ $color->status?"Hiển thị" : "Ẩn" }}</span></td>
              <td>{{ date('d-m-Y',strtotime($color->created_at)) }}</td>
              <td>
                @if($rolePermission->contains('color-edit'))
                <a href="" class="btn btn-success edit" id="{{ $color->id }}"><i class="fa fa-edit"></i></a>
                @endif
                <input type="hidden" name="hidden_name" class="hidden_name" value="{{ $color->name }}">
                @if($rolePermission->contains('color-delete'))
                <a href="" class="btn btn-danger delete" id="{{ $color->id }}"><i class="fa fa-remove"></i></a>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
              <tr>
                <th>
                  <button type="button" class="btn btn-default btn-sm clear" data-toggle="tooltip" data-original-title="xóa"><i class="fa fa-trash-o"></i></button>
                </th>
                <th rowspan="1" colspan="1">Tên</th>
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


<div class="modal" id="myModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" role="form" id="form_demo">
          @csrf
          <div class="form-group">
            <label for="" class="control-label">Tên</label>
            <input type="text" class="form-control" id="name" name="name">
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
  $('#color_add').on('click',function(event){
    event.preventDefault();
    $('.modal-title').text('Thêm mới màu');
    $('#form_demo').attr('id', 'form_add');
    $('#form_edit').attr('id', 'form_add');
    $('#name').val('');
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
        url: "color/"+id,
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
        url: "color/"+id+"/edit",
        dataType: "json",
        success:function(html){
          $('.modal-title').text('Chỉnh sửa màu');
          $('#form_demo').attr('id', 'form_edit');
          $('#form_add').attr('id', 'form_edit');
          $('#name').val(html.data.name);
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
        url: "{{ route('color.store') }}",
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
        url: "color/"+id,
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

  $('.clear').on('click',function(event){
    event.preventDefault();
    var id = [];
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
      $('.color_checkbox:checked').each(function(){
                id.push($(this).val());
            });
            if(id.length > 0)
            {
                $.ajax({
                    url:"{{ route('color.clear')}}",
                    method:"POST",
                    data:{'id':id,'_token':token,},
                    success:function(data)
                    {
                        if (data.errors) {
                          alert(data.errors);
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
            }
            else
            {
                swal("Bạn phải chọn ít nhất một bản ghi để xóa");
            }
    }else {
      swal("Đã hủy xóa!");
    }
    });
  });
</script>

<script src="http://localhost:88/project/public/admin/bower_components/fastclick/lib/fastclick.js"></script>
<!-- iCheck -->
<script src="http://localhost:88/project/public/admin/plugins/iCheck/icheck.min.js"></script>


<script>
  $(function () {
    //Enable iCheck plugin for checkboxes
    //iCheck for checkbox and radio inputs
    $('.color_icheck input[type="checkbox"]').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });

    //Enable check and uncheck all functionality
    $(".checkbox-toggle").click(function () {
      var clicks = $(this).data('clicks');
      if (clicks) {
        //Uncheck all checkboxes
        $(".color_icheck input[type='checkbox']").iCheck("uncheck");
        $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
      } else {
        //Check all checkboxes
        $(".color_icheck input[type='checkbox']").iCheck("check");
        $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
      }
      $(this).data("clicks", !clicks);
    });
  });
</script>
<!-- AdminLTE for demo purposes -->
<script src="http://localhost:88/project/public/admin/dist/js/demo.js"></script>
@stop()
