@extends('admin.master')

@section('title','Quản lý tin tức')

<?php 
$name = Auth::user()->getRoleNames();
$id = \Spatie\Permission\Models\Role::whereIn('name',$name)->pluck('id');
$rolePermission = \Spatie\Permission\Models\Permission::join('role_has_permissions','role_has_permissions.permission_id','=','permissions.id')->whereIn('role_has_permissions.role_id',$id)->pluck('name');
?>
@if($rolePermission->contains('blog-create'))
@section('search-add')
  <div class="panel-body">
    <form action="" method="POST" class="form-inline" role="form">
      <a href="" class="btn btn-success" id="blog_add">Thêm mới</a>
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
            <h3 class="box-title">Quản lý tin tức</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table class="table" id="blog_table">
              <thead>
                <tr>
                  <th>Tiêu đề</th>
                  <th>Danh mục tin tức</th>
                  <th>Ảnh</th>
                  <th>Trạng thái</th>
                  <th>Ngày tạo</th>
                  <th>Hành động</th>
                </tr>
              </thead>
              <tbody>
                @foreach($listBlog as $blog)
                <tr>
                  <td>{{ $blog->title }}</td>
                  <td>{{ $blog->catalogBlog->name }}</td>
                  <td><img src="{{ url('public') }}/user/img/blog/{{ $blog->imageSrc }}" width="150px" alt=""></td>
                  <td><span class="badge badge-success">{{ $blog->status?"Hiển thị" : "Ẩn" }}</span></td>
                  <td>{{ date('d-m-Y',strtotime($blog->created_at)) }}</td>
                  <td>
                    @if($rolePermission->contains('blog-edit'))
                    <a href="" class="btn btn-success edit" id="{{ $blog->id }}"><i class="fa fa-edit"></i></a>
                    @endif
                    <input type="hidden" name="hidden_name" class="hidden_name" value="{{ $blog->name }}">
                    @if($rolePermission->contains('blog-delete'))
                    <a href="" class="btn btn-danger delete" id="{{ $blog->id }}"><i class="fa fa-remove"></i></a>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th rowspan="1" colspan="1">Tiêu đề</th>
                  <th rowspan="1" colspan="1">Danh mục tin tức</th>
                  <th rowspan="1" colspan="1">Ảnh</th>
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
            <label for="" class="control-label">Tiêu đề</label>
            <input type="text" class="form-control" id="title" name="title">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Ghi chú</label>
            <input type="text" class="form-control" id="notes" name="notes">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Nội dung</label>
            <textarea class="form-control" id="content" name="content"></textarea>
          </div>
          <div class="form-group">
            <label for="" class="control-label">Ảnh</label>
            <img src=""  alt="Avatar" id="imageSrc_recent" class="md-avatar rounded-circle size-4"/>
            <input type="file" name="imageSrc" id="imageSrc" placeholder="Input field">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Danh mục tin tức</label>
            <select name="catalogBlogId" class="form-control" id="catalogBlogId">
              @foreach($catalogBlogs as $catBlog)
              <option value="{{ $catBlog->id }}">{{ $catBlog->name }}</option>
              @endforeach
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
@stop()
@section('js')
<script>
  $('#blog_table').DataTable();
</script>
<script>
  $('#blog_add').on('click',function(event){
    event.preventDefault();
    $('.modal-title').text('Thêm mới tin tức');
    $('#form_demo').attr('id', 'form_add');
    $('#form_edit').attr('id', 'form_add');
    $('#title').val('');
    $('#notes').val('');
    $('#content').val('');
    $('#imageSrc_recent').attr('hidden',true);
    $('#catalogBlogId').val('1');
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
        url: "blog/"+id,
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
        url: "blog/"+id+"/edit",
        dataType: "json",
        success:function(html){
          $('.modal-title').text('Chỉnh sửa tin tức');
          $('#form_demo').attr('id', 'form_edit');
          $('#form_add').attr('id', 'form_edit');
          $('#title').val(html.data.title);
          $('#notes').val(html.data.notes);
          $('#content').val(html.data.content);
          $('#imageSrc_recent').attr('src','{{ url('public') }}/user/img/blog/'+html.data.imageSrc);
          $('#catalogBlogId').val(html.data.catalogBlogId);
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
        url: "{{ route('blog.store') }}",
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
        url: "blog/"+id,
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
