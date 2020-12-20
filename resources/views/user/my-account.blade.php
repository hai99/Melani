
@extends('user/master')
@section('title','Tài khoản')
@section('main')
    
    <style>
.md-avatar.size-4 {
  width: 110px;
  height: 110px;
  margin-bottom: 50px;
}
</style>
<!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ </a></li>
                                <li class="breadcrumb-item active" aria-current="page">Tài khoản</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->
    <!-- page main wrapper start -->
    @if (Session::has('customer'))
    <main>
        <!-- my account wrapper start -->
        <div class="my-account-wrapper pt-100 pb-100 pt-sm-58 pb-sm-58">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- My Account Page Start -->
                        <div class="myaccount-page-wrapper">
                            <!-- My Account Tab Menu Start -->
                            <div class="row">
                                <div class="col-lg-3 col-md-4">
                                    <div class="myaccount-tab-menu nav" role="tablist">
                                        <a href="#dashboad" class="active" data-toggle="tab"><i class="fa fa-dashboard"></i>
                                            Tài khoản</a>
                                        <a href="#orders" data-toggle="tab"><i class="fa fa-cart-arrow-down"></i> Đơn hàng</a>
                                        <a href="#payment-method" data-toggle="tab"><i class="fa fa-credit-card"></i> Phương thức thanh toán</a>
                                        <a href="#address-edit" data-toggle="tab"><i class="fa fa-map-marker"></i> địa chỉ</a>
                                        <a href="#change-pass" data-toggle="tab"><i class="fa fa-shield"></i> đổi mật khẩu</a>
                                        <a href="#account-info" data-toggle="tab" ><i class="fa fa-user"></i> Thông tin tài khoản</a>
                                    </div>
                                </div>
                                <!-- My Account Tab Menu End -->
        
                                <!-- My Account Tab Content Start -->
                                <div class="col-lg-9 col-md-8">
                                    <div class="tab-content" id="myaccountContent">
                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h3>Chào mừng!</h3>
                                                <div class="welcome">
                                                    <p>Hello, <strong>{{ $customer->name }}</strong> </p>
                                                    <img src="{{ url('public') }}/user/img/avatar/{{ $customer->avatar }}" alt="Avatar" class="md-avatar rounded-circle size-4"/>
                                                    <form method="POST" id="upload_form" enctype="multipart/form-data">
                                                        @csrf
                                                        <legend>Đổi ảnh đại diện:</legend>
                                                        <div class="single-input-item">
                                                            <input type="file" name="avatar" id="avatar" placeholder="Input field">
                                                        </div>
                                                        <div class="single-input-item">
                                                        <span id="form_upload_result"></span>
                                                        </div>
                                                        <div class="single-input-item">
                                                        <button type="submit" class="check-btn sqr-btn">Đổi</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Single Tab Content End -->
        
                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade" id="orders" role="tabpanel">
                                            @if(count($orders) > 0)
                                            <div class="myaccount-content">
                                                <h3>Các đơn hàng của bạn</h3>
                                                <div class="myaccount-table table-responsive text-center">
                                                    <table class="table table-bordered">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>Mã đơn hàng</th>
                                                                <th>Ngày đặt</th>
                                                                <th>Trạng thái</th>
                                                                <th>Tổng tiền</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($orders as $order)
                                                            <tr>
                                                                <td>{{$order->id}}</td>
                                                                <td>{{$order->created_at->format('d-m-Y')}}</td>
                                                                <td>
                                                                    @switch($order->status)
                                                                        @case(1)
                                                                            <span class="badge badge-default" style="padding: 15px;font-size: 14px;">Đang xử lý</span>
                                                                            @break
                                                                        @case(2)
                                                                            <span class="badge badge-default" style="padding: 15px;font-size: 14px;">Đang giao</span>
                                                                            @break
                                                                        @case(3)
                                                                            <span class="badge badge-default" style="padding: 15px;font-size: 14px;">Đã giao</span>
                                                                            @break
                                                                        @case(4)
                                                                            <span class="badge badge-default" style="padding: 15px;font-size: 14px;">Đã nhận</span>
                                                                            @break
                                                                        @default
                                                                    @endswitch

                                                                </td>
                                                                <td>{{ number_format($order->totalAmount) }} VNĐ</td>
                                                                <td><a href="" class="check-btn sqr-btn view_order" id="{{ $order->id }}" >Xem</a></td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            @else
                                            <h2>Bạn chưa có đơn hàng nào</h2>
                                            <h3><a href="{{ route('all-products') }}">Mua hàng ngay!</a></h3>
                                            @endif
                                        </div>
                                        <!-- Single Tab Content End -->
                                        <div class="modal fade" id="modal_order_detail">
                                          <div class="modal-dialog" role="document">
                                            <div class="modal-content" style="width: 700px;">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Chi tiết đơn hàng</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th class="pro-title">Tên sản phẩm</th>
                                                        <th class="pro-title">Kích cỡ</th>
                                                        <th class="pro-title">Màu</th>
                                                        <th class="pro-price">Giá</th>
                                                        <th class="pro-quantity">Số lượng</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="table_body">
                                                    </tbody>
                                                </table>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade" id="payment-method" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h3>Payment Method</h3>
                                                <p class="saved-message">Thanh toán trực tiếp</br>Chuyển khoản qua tài khoản ngân hàng</p>
                                            </div>
                                        </div>
                                        <!-- Single Tab Content End -->
        
                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade" id="address-edit" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h3>Địa chỉ giao hàng</h3>
                                                <address>
                                                    <p><strong>{{$customer->name}}</strong></p>
                                                    <p>{{$customer->address}}</p>
                                                    <p>Số điện thoại: {{$customer->phoneNumber}}</p>
                                                </address>
                                            </div>
                                        </div>
                                        <!-- Single Tab Content End -->

                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade" id="change-pass" role="tabpanel">
                                            <div class="myaccount-content">
                                                <form action="#" id="form_change_pass" method="POST">
                                                    @csrf
                                                    <fieldset>
                                                        <h3>Đổi mật khẩu</h3>
                                                        <div class="single-input-item">
                                                            <label for="old_pass" class="required">Mật khẩu hiện tại</label>
                                                            <input type="password" name="old_pass" placeholder="Nhập mật khẩu hiện tại..." />
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="new_pass" class="required">Mật khẩu mới</label>
                                                                    <input type="password" name="new_pass" placeholder="Nhập mật khẩu mới..." />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="confirm_new_pass" class="required">Xác nhận lại mật khẩu</label>
                                                                    <input type="password" name="confirm_new_pass" placeholder="Nhập lại mật khẩu..." />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <div class="single-input-item">
                                                        <input type="hidden" id="action" name="action" value="Change">
                                                        @if(Session::has('customer'))
                                                        <input type="hidden" name="customerId" id="customerId" value="{{ Session::get('customer')->id }}">
                                                        @endif
                                                        <button class="check-btn sqr-btn ">Lưu</button>
                                                    </div>
                                                    <span id="form_edit_pass_result"></span>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- Single Tab Content End -->
        
                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade" id="account-info" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h3>Thông tin tài khoản</h3>
                                                <div class="account-details-form">
                                                    <form action="#" method="POST" id="form_update">
                                                        @csrf
                                                        <div class="single-input-item">
                                                            <label for="name" class="required">Tên</label>
                                                            @if(isset($customer->name))
                                                                <input type="text" id="name" name="name" placeholder="Nhập tên..." value="{{ $customer->name }}"/>
                                                            @else
                                                            <input type="text" id="name" placeholder="Nhập tên..." name="name"/>
                                                            @endif
                                                        </div>
                                                        <div class="single-input-item">
                                                            <label for="email" class="required">Địa chỉ email</label>
                                                            @if(isset($customer->email))
                                                                <input type="email" id="email" name="email" placeholder="Nhập email..." value="{{ $customer->email }}"/>
                                                            @else
                                                                <input type="email" id="email" placeholder="Nhập email..." name="email"/>
                                                            @endif
                                                        </div>
                                                        <div class="single-input-item">
                                                            <label for="address" class="required">Địa chỉ</label>
                                                            @if(isset($customer->address))
                                                                <input type="text" id="address" name="address" placeholder="Nhập địa chỉ..." value="{{ $customer->address }}"/>
                                                            @else
                                                                <input type="text" id="address" placeholder="Nhập địa chỉ..." name="address"/>
                                                            @endif
                                                        </div>
                                                        <div class="single-input-item">
                                                            <label for="phoneNumber" class="required">Số điện thoại</label>
                                                            @if(isset($customer->phoneNumber))
                                                                <input type="text" id="phoneNumber" name="phoneNumber" placeholder="Nhập số điện thoại..." value="{{ $customer->phoneNumber }}"/>
                                                            @else
                                                                <input type="text" id="phoneNumber" placeholder="Nhập số điện thoại..." name="phoneNumber"/>
                                                            @endif
                                                        </div>
                                                        <div class="single-input-item">
                                                            <input type="hidden" name="action" value="Edit">
                                                            @if(isset($customer))
                                                            <input type="hidden" name="customerId" value="{{ $customer->id }}">
                                                            @endif
                                                            <button class="check-btn sqr-btn " id="btn_edit" value="Edit">Lưu</button>
                                                        </div>
                                                    <span id="form_edit_result"></span>
                                                    </form>
                                                </div>
                                            </div>
                                        </div> <!-- Single Tab Content End -->
                                         <!-- Single Tab Content End -->

                                    </div>
                                </div> <!-- My Account Tab Content End -->
                            </div>
                        </div> <!-- My Account Page End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- my account wrapper end -->
    </main>
    @else
    <h2>Bạn chưa đăng nhập</h2>
    @endif
    <!-- page main wrapper end -->
