@extends('admin.master')

@section('title','Quản lý đơn hàng')

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
            <div class="col-md-3">
              <h3 class="box-title">Quản lý đơn hàng</h3>
            </div>
            <div class="col-md-9">
              <select name="filterOrder" style="padding: 0px 16px !important;width: 200px !important;font-size: 16px !important;" id="filterOrder" class="form-control">
                <option value="#">---Lọc đơn hàng---</option>
                <option value="0">Đã hủy</option>
                <option value="1">Đang xử lý</option>
                <option value="2">Đang giao</option>
                <option value="3">Đã giao</option>
                <option value="4">Đã nhận</option>
              </select>
            </div>
          </div>
          <div class="box-body">
            <table class="table" id="ord_table">
            <thead>
              <tr>
                <th>Tên người nhận</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
              </tr>
            </thead>
            <tbody id="tbody">
              @foreach($listOrd as $ord)
              <tr>
                <td>{{ $ord->cusName }}</td>
                <td>{{ $ord->phoneNumber }}</td>
                <td>{{ $ord->address }}</td>
                <td>{{ number_format($ord->totalAmount) }} VNĐ</td>
                <td>
                  @switch($ord->status)
                    @case(0)
                      <span class="badge badge-success" style="font-size: 15px !important;">Đã hủy</span>
                      @break
                    @case(1)
                      <span class="badge badge-success" style="font-size: 15px !important;">Đang xử lý</span>
                      @break
                    @case(2)
                      <span class="badge badge-success" style="font-size: 15px !important;">Đang giao hàng</span>
                      @break
                    @case(3)
                      <span class="badge badge-success" style="font-size: 15px !important;">Đã giao</span>
                      @break
                    @case(4)
                      <span class="badge badge-success" style="font-size: 15px !important;">Đã nhận</span>
                      @break
                    @default
                  @endswitch
                </td>
                <td>{{ date('d-m-Y',strtotime($ord->created_at)) }}</td>
                <td>
                  @if($rolePermission->contains('order-detail'))
                  <a href="{{ route('order.show',['order'=>$ord->id]) }}" class="btn btn-primary view" id="{{ $ord->id }}"><i class="fa fa-eye"></i></a>
                  @endif
                  @if($rolePermission->contains('order-edit'))
                  <a href="" class="btn btn-success edit" id="{{ $ord->id }}"><i class="fa fa-edit"></i></a>
                  @endif
                  @if($rolePermission->contains('order-delete'))
                  <a href="" class="btn btn-danger delete" id="{{ $ord->id }}"><i class="fa fa-remove"></i></a>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
                <tr>
                  <th rowspan="1" colspan="1">Tên người nhận</th>
                  <th rowspan="1" colspan="1">Số điện thoại</th>
                  <th rowspan="1" colspan="1">Địa chỉ</th>
                  <th rowspan="1" colspan="1">Tổng tiền</th>
                  <th rowspan="1" colspan="1">Trạng thái</th>
                  <th rowspan="1" colspan="1">Ngày tạo</th>
                  <th rowspan="1" colspan="1">Hành động</th>
                </tr>
            </tfoot>
           
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>


