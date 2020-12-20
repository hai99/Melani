@extends('user\master')
@section('title','Đơn hàng')
@section('main')
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Đơn hàng</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- page main wrapper start -->
    <main>
        @if(Session::has('cart'))
        <!-- checkout main wrapper start -->
        <div class="checkout-page-wrapper pt-100 pb-90 pt-sm-58 pb-sm-54">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- Checkout Login Coupon Accordion Start -->
                        <div class="checkoutaccordion" id="checkOutAccordion">
                            <div class="card">
                                <h3>Have A Coupon? <span data-toggle="collapse" data-target="#couponaccordion">Click Here To Enter Your Code</span></h3>
                                <div id="couponaccordion" class="collapse" data-parent="#checkOutAccordion">
                                    <div class="card-body">
                                        <div class="cart-update-option">
                                            <div class="apply-coupon-wrapper">
                                                <form action="#" method="post" class=" d-block d-md-flex">
                                                    <input type="text" placeholder="Enter Your Coupon Code" />
                                                    <button class="check-btn sqr-btn">Apply Coupon</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Checkout Login Coupon Accordion End -->
                    </div>
                </div>
                <div class="row">
                    <!-- Checkout Billing Details -->
                    <div class="col-lg-6">
                        <div class="checkout-billing-details-wrap">
                            <h2>Thông tin người mua</h2>
                            <div class="billing-form-wrap">
                                    @csrf
                                    @if(Session::has('customer'))
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="single-input-item">
                                                <label for="g_name" class="required">Tên</label>
                                                <input type="text" id="g_name" value="{{ Session::get('customer')->name }}"  placeholder="Nhập tên..." readonly="true" />
                                                <input type="hidden" id="customerId" value="{{ Session::get('customer')->id }}">
                                            </div>
                                        </div>
        
                                        <div class="col-md-6">
                                            <div class="single-input-item">
                                                <label for="g_email" class="required">Email</label>
                                                <input type="text" id="g_email" placeholder="Nhập email..." value="{{ Session::get('customer')->email }}" readonly="true" />
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="single-input-item">
                                        <label for="g_phoneNumber" class="required">Số điện thoại</label>
                                        <input type="email" id="g_phoneNumber" value="{{ Session::get('customer')->phoneNumber }}" placeholder="Nhập số điện thoại..." readonly="true" />
                                    </div>
        
                                    <div class="single-input-item">
                                        <label for="g_address">Địa chỉ</label>
                                        <input type="text" id="g_address" value="{{ Session::get('customer')->address }}" placeholder="Nhập địa chỉ..." readonly="true" />
                                    </div>
                                    @endif
        
        
                                    <div class="checkout-box-wrap">
                                        <div class="single-input-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="ship_to_different">
                                                <label class="custom-control-label" for="ship_to_different">Thông tin người nhận</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="single-input-item">
                                                    <label for="n_name" class="required">Tên người nhận</label>
                                                    <input type="text" id="n_name" placeholder="Nhập tên người nhận..." value="" />
                                                </div>
                                            </div>
            
                                            <div class="col-md-6">
                                                <div class="single-input-item">
                                                    <label for="n_email" class="required">Email người nhận</label>
                                                    <input type="text" id="n_email" placeholder="Nhập email người nhận..." value="" />
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="single-input-item">
                                            <label for="n_phoneNumber" class="required">Số điện thoại người nhận</label>
                                            <input type="email" id="n_phoneNumber" value="" placeholder="Nhập số điện thoại người nhận..." />
                                        </div>
        
                                        <div class="single-input-item">
                                            <label for="n_address">Địa chỉ người nhận</label>
                                            <input type="text" id="n_address" value="" placeholder="Nhập địa chỉ người nhận..." />
                                        </div>
                                    </div>
                                    
                                    <div class="single-input-item">
                                        <label for="ordernote">Ghi chú</label>
                                        <textarea name="ordernote" id="ordernote" cols="30" rows="3" placeholder="Nhập ghi chú"></textarea>
                                    </div>
                                    
                            </div>
                        </div>
                    </div>
        
                    <!-- Order Summary Details -->
                    <div class="col-lg-6">
                        <div class="order-summary-details mt-md-26 mt-sm-26">
                            <h2>Đơn hàng</h2>
                            <div class="order-summary-content mb-sm-4">
                                <!-- Order Summary Table -->
                                <div class="order-summary-table table-responsive text-center">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Products</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(Session::get('cart') as $key => $item)
                                            <tr>
                                                <td><a href="{{ route('product_detail',['slug'=>$item['slug']]) }}">{{ $item['name'] }}</a><strong> × {{ $item['quantity'] }}</strong>
                                                @if(!empty($item['color']))
                                                <h6>{{ $item['color'] }}</h6>
                                                @endif
                                                @if(!empty($item['size']))
                                                <h6>{{ $item['size'] }}</h6>
                                                @endif
                                                </td>
                                                <td>{{ number_format($item['price']) }} VNĐ</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>Tổng tiền (Chưa tính ship)</td>
                                                <td><strong>{{ number_format($cart->total_amount) }} VNĐ</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Chọn hình thức giao hàng</td>
                                                <td>
                                                    <select class="select1"  id="deliveryId">
                                                        <option value="">--Chọn hình thức giao hàng--</option>
                                                        @foreach($deliveries as $delivery)
                                                        <option value="{{ $delivery->id }}" id="{{ $delivery->fee }}">{{ $delivery->name }} : {{ number_format($delivery->fee) }} VNĐ</option>@endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tổng tiền (Đã tính ship)</td>
                                                <td><strong id="total_with_ship">{{ $cart->total_amount }} VNĐ</strong>
                                                <input type="hidden" id="total_without_ship" value="{{ $cart->total_amount }}">
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- Order Payment Method -->
                                <div class="order-payment-method">
                                    @foreach($payments as $payment)
                                    <div class="single-payment-method">
                                        <div class="payment-method-name">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="cashon{{ $payment->id }}" name="paymentmethod" value="{{ $payment->id }}" class="custom-control-input" checked  />
                                                <label class="custom-control-label" for="cashon{{ $payment->id }}">{{ $payment->name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="summary-footer-area">
                                        <button type="submit" id="add_order" class="check-btn sqr-btn">Đặt hàng</button>
                                    </div>
                                    <span id="order_result"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <h1>Bạn chưa chọn sản phẩm nào</h1>
        <h6><a href="{{ route('home') }}">Quay lại</a></h6>
        @endif
        <!-- checkout main wrapper end -->
    </main>
    <!-- page main wrapper end -->
@stop

@section('js')
<script>
    $('#ship_to_different').click(function(){
        var check = document.getElementById('ship_to_different').checked;
        if (check) {
           $('#n_name').val($('#g_name').val());
            $('#n_email').val($('#g_email').val());
            $('#n_phoneNumber').val($('#g_phoneNumber').val());
            $('#n_address').val($('#g_address').val());
        }else{
            $('#n_name').val('');
            $('#n_email').val('');
            $('#n_phoneNumber').val('');
            $('#n_address').val('');
        }
    });

    // $(document).on('click','input[name=shipping]',function(){
    //     var old_total = parseFloat($('#total_with_ship').text());
    //     if ($('input[name=shipping]:checked').val()==2) {
    //         $('#total_with_ship').text(old_total+parseFloat(35000));
    //     }else{
    //         $('#total_with_ship').text(old_total+parseFloat(70000));
    //     }
    // });

    $('.select1').change(function(event){
        event.preventDefault();
        var data = new FormData();
        var total_amount = $('#total_without_ship').val();
        data.append('_token',$("meta[name='csrf-token']").attr("content"));
        data.append('deliveryId',$('#deliveryId :selected').val());
        data.append('fee',$('#deliveryId :selected').attr('id'));
        data.append('total_amount',total_amount);
        $.ajax({
            url: "{{ route('cart.fetch_total_ship') }}",
            method: "POST",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(html){
                if (html.data) {
                    $('#total_with_ship').text(html.data+' VNĐ');
                }
            }
        });
    });

    $('#add_order').on('click',function(event){
        event.preventDefault();
        var a = $('#total_with_ship').text();
        var b = a.search(" VNĐ");
        var totalAmount = a.slice(0, b);
        var data = new FormData();
        data.append('_token',$("meta[name='csrf-token']").attr("content"));
        data.append('cusName',$('#n_name').val());
        data.append('cusEmail',$('#n_email').val());
        data.append('address',$('#n_address').val());
        data.append('phoneNumber',$('#n_phoneNumber').val());
        data.append('orderNote',$('#ordernote').val());
        data.append('customerId',$('#customerId').val());
        data.append('paymentId',$('input[name=paymentmethod]:checked').val());
        data.append('deliveryId',$('#deliveryId :selected').val());
        data.append('totalAmount',totalAmount);
        for (var value of data.values()) {
           console.log(value); 
        }
        $.ajax({
            url: "{{ route('cart.order') }}",
            method: "POST",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(data){
                var html = '';
                if (data.errors) {
                    html+='<div class="alert alert-danger">';
                    for (var count = 0; count < data.errors.length; count++) {
                        html += '<p>'+data.errors[count]+'</p>';
                    }
                    html += '</div>';
                    $('#order_result').html(html);
                }
                if (data.error) {
                    alert(data.error);
                }
                if (data.error1) {
                    alert(data.error1);
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

</script>
@stop