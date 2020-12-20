@extends('user/master')
@section('title','Chi tiết sản phẩm')
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
                                <li class="breadcrumb-item"><a href="{{ route('all-products') }}">Sản phẩm</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Chi tiết sản phẩm</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->
<?php $img_list = json_decode($pro->image_list); ?>
    <!-- page main wrapper start -->
    <main>
        <div class="product-details-wrapper pt-100 pb-14 pt-sm-58">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <!-- product details inner end -->
                        <div class="product-details-inner">
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="product-large-slider mb-20 slider-arrow-style slider-arrow-style__style-2">
                                        <div class="pro-large-img img-zoom" id="img1">
                                            <img src="{{url('public')}}/user/img/product/{{ $pro->image }}" alt="" />
                                        </div>
                                    </div>
                                    <div class="pro-nav slick-padding2 slider-arrow-style slider-arrow-style__style-2">
                                        @if(is_array($img_list))
                                        @foreach($img_list as $item)
                                        <div class="pro-nav-thumb"><img src="{{$item}}" alt="" /></div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="product-details-des pt-md-98 pt-sm-58">
                                        <h3>{{ $pro->name }}</h3>
                                        <div class="ratings">
                                            @for($i = 0;$i < $floorRating;$i++)
                                            <span class="good"><i class="fa fa-star"></i></span>
                                            @endfor
                                            <div class="pro-review">
                                                <span><a href="#">{{count($reviews)}} đánh giá</a></span>
                                            </div>
                                        </div>
                                        <div class="pricebox">
                                            <span class="regular-price" id="fetch_price"></span>
                                        </div>
                                        <p>{{ $pro->description }}</p>
                                        <div class="quantity-cart-box d-flex align-items-center mb-24">
                                            <div class="quantity">
                                                <div class="pro-qty"><input type="text" value="1" id="quantity"></div>
                                            </div>
                                            <div class="product-btn product-btn__color">
                                                <input type="hidden" id="cartId" value="{{ $pro->id }}" name="">
                                                <a href="#" id="addCart"><i class="ion-bag"></i>Thêm vào giỏ hàng</a>
                                            </div>
                                        </div>

                                        @if(count($listColor) > 1)
                                            <div class="pro-size mb-24">
                                                <h5>màu :</h5>
                                                <select class="nice-select" id="colorId">
                                                @foreach($listColor as $color)
                                                    <option  value="{{ $color->id }}">{{ $color->name }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        @endif
                                        @if(count($listSizes) > 1)
                                            <div class="pro-size mb-24">
                                                <h5>kích cỡ :</h5>
                                                <select class="nice-select" id="sizeId">
                                                    @foreach($listSizes as $size)
                                                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                        <div class="availability mb-20">
                                            <h5>Trạng thái:</h5>
                                            <span id="condition"></span>
                                            <input type="hidden" id="hidden_pro_id" value="{{ $pro->id }}">
                                        </div>
                                        <div class="share-icon">
                                            <h5>share:</h5>
                                            <a href="#"><i class="fa fa-facebook"></i></a>
                                            <a href="#"><i class="fa fa-twitter"></i></a>
                                            <a href="#"><i class="fa fa-pinterest"></i></a>
                                            <a href="#"><i class="fa fa-google-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- product details inner end -->
                        <!-- product details reviews start -->
                        <div class="product-details-reviews pt-98 pt-sm-58">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="product-review-info">
                                        <ul class="nav review-tab">
                                            <li>
                                                <a class="active" data-toggle="tab" href="#tab_one">Mô tả</a>
                                            </li>
                                            <li>
                                                <a data-toggle="tab" href="#tab_two">Thông tin</a>
                                            </li>
                                            @if(Session::has('customer'))
                                            <li>
                                                <a data-toggle="tab" href="#tab_three">Đánh giá</a>
                                            </li>
                                            @endif
                                        </ul>
                                        <div class="tab-content reviews-tab">
                                            <div class="tab-pane fade show active" id="tab_one">
                                                <div class="tab-one">
                                                    <p>{{ $pro->description }}</p>
                                                </div>
                                            </div>
                                                               
                                            <div class="tab-pane fade" id="tab_two">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            @if(count($listColor) > 1)
                                                            <td>Màu</td>
                                                            <td>
                                                                @foreach($listColor as $color)
                                                               {{ $color->name."," }}
                                                                @endforeach
                                                            </td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if(count($listSizes) > 1)
                                                            <td>Kích cỡ</td>
                                                            <td>
                                                                @foreach($listSizes as $size)
                                                                {{ $size->name."," }}
                                                                @endforeach
                                                                
                                                                    
                                                            </td>
                                                            @endif
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            @if(Session::has('customer'))
                                            <div class="tab-pane fade" id="tab_three">
                                                <form action="" id="form_review" class="review-form" method="POST">
                                                    @csrf
                                                    <h5>{{count($reviews)}} đánh giá cho <span>{{$pro->name}}</span></h5>
                                                    @foreach($reviews as $rev)
                                                    <div class="total-reviews">
                                                        <div class="rev-avatar">
                                                            <img src="assets/img/about/avatar.jpg" alt="">
                                                        </div>
                                                        <div class="review-box">
                                                            <div class="ratings">
                                                                @for($i = 0;$i < $rev['rating'];$i ++)
                                                                <span class="good"><i class="fa fa-star"></i></span>
                                                                @endfor
                                                            </div>
                                                            <div class="post-author">
                                                                 <p><span>{{ $rev['name'] }}</span> {{ date('d-m-Y', strtotime($rev['created'])) }}</p>
                                                            </div>
                                                            <p>{{ $rev['content'] }}</p>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    <div class="form-group row">
                                                        <div class="col">
                                                            <label class="col-form-label"><span class="text-danger">*</span>Tên</label>
                                                            <input type="text" name="customerId" value="{{Session::get('customer')->name}}" class="form-control" readonly="true">
                                                            <input type="hidden" id="hidden_cus_id" value="{{Session::get('customer')->id}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col">
                                                            <label class="col-form-label"><span class="text-danger">*</span>Email</label>
                                                            <input type="email" name="email" value="{{Session::get('customer')->email}}" class="form-control" readonly="true">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col">
                                                            <label class="col-form-label"><span class="text-danger">*</span>Đánh giá của bạn</label>
                                                            <textarea class="form-control" id="content"></textarea>
                                                            <div class="help-block pt-10"><span class="text-danger">Ghi chú:</span> HTML is not translated!</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col">
                                                            <label class="col-form-label"><span class="text-danger">*</span>Xếp hạng</label>
                                                            &nbsp;&nbsp;&nbsp; Bad&nbsp;
                                                            <input type="radio" value="1" name="rating">
                                                            &nbsp;
                                                            <input type="radio" value="2" name="rating">
                                                            &nbsp;
                                                            <input type="radio" value="3" name="rating">
                                                            &nbsp;
                                                            <input type="radio" value="4" name="rating">
                                                            &nbsp;
                                                            <input type="radio" value="5" name="rating" checked>
                                                            &nbsp;Good
                                                        </div>
                                                    </div>
                                                    <div class="buttons">
                                                        <button class="sqr-btn" type="submit">Tiếp tục</button>
                                                    </div>
                                                </form> <!-- end of review-form -->
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <!-- product details reviews end --> 
                        <!-- featured product area start -->
                        <div class="page-section pt-100 pt-sm-58">
                            <div class="section-title text-center pb-44">
                                <h2>Các sản phẩm liên quan</h2>
                            </div>
                            <div class="releted-product spt slick-padding slick-arrow-style">
                                @foreach($relatedPros as $rp)
                                <div class="product-item mb-20">
                                    <div class="product-thumb">
                                        <a href="{{ route('product_detail',['slug'=>$rp->slug]) }}">
                                            <img src="{{ url('public') }}/user/img/product/{{ $rp->image }}" alt="product image">
                                        </a>
                                        <div class="box-label">
                                            @if($rp->created_at > $mytime)
                                            <div class="product-label new">
                                                <span>new</span>
                                            </div>
                                            @endif
                                            @if($rp->priority > 5)
                                            <div class="product-label discount">
                                                <span>hot</span>
                                            </div>
                                            @endif
                                            <div class="product-label discount">
                                                <span>-{{ $rp->discount }}%</span>
                                            </div>
                                        </div>
                                        <div class="product-action-link">
                                            <a href="#" class="quick_view" id="{{$rp->id}}"> <span data-toggle="tooltip" data-placement="left" title="Quick view"><i class="ion-ios-eye-outline"></i></span> </a>
                                            <a href="#" data-toggle="tooltip" class="addCompare" id="{{ $rp->id }}" data-placement="left" title="Compare"><i class="ion-ios-loop"></i></a>
                                            @if(Session::has('customer'))
                                                <input type="hidden" name="customerId" id="customerId" value="{{ Session::get('customer')->id }}">
                                            @else
                                                <input type="hidden" name="customerId" id="customerId" value="">
                                            @endif
                                                <a href="#" data-toggle="tooltip"  data-placement="left" class="addWishList" id="{{ $rp->id }}" title="Wishlist"><i class="ion-ios-shuffle"></i></a>
                                        </div>
                                    </div>
                                    <div class="product-description text-center">
                                        <div class="manufacturer">
                                            <p><a href="{{ route('product_detail',['slug'=>$rp->slug]) }}l">{{ $rp->cat->name }}</a></p>
                                        </div>
                                        <div class="product-name">
                                            <h3><a href="{{ route('product_detail',['slug'=>$rp->slug]) }}">{{ $rp->name }}</a></h3>
                                        </div>
                                        <div class="price-box">
                                            <span class="regular-price">${{ number_format($rp->price-($rp->price*(($rp->discount)/100))) }}</span>
                                            <span class="old-price"><del>${{ number_format($rp->price) }}</del></span>
                                        </div>
                                        <div class="product-btn">
                                            <a href="#"><i class="ion-bag"></i>Add to cart</a>
                                        </div>
                                        <div class="hover-box text-center">
                                            <div class="ratings">
                                                @foreach($avgs_rp as $avg)
                                                @if($rp->id == $avg['id'])
                                                @for($i = 0;$i < $avg['avg'];$i++)
                                                <span class="good"><i class="fa fa-star"></i></span>
                                                @endfor
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                @endforeach
                            </div>
                        </div>
                        <!-- featured product area end -->
                    </div>
                    <div class="col-lg-3">
                        <div class="sidebar-wrapper pt-md-16 pb-md-86 pb-sm-44">
                            <!-- single sidebar start -->
                            <div class="sidebar-single">
                                <div class="sidebar-title">
                                    <h3>danh mục</h3>
                                </div>
                                <div class="sidebar-body">
                                    <?php showCategories3($categories); ?>
                                </div>

                                <?php 
                                function showCategories3($categories ,$parentId = 0, $ul_class = 'sidebar-category')
                                    {
                                        $cate_child = array();
                                        foreach ($categories as $key => $item)
                                        {
                                            if ($item['parentId'] == $parentId)
                                            {
                                                $cate_child[] = $item;
                                                unset($categories[$key]);
                                            }
                                        }
                                        if ($cate_child)
                                        {
                                           
                                            echo '<ul class="'.$ul_class.'">';
                                            foreach ($cate_child as $key => $itemc)
                                            {
                                                echo '<li>'.'<a href="';
                                                echo route('get_by_category',['slug'=>$itemc->slug]);
                                                echo '">'.$itemc['name'].'</a>';
                                                 
                                                showCategories3($categories, $itemc['id'],'children');
                                                echo '</li>';
                                            }
                                            echo '</ul>';
                                        }

                                    }
                             ?>
                            </div>
                            <!-- single sidebar end -->

                            <!-- single sidebar start -->
                            <div class="sidebar-single">
                                <div class="sidebar-title">
                                    <h3>price</h3>
                                </div>
                                <div class="sidebar-body">
                                    <ul class="price-container">
                                        <li class="active"> 
                                            <label class="radio-container">
                                                $20.00 - $21.00
                                                <input type="radio" name="radio">
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                        <li> 
                                            <label class="radio-container">
                                                $26.00 - $30.00
                                                <input type="radio" name="radio">
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                        <li> 
                                            <label class="radio-container">
                                                $48.00 - $50.00
                                                <input type="radio" name="radio">
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                        <li> 
                                            <label class="radio-container">
                                                    $100.00 - $200.00
                                                <input type="radio" name="radio">
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                        <li> 
                                            <label class="radio-container">
                                                    $200.00 - $500.00
                                                <input type="radio" name="radio">
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- single sidebar end -->

                            <!-- single sidebar start -->
                            <div class="sidebar-single">
                                <div class="sidebar-title">
                                    <h3>Đặc sắc</h3>
                                </div>
                                <div class="sidebar-body">
                                    <div class="popular-item-inner popular-item-inner__style-2">
                                        @foreach($featuredPros as $fp)
                                        <div class="popular-item">
                                            <div class="pop-item-thumb">
                                                <a href="{{ route('product_detail',['slug'=>$fp->slug]) }}">
                                                    <img src="{{ url('public') }}/user/img/product/{{ $fp->image }}" alt="">
                                                </a>
                                            </div>
                                            <div class="pop-item-des">
                                                <h4><a href="{{ route('product_detail',['slug'=>$fp->slug]) }}">{{ $fp->name }}</a></h4>
                                                @if(isset($fp->discount))
                                                    <span class="pop-price">${{ number_format($fp->price-($fp->price*(($fp->discount)/100))) }}</span>
                                                @else
                                                    <span class="pop-price">${{ number_format($fp->price) }}</span>
                                                @endif
                                            </div>
                                        </div> <!-- end single popular item -->
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- single sidebar end -->

                            <!-- single sidebar start -->
                            <div class="sidebar-single">
                                <div class="advertising-thumb img-full fix">
                                    <a href="#">
                                        <img src="{{ url('public') }}/user/img/banner/advertising.jpg" alt="">
                                    </a>
                                </div>
                            </div>
                            <!-- single sidebar end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- page main wrapper end -->
@stop()

@section('js')
<script>

    $('#addCart').on('click',function(event){
        event.preventDefault();
        data = new FormData();
        data.append('productId',$('#cartId').val());
        data.append('price',$('#fetch_price').text());
        data.append('colorId',$('#colorId').val() ? $('#colorId').val() : '');
        data.append('sizeId',$('#sizeId').val() ? $('#sizeId').val() : '');
        data.append('quantity',$('#quantity').val());
        data.append('_token',$("meta[name='csrf-token']").attr("content"));
        for (var value of data.values()) {
           console.log(value); 
        }
        $.ajax({
            url: "{{ route('cart.add') }}",
            method: "POST",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(data){
                if (data.errors) {
                    alert(data.errors);
                }
                if (data.error1) {
                    alert(data.error1);
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

    $('.nice-select').change(function(event){
        event.preventDefault();
        var data = new FormData();
        if ($('#colorId :selected').val() == null) {
            data.append('colorId','');
        }else{
            data.append('colorId',$('#colorId :selected').val());
        }
        if ($('#sizeId :selected').val() == null) {
            data.append('sizeId','');
        }else{
            data.append('sizeId',$('#sizeId :selected').val());
        }
        data.append('_token',$("meta[name='csrf-token']").attr("content"));
        data.append('productId',$('#hidden_pro_id').val());
        for (var value of data.values()) {
           console.log(value); 
        }
        $.ajax({
            url: "{{ route('fetch.stock') }}",
            method: "POST",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(html){
                if (html.data) {
                    $('#condition').text('Còn '+html.data.importNum+' sản phẩm');
                    $('#fetch_price').text(html.price+' VNĐ');
                }
                if (html.error) {
                    $('#condition').text(html.error);
                    $('#fetch_price').text('0 VNĐ');
                }
            }
        });
    });

    $('#form_review').on('submit',function(event){
        event.preventDefault();
        var data = new FormData();
        data.append('productId',$('#hidden_pro_id').val());
        data.append('customerId',$('#hidden_cus_id').val());
        data.append('rating',$('input[name=rating]:checked').val());
        data.append('content',$('#content').val());
        data.append('_token',$("meta[name='csrf-token']").attr("content"));
        for (var value of data.values()) {
           console.log(value); 
        }
        $.ajax({
            url: "{{ route('post_review') }}",
            method:"POST",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(data){
                if (data.errors) {
                    alert(data.errors);
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

</script>
@stop


    