@stop

@section('js')
<script>
    $('#form_update').on('submit',function(event){
        event.preventDefault();
        var data = new FormData(this);
        for (var value of data.values()) {
           console.log(value); 
        }
        if ($('#btn_edit').val() == 'Edit'){
            $.ajax({
                url: "{{ route('cus.edit') }}",
                method: "POST",
                data:data,
                contentType:false,
                cache:false,
                processData:false,
                dataType:"json",
                success:function(data){
                    var html = '';
                    if (data.errors) {
                        html += '<div class="alert alert-danger">';
                        for (var count = 0; count < data.errors.length; count++) {
                            html += '<p>'+data.errors[count]+'</p>';
                        }
                        html += '</div>';
                        $('#form_edit_result').html(html);
                    }
                    if (data.success) {
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
                            setTimeout(function(){location.reload();},1000);
                    }
                }
            });
        }
    });

    $('#form_change_pass').on('submit',function(event){
        event.preventDefault();
        var data = new FormData();
        data.append('_token',$("meta[name='csrf-token']").attr("content"));
        data.append('customerId',$("input[name='customerId']").val());
        data.append('old_pass',$("input[name='old_pass']").val());
        data.append('new_pass',$("input[name='new_pass']").val());
        data.append('confirm_new_pass',$("input[name='confirm_new_pass']").val());
        data.append('action',$("input[name='action']").val());
        for (var value of data.values()) {
           console.log(value); 
        }
        $.ajax({
            url: "{{ route('cus.edit') }}",
            method: "POST",
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success:function(data){
                var html = '';
                if (data.errors) {
                    html += '<div class="alert alert-danger">';
                        for (var count = 0; count < data.errors.length; count++) {
                            html += '<p>'+data.errors[count]+'</p>';
                        }
                        html += '</div>';
                        $('#form_edit_pass_result').html(html);
                }
                if (data.errors1) {
                    html+= '<div class="alert alert-danger">'+data.errors1+'</div>';
                    $('#form_edit_pass_result').html(html);
                }
                if (data.success) {
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
                    setTimeout(function(){location.reload();},1000);
                }
            }
        });
    });

    $(document).on('click','.view_order',function(event){
        event.preventDefault();
        var data = new FormData();
        var orderId = $(this).attr('id');
        data.append('orderId',orderId);
        data.append('_token',$("meta[name='csrf-token']").attr("content"));
        // for (var value of data.values()) {
        //    console.log(value); 
        // }
        $.ajax({
            url: "{{ route('cus.ordet') }}",
            method: "POST",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(html){
                if (html.data) {
                    var strin = '<tr>';
                    for (var count = 0; count < html.data.length; count++) {
                        strin += '<td class="pro-title">'+html.data[count].name+'</td>';
                        strin += '<td class="pro-title">'+html.data[count].size+'</td>';
                        strin += '<td class="pro-title">'+html.data[count].color+'</td>';
                        strin += '<td class="pro-price">'+html.data[count].price+' VNĐ'+'</td>';
                        strin += '<td class="pro-quantity">'+html.data[count].quantity+'</td>';
                    strin += '</tr>';
                    }
                    $('#table_body').html(strin);
                    $('#modal_order_detail').modal('show');
                }
            }
        });
    });

    $('#upload_form').on('submit',function(event){
        event.preventDefault();
        // var data = new FormData();
        // data.append('avatar',$('#avatar').val());
        // data.append('_token',$("meta[name='csrf-token']").attr("content"));
        // for (var value of data.values()) {
        //    console.log(value); 
        // }
        var data = new FormData(this);
        data.append('customerId',$("input[name='customerId']").val());
        $.ajax({
            url: "{{ route('post.avatar') }}",
            method: "POST",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(data){
                var html = '';
                if (data.errors) {
                    html = '<div class="alert alert-danger">';
                    for (var count = 0; count < data.errors.length; count++) {
                        html+='<p>'+data.errors[count]+'</p>';
                    }
                    html+='</div>';
                    $('#form_upload_result').html(html);
               }
               if (data.success) {
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
                    location.reload();
                }
            }
        });
    });
</script>
@stop