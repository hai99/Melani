@extends('admin.master')

@section('title','Đơn hàng chi tiết')

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


@section('main')
	<section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Đơn hàng chi tiết</h3>
          </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table" id="ordet_table">
          <thead>
            <tr>
              <th>Tên sản phẩm</th>
              <th>Số lượng</th>
              <th>Giá</th>
              <th>Tổng giá</th>
              <th>Trạng thái</th>
              <th>Ngày tạo</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <!-- <?php $totalAmount = 0; ?> -->
            @foreach($listOrdet as $ordet)
            <tr>
              <td>{{ $ordet->stock->pro->name }}
                  @if(empty($ordet->stock->color->id) && empty($ordet->stock->size->id))
                      <p>Màu: Không,Cỡ: Không</p>
                  @elseif(empty($ordet->stock->color->id))
                    <p>Màu: Không,Cỡ: {{ $ordet->stock->size->name }}</p>
                  @elseif(empty($ordet->stock->size->id))
                    <p>Màu: {{ $ordet->stock->color->name }},Cỡ: Không</p>
                  @endif
              </td>
              <td>{{ number_format($ordet->quantity) }}</td>
              <td><span class="price">{{ number_format($ordet->price) }}</span> VNĐ</td>
              <td>{{ number_format($ordet->price*$ordet->quantity) }} VNĐ</td>
              <!-- <?php $totalAmount +=  $ordet->price*$ordet->quantity?>
              <input type="hidden" id="hiddenOrderId" value="{{ $ordet->orderId }}">
              <input type="hidden" id="hiddenStockId" value="{{ $ordet->stockId }}"> -->
              <td>
                <input data-id="{{$ordet->id}}" class="toggle-class" type="checkbox" data-onstyle="primary" data-offstyle="default" data-toggle="toggle" data-on="Hiển thị" data-off="Ẩn" {{ $ordet->status ? 'checked' : '' }}>
              </td>
              <td>{{ date('d-m-Y',strtotime($ordet->created_at)) }}</td>
              <td>
                <!-- <a href="" class="btn btn-success edit" id="{{ $ordet->id }}"><i class="fa fa-edit"></i></a> -->
                <a href="" class="btn btn-danger delete" id="{{ $ordet->id }}"><i class="fa fa-remove"></i></a>
              </td>
            </tr>
            @endforeach
            <!-- <input type="text" id="hiddenTotalAmount" name="hiddenTotalAmount" value="{{ $totalAmount }}"> -->
          </tbody>
          <tfoot>
              <tr>
                <th rowspan="1" colspan="1">Tên sản phẩm</th>
                <th rowspan="1" colspan="1">Số lượng</th>
                <th rowspan="1" colspan="1">Giá</th>
                <th rowspan="1" colspan="1">Tổng giá</th>
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


<!-- <div class="modal" id="myModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Chỉnh sửa</h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" role="form" id="form_demo">
          @csrf
          <div class="form-group">
            <label for="" class="control-label">Tên sản phẩm</label>
            <span class="form-control" id="proName"></span>
          </div>
          <div class="form-group">
            <label for="" class="control-label">Số lượng</label>
            <input type="number" class="form-control" id="quantity" name="quantity">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Giá 1 sản phẩm</label>
            <span class="form-control" id="price"></span>
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
            <input type="hidden" name="hidden_id" id="hidden_id">
          <button type="submit" class="btn btn-success" value="" id="action">Sửa</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>
          </div>
        </form>
      </div>
      
    </div>
  </div>
</div> -->
@stop()
@section('js')
<script>
  $('#ordet_table').DataTable();
</script>
<script>
  $(document).on('change','.toggle-class',function(event){
      event.preventDefault();
      var data = new FormData();
      data.append('status',$(this).prop('checked') == true ? 1 : 0);
      data.append('id',$(this).data('id'));
      data.append('_token',$("meta[name='csrf-token']").attr("content"));
      $.ajax({
        url: "{{ route('ordet.changeStatus') }}",
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

  $(document).on('click','.delete',function(event){
    event.preventDefault();
    var id = $(this).attr('id');
    var token = $("meta[name='csrf-token']").attr("content");
    var data = new FormData();
    data.append('id',id);
    data.append('_token',token);
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
        url: "{{ route('ordet.delete') }}",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
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

    


//     $(document).on('change','input[name="quantity"]',function(event){
//     event.preventDefault();
//     var totalAmount = $('input[name="hiddenTotalAmount"]').val();
//       var id = $(this).attr('id');
//       var data = new FormData();
//       data.append('id',id);
//       data.append('quantity',$('input[name="quantity"]').val());
//       data.append('_token',$("meta[name='csrf-token']").attr("content"));
//       data.append('totalAmount',totalAmount);
//       data.append('price',$('.price').text());
//       data.append('orderId',$('#hiddenOrderId').val());
//       data.append('stockId',$('#hiddenStockId').val());
//       for (var value of data.values()) {
//    console.log(value); 
// }
//       $.ajax({
//         url: "{{ route('ordet.update') }}",
//         method: "POST",
//         data: data,
//         cache: false,
//         contentType: false,
//         processData: false,
//         dataType: "json",
//         success:function(data){
//           var html = '';
//           if(data.errors){
//            alert(data.errors);
//           }
//           if (data.success) {
//             location.reload();
//             const Toast = Swal.mixin({
//                 toast: true,
//                 position: 'top-right',
//                 showConfirmButton: false,
//                 timer: 1000
//             });
//             Toast.fire({
//                 type: 'success',
//                 title: data.success
//             });
//           }
//         }
//       });
//     });
</script>
@stop()
