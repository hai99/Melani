@extends('admin.master')

@section('title','Quản lý banner')
<?php 
$name = Auth::user()->getRoleNames();
$id = \Spatie\Permission\Models\Role::whereIn('name',$name)->pluck('id');
$rolePermission = \Spatie\Permission\Models\Permission::join('role_has_permissions','role_has_permissions.permission_id','=','permissions.id')->whereIn('role_has_permissions.role_id',$id)->pluck('name');
?>

@if($rolePermission->contains('banner-create'))
@section('search-add')
  <div class="panel-body">
    <form action="" method="POST" class="form-inline" role="form">
      <a href="" class="btn btn-success" id="banner_add">Thêm mới</a>
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
            <h3 class="box-title">Quản lý banner</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table class="table" id="banner_table">
              <thead>
                <tr>
                  <th>Ảnh</th>
                  <th>Tiêu đề</th>
                  <th>Nội dung</th>
                  <th>Loại</th>
                  <th>Trạng thái</th>
                  <th>Ngày tạo</th>
                  <th>Hành động</th>
                </tr>
              </thead>
              <tbody>
                @foreach($listBanner as $banner)
                <tr>
                  <td><img src="{{ url('public') }}/user/img/banner/{{ $banner->image }}" style="width: 200px;height: 150px" alt=""></td>
                  <td>{{ $banner->title }}</td>
                  <td>{{ $banner->content }}</td>
                  <td>
                    @switch($banner->type)
                      @case(1)
                        <span class="badge badge-default" style="font-size: 15px !important;">Không có tiêu đề</span>
                        @break
                      @case(2)
                        <span class="badge badge-default" style="font-size: 15px !important;">Có tiêu đề</span>
                        @break
                      @default
                    @endswitch
                  </td>
                  <td><span class="badge badge-success">{{ $banner->status?"Hiển thị" : "Ẩn" }}</span></td>
                  <td>{{ date('d-m-Y',strtotime($banner->created_at)) }}</td>
                  <td>
                    @if($rolePermission->contains('banner-edit'))
                    <a href="" class="btn btn-success edit" id="{{ $banner->id }}"><i class="fa fa-edit"></i></a>
                    @endif
                    <input type="hidden" name="hidden_name" class="hidden_name" value="{{ $banner->name }}">
                    @if($rolePermission->contains('banner-delete'))
                    <a href="" class="btn btn-danger delete" id="{{ $banner->id }}"><i class="fa fa-remove"></i></a>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th rowspan="1" colspan="1">Ảnh</th>
                  <th rowspan="1" colspan="1">Tiêu đề</th>
                  <th rowspan="1" colspan="1">Nội dung</th>
                  <th rowspan="1" colspan="1">Loại</th>
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
              <label class="" for="image">Ảnh</label>
             <div class="input-group">
                <input type="text" class="form-control" id="image" name="image" placeholder="Chọn ảnh sản phẩm...">
                <span class="input-group-btn">
                  <a href="#modal-file" data-toggle="modal" class="btn btn-default">Chọn</a>
                </span>
             </div>
             <img src="" id="show_image" alt="" width="50%">
          </div>
          <div class="form-group" id="title_form">
          </div>
          <div class="form-group" id="content_form">
          </div>
          <div class="form-group">
            <label for="" id="type" class="control-label">Loại</label>
            <select class="form-control type" name="type" id="type" onchange="typeChanged(this)">
              <option value=" ">--Chọn loại--</option>
              <option value="1">Không có tiêu đề</option>
              <option value="2">Có tiêu đề</option>
            </select>
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

<div class="modal fade" id="modal-file" role="dialog">
  <div class="modal-dialog" style="width: 85%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Quản lý file</h4>
      </div>
      <div class="modal-body">
        <iframe src="{{ url('file') }}/dialog.php?akey=8H4BxG48c6pyq9lwdUSfCn0kKD0BKkOctrNQZsn73Y&field_id=image" frameborder="0" style="width: 100%;height: 850px;border: 0;overflow-y: auto;"></iframe>
      </div>
    </div>
  </div>
