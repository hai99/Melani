@extends('admin.master')

@section('title','Quản lý kho hàng')

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
              <h3 class="box-title">Quản lý kho hàng</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="stock_table" class="table table-hover">
                <thead>
                <tr role="row">
                  <th>Tên sản phẩm</th>
                  <th>Màu</th>
                  <th>Kích cỡ</th>
                  <th>Số lượng</th>
                  <th>Trạng thái</th>
                  <th>Ngày tạo</th>
                  <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($listStocks as $stock)
                  <tr role="row" class="odd">
                      <td>{{ $stock->pro['name'] }}</td>
                      <td>{{ $stock->color['name'] }}</td>
                      <td>{{ $stock->size['name'] }}</td>
                      <td>{{ $stock->importNum }}</td>
                      <td><span class="badge badge-success">{{ $stock->status ? "Hiển thị" : "Ẩn" }}</span></td>
                      <td>{{ date('d-m-Y',strtotime($stock->created_at)) }}</td>
                      <td>
                        @if($rolePermission->contains('stock-edit'))
                        <a href="" class="btn btn-primary edit" id="{{ $stock->id }}"><i class="fa fa-edit"></i></a>
                        @endif
                        @if($rolePermission->contains('stock-delete'))
                        <a href="" class="btn btn-danger delete" id="{{ $stock->id }}"><i class="fa fa-remove"></i></a>
                        @endif
                      </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th rowspan="1" colspan="1">Tên sản phẩm</th>
                    <th rowspan="1" colspan="1">Màu</th>
                    <th rowspan="1" colspan="1">Kích cỡ</th>
                    <th rowspan="1" colspan="1">Số lượng</th>
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
            <label for="name" class="control-label">Tên sản phẩm</label>
            <input type="text" class="form-control" readonly="true" id="name" name="name">
          </div>
          <div class="form-group">
            <label for="colorId" class="control-label">Màu</label>
            <select class="form-control select1" name="colorId" id="colorId">
              @foreach($listColor as $color)
              <option value="{{ $color->id }}">{{ $color->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="sizeId" class="control-label">Kích cỡ</label>
            <select class="form-control select1" name="sizeId" id="sizeId">
              @foreach($listSize as $size)
              <option value="{{ $size->id }}">{{ $size->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="importNum" class="control-label">Số lượng nhập</label>
            <input type="number" class="form-control" id="importNum" name="importNum">
          </div>
          <div class="form-group">
            <label for="importPrice" class="control-label">Giá nhập</label>
            <input type="number" class="form-control" id="importPrice" name="importPrice">
          </div>
          <div class="form-group">
            <label for="exportPrice" class="control-label">Giá xuất</label>
            <input type="number" class="form-control" id="exportPrice" name="exportPrice">
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
          <button type="submit" class="btn btn-success" value="" id="action">Sửa</button>
          </div>
        </form>
      </div>
      
    </div>
  </div>
</div>

@stop()

@section('js')
<script>
  $('#stock_table').DataTable();
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
        url: "stock/"+id,
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
        url: "stock/"+id+"/edit",
        dataType: "json",
        success:function(html){
         $('#name').val(html.data.name);
         $('#importNum').val(html.data.importNum);
         $('#importPrice').val(html.data.importPrice);
         $('#exportPrice').val(html.data.exportPrice);
         $('#colorId option[value="'+html.data.colorId+'"]').prop('selected',true);
         $('#sizeId option[value="'+html.data.sizeId+'"]').prop('selected',true);
         $('.form-group').find(':radio[name=status][value="'+html.data.status+'"]').prop('checked',true);
         $('#hidden_id').val(html.data.id);
          $('#myModal').modal('show');
        }
      });
    });

  $('#form_demo').on('submit',function(event){
    event.preventDefault();
    var id = $('#hidden_id').val();
    var data = new FormData(this);
    data.append('id',id);
    data.append('_token',$("meta[name='csrf-token']").attr("content"));
    data.append('_method','PUT');
    $.ajax({
      url: "stock/"+id,
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
  });
</script>
@stop



