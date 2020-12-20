@extends('admin.master')

@section('title','Quản lý đánh giá')

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
            <h3 class="box-title">Quản lý đánh giá</h3>
          </div>
        <!-- /.box-header -->
        <div class="box-body rev_icheck">
          <table class="table" id="rev_table">
          <thead>
            <tr>
              <th>Tên sản phẩm</th>
              <th>Tên khách hàng</th>
              <th>Nội dung</th>
              <th>Số sao</th>
              <th>Trạng thái</th>
              <th>Ngày tạo</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            @foreach($listRev as $rev)
            <tr>
              <td>{{ $rev->proName }}</td>
              <td>{{ $rev->cusName }}</td>
              <td>
                @if(strlen($rev->content) > 20)
                {{substr($rev->content,0,20)}}...
                @else
                {{$rev->content}}
                @endif
              </td>
              <td>
                @for($i = 0;$i < $rev->rating;$i++)
                <span class="good" style="color: #ffba00;font-size: 20px;"><i class="fa fa-star"></i></span>
                @endfor
              </td>
              <td>
                <input data-id="{{$rev->id}}" class="toggle-class" type="checkbox" data-onstyle="primary" data-offstyle="default" data-toggle="toggle" data-on="Hiển thị" data-off="Ẩn" {{ $rev->status ? 'checked' : '' }}>
              </td>
              <td>{{ date('d-m-Y',strtotime($rev->created_at)) }}</td>
              <td>
                <a href="" class="btn btn-success edit" id="{{ $rev->id }}"><i class="fa fa-eye"></i></a>
                @if($rolePermission->contains('review-delete'))
                <a href="" class="btn btn-danger delete" id="{{ $rev->id }}"><i class="fa fa-remove"></i></a>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
              <tr>
                <th rowspan="1" colspan="1">Tên sản phẩm</th>
                <th rowspan="1" colspan="1">Tên khách hàng</th>
                <th rowspan="1" colspan="1">Nội dung</th>
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
        <h4 class="modal-title">
          Đánh giá của
          <strong class="cusName"></strong>
          về sản phẩm
          <strong class="proName"></strong>
        </h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" role="form" id="form_demo">
          <div class="form-group">
            <label for="" class="control-label">Nội dung</label>
            <span class="form-control" id="content" style="width: auto !important;height: auto !important;"></span>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>
          </div>
        </form>
      </div>
      
    </div>
  </div>
</div>
@stop()
@section('js')
<script>
  $('#rev_table').DataTable();
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
        url: "review/"+id,
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
        url: "review/"+id,
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

    $(document).on('click','.edit',function(event){
      event.preventDefault();
      var id = $(this).attr('id');
      $.ajax({
        url: "review/"+id+"/edit",
        dataType: "json",
        success:function(html){
         $('.cusName').text(html.data.cusName);
         $('.proName').text(html.data.proName);
          $('#content').text(html.data.content);
          $('#myModal').modal('show');
        }
      });
    });

</script>
@stop()