</div>

@stop()
@section('js')
<script>
  $('#banner_table').DataTable();
</script>
<script>
  $('#modal-file').on('hide.bs.modal',function(){
    var image = $('input#image').val();
    $('img#show_image').attr('src',image);
  });

  $('#banner_add').on('click',function(event){
    event.preventDefault();
    $('.modal-title').text('Thêm mới banner');
    $('#form_demo').attr('id', 'form_add');
    $('#form_edit').attr('id', 'form_add');
    $('#image').val('');
    $('#show_image').attr('src','');
    $('#title_form').text('');
    $('#content_form').text('');
    $('.type').val(' ');
    $('#status').attr('checked',true);
    $('#action').text('Thêm');
    $('#action').val('Add');
    $('#myModal').modal('show');
  });

  function typeChanged(obj)
  {
      var message = document.getElementById('title_form');
      var message1 = document.getElementById('content_form');
      var value = obj.value;
      if (value === ' '){
          message.innerHTML = " ";
          message1.innerHTML = " ";
      }
      else if (value === '2'){
          message.innerHTML = "<label for='title' class='control-label'>Tiêu đề</label><input type='text' class='form-control' id='title' name='title'>";
          message1.innerHTML = "<label for='content' class='control-label'>Nội dung</label><textarea type='text' class='form-control' id='content' name='content'></textarea>";
      }
      else if (value === '1'){
          message.innerHTML = " ";
          message1.innerHTML = " ";
      }
  }

  $('#form_demo').on('submit',function(event){
    event.preventDefault();
    if ($('#action').val() == 'Add') {
      $.ajax({
        url: "{{ route('banner.store') }}",
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
      data.append('_token',$("meta[name='csrf-token']").attr("content"));
      data.append('id',id);
      data.append('_method','PUT');
      $.ajax({
        url: "banner/"+id,
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

  $(document).on('click','.edit',function(){
    event.preventDefault();
    var id = $(this).attr('id');
    $.ajax({
      url: "banner/"+id+"/edit",
      dataType: "json",
      success:function(html){
        if(html.data.title !== ''){
          $('.modal-title').text('Chỉnh sửa banner');
          $('#show_image').attr('src',"{{ url('public') }}/user/img/banner/"+html.data.image);
          $('#title_form').html("<label for='title' class='control-label'>Tiêu đề</label><input type='text' class='form-control' id='title' name='title' value="+html.data.title+">");
          $('#content_form').html("<label for='content' class='control-label'>Nội dung</label><textarea type='text' class='form-control' id='content' name='content'>"+html.data.content+"</textarea>");
          $('#type option[value="'+html.data.type+'"]').prop('selected',true);
          $('#hidden_id').val(html.data.id);
          $('#form_demo').attr('id', 'form_edit');
          $('#form_add').attr('id', 'form_edit');
          $('.form-group').find(':radio[name=status][value="'+html.data.status+'"]').prop('checked',true);
          $('#action').text('Sửa');
          $('#action').attr('value', 'Edit');
          $('#form_result').html('');
          $('#myModal').modal('show');
        }
        else{
          $('.modal-title').text('Chỉnh sửa banner');
          $('#show_image').attr('src',"{{ url('public') }}/user/img/banner/"+html.data.image);
          $('#type option[value="'+html.data.type+'"]').prop('selected',true);
          $('#hidden_id').val(html.data.id);
          $('#form_demo').attr('id', 'form_edit');
          $('#form_add').attr('id', 'form_edit');
          $('.form-group').find(':radio[name=status][value="'+html.data.status+'"]').prop('checked',true);
          $('#action').text('Sửa');
          $('#action').attr('value', 'Edit');
          $('#form_result').html('');
          $('#myModal').modal('show');
        }
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
        url: "banner/"+id,
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

 
</script>
@stop()
