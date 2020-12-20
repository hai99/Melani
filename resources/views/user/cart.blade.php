@extends('user\master')
@section('title','Giỏ hàng')
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
                                <li class="breadcrumb-item active" aria-current="page">giỏ hàng</li>
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
        <!-- cart main wrapper start -->
        <div class="cart-main-wrapper pt-100 pb-100 pt-sm-58 pb-sm-58">
            @if(count($cart->items) > 0)
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Cart Table Area -->
                        <div class="cart-table table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="pro-thumbnail">Ảnh</th>
                                    <th class="pro-title">Tên sản phẩm</th>
                                    <th class="pro-title">Màu</th>
                                    <th class="pro-title">Kích cỡ</th>
                                    <th class="pro-price">Giá</th>
                                    <th class="pro-quantity">Số lượng</th>
                                    <th class="pro-subtotal">Tổng giá</th>
                                    <th class="pro-remove">Xóa</th>
                                </tr>
                                </thead>
                                <tbody>
                                @csrf
                                @foreach(Session::get('cart') as $key => $item)
                                <tr>
                                    <td class="pro-thumbnail"><a href="{{ route('product_detail',['slug'=>$item['slug']]) }}"><img class="img-fluid" src="{{ url('public') }}/user/img/product/{{ $item['image'] }}"alt="Product"/></a></td>
                                    <td class="pro-title"><a href="{{ route('product_detail',['slug'=>$item['slug']]) }}">{{ $item['name'] }}</a></td>
                                    <td class="pro-title">
                                        @if(!empty($item['color']))
                                        {{ $item['color'] }}
                                        @else
                                        <?php echo "Không" ?>
                                        @endif
                                    </td>
                                    <td class="pro-title">
                                        @if(!empty($item['size']))
                                        {{ $item['size'] }}
                                        @else
                                        <?php echo "Không" ?>
                                        @endif
                                    </td>
                                    <td class="pro-price"><span>{{ number_format($item['price']) }} VNĐ</span></td>
                                    <td class="pro-quantity">
                                        <div class="">
                                            <input type="number" min="0" class="quantity_check" name="quantity" id="{{ $key }}" value="{{ $item['quantity'] }}">
                                        </div>
                                    </td>
                                    <td class="pro-subtotal"><span>{{ number_format($item['price']*$item['quantity']) }} VNĐ</span></td>
                                    <td class="pro-remove"><a href="#" class="removeCart" id="{{ $key }}"><i class="fa fa-trash-o"></i></a></td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Cart Update Option -->
                        <div class="cart-update-option d-block d-md-flex justify-content-between">
                            <div class="apply-coupon-wrapper">
                                <form action="#" method="post" class=" d-block d-md-flex">
                                    <input type="text" placeholder="Enter Your Coupon Code" required />
                                    <button class="sqr-btn">Apply Coupon</button>
                                </form>
                            </div>
                            <div class="cart-update mt-sm-16">
                                <a href="#" class="sqr-btn" id="clearAll">Xóa hết</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5 ml-auto">
                        <!-- Cart Calculation Area -->
                        <div class="cart-calculator-wrapper">
                            <div class="cart-calculate-items">
                                <h3>Tổng</h3>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td>Tổng tiền</td>
                                            <td>{{ number_format($cart->total_amount) }} VNĐ</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            @if(Session::has('customer'))
                            <a href="{{ route('cart.checkout') }}" id="order" class="sqr-btn d-block">Đặt hàng</a>
                            <input type="hidden" id="customerId" value="{{Session::get('customer')->id}}" name="">
                            @else
                            <input type="hidden" id="customerId" value="" name="">
                            <a href="" id="order" class="sqr-btn d-block">Đặt hàng</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="container">
                <div class="row">
                     <div class="col-lg-12">
                        <h1>Chưa có sản phẩm nào</h1>
                        <h3><a href="{{ route('home') }}">Quay lại</a></h3>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <!-- cart main wrapper end -->
    </main>
    <!-- page main wrapper end -->
@stop
@section('js')
<script>
    $(document).on('click','.removeCart',function(event){
        event.preventDefault();
        var data = new FormData();
        data.append('productId',$(this).attr('id'));
        data.append('_token',$("meta[name='csrf-token']").attr("content"));
        $.ajax({
            url: "{{ route('cart.remove') }}",
            method: "POST",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(data){
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

    $('#clearAll').on('click',function(event){
        event.preventDefault();
        var data = new FormData();
        data.append('_token',$("meta[name='csrf-token']").attr("content"));
        $.ajax({
            url: "{{ route('cart.clear') }}",
            method: "POST",
            data: data,
            contentType:false,
            cache: false,
            processData: false,
            dataType: "json",
            success:function(data){
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

    $(document).on('change','input[name="quantity"]',function(event){
        event.preventDefault();
        var data = new FormData();
        data.append('cartId',$(this).attr('id'));
        data.append('_token',$("meta[name='csrf-token']").attr("content"));
        data.append('quantity',$(this).val());
        for (var value of data.values()) {
           console.log(value); 
        }
        $.ajax({
            url: "{{ route('cart.update') }}",
            method: "POST",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(data){
                if (data.success) {
                    location.reload();
                }
            }
        });
    });

    $('#order').click(function(event){
        event.preventDefault();
        if ($('#customerId').val() == '') {
            alert('Bạn chưa đăng nhập');
            $('#modalLogin').modal('show');
        }
        if ($('.quantity_check').val() == 0) {
            alert('Số lượng phải lớn hơn 0');
        }
        if ($('.quantity_check').val() < 0) {
            alert('Số lượng nhập vào không hợp lệ');
        }
    });
</script>
@stop