<div class="modal" id="myModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Chỉnh sửa đơn hàng</h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" role="form" id="form_demo">
          @csrf
          <div class="form-group">
            <label for="" class="control-label">Tên người đặt</label>
            <input type="text" class="form-control" id="name" readonly="true" name="name">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Tên người nhận</label>
            <input type="text" class="form-control" id="cusName" name="cusName">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Email người nhận</label>
            <input type="text" class="form-control" id="cusEmail" name="cusEmail">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Địa chỉ</label>
            <input type="text" class="form-control" id="address" name="address">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Hình thức thanh toán</label>
            <select class="form-control" name="paymentId" id="paymentId">
              @foreach($listPay as $pay)
              <option value="{{ $pay->id }}">{{ $pay->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="" class="control-label">Hình thức giao hàng</label>
            <select class="form-control select1" name="deliveryId" id="deliveryId">
              @foreach($listDeli as $deli)
              <option value="{{ $deli->id }}" id="{{ $deli->fee }}">{{ $deli->name }}({{ number_format($deli->fee) }} VNĐ)</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="" class="control-label">Ghi chú</label>
            <input type="text" class="form-control" id="orderNote" name="orderNote">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Tổng tiền</label>
            <span class="form-control" id="totalAmount"></span>
            <input type="hidden" id="oldTotalAmount" value="">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Trạng thái</label>
            <select class="form-control" name="status" id="status">
              <option value="0">Đã hủy</option>
              <option value="1">Đang xử lý</option>
              <option value="2">Đang giao</option>
              <option value="3">Đã giao</option>
              <option value="4">Đã nhận</option>
            </select>
          </div>
          <div class="form-group">
            <span id="form_result"></span>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="hidden_id" id="hidden_id">
          <button type="submit" class="btn btn-success" value="" id="action">Sửa</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
          </div>
        </form>
      </div>
      
    </div>
  </div>
</div>
@stop()
@section('js')
<script>
  $('#ord_table').DataTable();
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
        url: "order/"+id,
        type: "DELETE",
        data: {"id":id,"_token":token,},
        success:function(data){
          if (data.errors) {
            swal({
                title: data.errors,
                text : data.message,
                type : 'error',
                timer : '1500'
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
        url: "order/"+id+"/edit",
        dataType: "json",
        success:function(html){
         $('#name').val(html.data.name);
         $('#cusName').val(html.data.cusName);
         $('#cusEmail').val(html.data.cusEmail);
         $('#address').val(html.data.address);
         $('#totalAmount').text(html.data.totalAmount+' VNĐ');
         $('#oldTotalAmount').val(html.data1);
         $('#paymentId option[value="'+html.data.paymentId+'"]').prop('selected',true);
         $('#deliveryId option[value="'+html.data.deliveryId+'"]').prop('selected',true);
         $('#status option[value="'+html.data.status+'"]').prop('selected',true);
          $('#orderNote').val(html.data.orderNote);
         $('#hidden_id').val(html.data.id);
          $('#myModal').modal('show');
        }
      });
    });

    $('.select1').change(function(event){
        event.preventDefault();
        var data = new FormData();
        var oldTotalAmount = $('#oldTotalAmount').val();
        data.append('_token',$("meta[name='csrf-token']").attr("content"));
        data.append('deliveryId',$('#deliveryId :selected').val());
        data.append('fee',$('#deliveryId :selected').attr('id'));
        data.append('oldTotalAmount',oldTotalAmount);
        for (var value of data.values()) {
   console.log(value); 
}
        $.ajax({
            url: "{{ route('order.fetch_total') }}",
            method: "POST",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(html){
                if (html.data) {
                    $('#totalAmount').text(html.data+' VNĐ');
                }
            }
        });
    });

    $('#form_demo').on('submit',function(event){
    event.preventDefault();
      var id = $('#hidden_id').val();
      var a = $('#totalAmount').text();
      var b = a.search(" VNĐ");
      var totalAmount = a.slice(0, b);
      var data = new FormData(this);
      data.append('id',id);
      data.append('totalAmount',totalAmount);
      data.append('_token',$("meta[name='csrf-token']").attr("content"));
      data.append('_method','PUT');
//       for (var value of data.values()) {
//    console.log(value); 
// }
      $.ajax({
        url: "order/"+id,
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

    $('#filterOrder').on('change',function(event){
      event.preventDefault();
      var data = new FormData();
      data.append('status',$(this).val());
      data.append('_token',$("meta[name='csrf-token']").attr("content"));
      for (var value of data.values()) {
         console.log(value); 
      }
      $.ajax({
        url: "{{ route('order.filter') }}",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(html){
          if (html.data) {
            $('#tbody').html('');
            var string = '';
            for (var i = 0; i < html.data.length; i++) {
              string += '<tr>';
              string += '<td>'+html.data[i].cusName+'</td>';
              string += '<td>'+html.data[i].phoneNumber+'</td>'
              string += '<td>'+html.data[i].address+'</td>';
              string += '<td>'+html.data[i].totalAmount+' VNĐ</td>'
              string += '<td>';
                  switch(html.data[i].status){
                    case 0:
                      string += '<span class="badge badge-success" style="font-size: 15px !important;">Đã hủy</span>';
                      break;
                    case 1:
                      string += '<span class="badge badge-success" style="font-size: 15px !important;">Đang xử lý</span>';
                      break;
                    case 2:
                      string += '<span class="badge badge-success" style="font-size: 15px !important;">Đang giao hàng</span>';
                      break;
                    case 3:
                      string += '<span class="badge badge-success" style="font-size: 15px !important;">Đã giao</span>';
                      break;
                    case 4:
                      string += '<span class="badge badge-success" style="font-size: 15px !important;">Đã nhận</span>';
                      break;
                  }
                string += '</td>';
                string += '<td>'+html.data[i].created_at+'</td>';
                // string += '<td>';
                // string += '<a href="{{ route('order.show',['order'=> '+html.data.id+']) }}" class="btn btn-primary view" id="{{ $ord->id }}"><i class="fa fa-eye"></i></a>';
                // string += '<a href="" class="btn btn-success edit" id="'+html.data.id+'"><i class="fa fa-edit"></i></a>';
                // string += '<a href="" class="btn btn-danger delete" id="'+html.data.id+'"><i class="fa fa-remove"></i></a>';
                // string += '</td>';
              string += '</tr>';
            }
            $('#tbody').html(string);
          }
        }
      });
    });

</script>
@stop()
