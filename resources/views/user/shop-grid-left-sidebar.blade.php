@extends('user/master')
@section('title','Tất cả sản phẩm')
@section('main')

    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="shop-grid-left-sidebar.html">sản phẩm</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    @if(isset($cat))
                                        {{ $cat->name }}
                                    @else
                                        Tất cả sản phẩm
                                    @endif
                                </li>
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
        <div class="shop-main-wrapper pt-100 pb-100 pt-sm-58 pb-sm-58">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 order-2 order-lg-1">
                        <div class="sidebar-wrapper mt-md-100 mt-sm-48">
                            <!-- single sidebar start -->
                            <div class="sidebar-single">
                                <div class="sidebar-title">
                                    <h3>Danh mục</h3>
                                </div>
                                <div class="sidebar-body">
                                   <?php showCategories($categories); ?>
                                </div>
                            </div>

                            <?php 
                                function showCategories($categories ,$parentId = 0, $ul_class = 'sidebar-category')
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
                                                showCategories($categories, $itemc['id'],'children');
                                                echo '</li>';
                                            }
                                            echo '</ul>';
                                        }

                                    }
                             ?>
                            <!-- single sidebar end -->

                            <!-- single sidebar start -->
                            <div class="sidebar-single">
                                <div class="sidebar-title">
                                    <h3>Giá</h3>
                                </div>
                                <div class="sidebar-body">
                                    <ul class="price-container">
                                        <li class="active">
                                            <a href="{{ route('get_by_price',['price1'=>50000,'price2'=>100000]) }}">
                                            <label class="radio-container">
                                                 50.000 VNĐ - 100.000 VNĐ
                                            </label>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('get_by_price',['price1'=>100000,'price2'=>300000]) }}">
                                            <label class="radio-container">
                                                100.000 VNĐ - 300.000 VNĐ
                                            </label>
                                            </a>
                                        </li>
                                        <li> 
                                            <a href="{{ route('get_by_price',['price1'=>300000,'price2'=>500000]) }}">
                                            <label class="radio-container">
                                                300.000 VNĐ - 500.000 VNĐ
                                            </label>
                                            </a>
                                        </li>
                                        <li> 
                                            <a href="{{ route('get_by_price',['price1'=>500000,'price2'=>700000]) }}">
                                            <label class="radio-container">
                                                    500.000 VNĐ - 700.000 VNĐ
                                            </label>
                                            </a>
                                        </li>
                                        <li> 
                                            <a href="{{ route('get_by_price',['price1'=>700000,'price2'=>1000000]) }}">
                                            <label class="radio-container">
                                                    700.000 VNĐ - 1.000.000 VNĐ
                                            </label>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- single sidebar end -->

                            <!-- single sidebar start -->
                            <div class="sidebar-single">
                                <div class="sidebar-title">
                                    <h3>sản phẩm nổi bật</h3>
                                </div>
                                <div class="sidebar-body">
                                    <div class="popular-item-inner">
                                        @foreach($popularPros as $pp)
                                        <div class="popular-item">
                                            <div class="pop-item-thumb">
                                                <a href="{{ route('product_detail',['slug'=>$pp->slug]) }}">
                                                    <img src="{{ url('public') }}/user/img/product/{{ $pp->image }}" alt="">
                                                </a>
                                            </div>
                                            <div class="pop-item-des">
                                                <h4><a href="{{ route('product_detail',['slug'=>$pp->slug]) }}">{{ $pp->name }}</a></h4>
                                                @if(isset($pp->discount))
                                                    <span class="pop-price">{{ number_format($pp->price-($pp->price*(($pp->discount)/100))) }} VNĐ</span>
                                                @else
                                                    <span class="pop-price">{{ number_format($pp->price) }} VNĐ</span>
                                                @endif
                                            </div>
                                        </div> 
                                        <!-- end single popular item -->
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- single sidebar end -->

                            <!-- single sidebar start -->
                            <div class="sidebar-single">
                                <div class="advertising-thumb img-full fix">
                                    <a href="#">
                                        <img src="{{ url('/public') }}/user/img/banner/advertising.jpg" alt="">
                                    </a>
                                </div>
                            </div>
                            <!-- single sidebar end -->
                        </div>
                    </div>
                    <!-- product view wrapper area start -->
                    <div class="col-xl-9 col-lg-8 order-1 order-lg-2">
                        <div class="shop-product-wrapper">
                            <!-- shop product top wrap start -->
                            <div class="shop-top-bar">
                                <div class="row">
                                    <div class="col-lg-7 col-md-6">
                                        <div class="top-bar-left">
                                            <div class="product-view-mode">
                                                <a class="active" href="#" data-target="grid"><i class="fa fa-th"></i></a>
                                                <a href="#" data-target="list"><i class="fa fa-list"></i></a>
                                            </div>
                                            <div class="product-amount">
                                                <a href="{{ route('compare') }}" class="sqr-btn">So sánh</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-6">
                                        <div class="top-bar-right">
                                            <div class="product-short">
                                                <p>Sắp xếp theo: </p>

                                                <select onchange="location=this.value" class="nice-select" name="sortby">
                                                    <option value="{{ route('all-products') }}">Mặc định</option>
                                                    <option  value="{{ route('sort_by',['field'=>'name','attr'=>'ASC']) }}">Tên (A - Z)</option>
                                                    <option value="{{ route('sort_by',['field'=>'name','attr'=>'DESC']) }}">Tên (Z - A)</option>
                                                    <option value="{{ route('sort_by',['field'=>'price','attr'=>'ASC']) }}">Giá (Thấp &gt; Cao)</option>
                                                    <option value="{{ route('sort_by',['field'=>'price','attr'=>'DESC']) }}">Giá (Cao &gt; Thấp)</option>
                                                    <option value="{{ route('sort_by',['field'=>'proView','attr'=>'DESC']) }}">Lượt xem</option>
                                                    <option value="{{ route('sort_by',['field'=>'priority','attr'=>'DESC']) }}">Lượt mua</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- shop product top wrap start -->
                            <!-- product view mode wrapper start -->
                            <div class="shop-product-wrap grid row">
                                @foreach($products as $pro)
                                <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6" id="productData">
                                    <!-- product grid item start -->
                                    <div class="product-item mb-20">
                                        <div class="product-thumb">
                                            <a href="{{ route('product_detail',['slug'=>$pro->slug]) }}">
                                                <img src="{{ url('public/user') }}/img/product/{{ $pro->image }}" alt="product image">
                                            </a>
                                            <div class="box-label">
                                                 @if($pro->created_at > $mytime)
                                                <div class="product-label new">
                                                    <span>new</span>
                                                </div>
                                                @endif
                                                @if($pro->priority > 5)
                                                <div class="product-label discount" style="background-color: red !important">
                                                    <span>hot</span>
                                                </div>
                                                @endif
                                                <div class="product-label discount">
                                                    <span>-{{ $pro->discount }}%</span>
                                                </div>
                                            </div>
                                            <div class="product-action-link">
                                                <a href="#" class="quick_view" id="{{$pro->id}}"> <span data-toggle="tooltip" data-placement="left" title="Quick view"><i class="ion-ios-eye-outline"></i></span> </a>
                                                <a href="#" data-toggle="tooltip" class="addCompare" id="{{ $pro->id }}" data-placement="left" title="Compare"><i class="ion-ios-loop"></i></a>
                                                @if(Session::has('customer'))
                                                    <input type="hidden" name="customerId" id="customerId" value="{{ Session::get('customer')->id }}">
                                                @else
                                                    <input type="hidden" name="customerId" id="customerId" value="">
                                                @endif
                                                    <a href="#" data-toggle="tooltip"  data-placement="left" class="addWishList" id="{{ $pro->id }}" title="Wishlist"><i class="ion-ios-shuffle"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-description text-center">
                                            
                                            <div class="product-name">
                                                <h3><a href="{{ route('product_detail',['slug'=>$pro->slug]) }}">{{ $pro->name }}</a></h3>
                                            </div>
                                            <div class="price-box">
                                                <span class="regular-price">{{ number_format($pro->price-($pro->price*($pro->discount/100))) }} VNĐ</span>
                                                <span class="old-price"><del>{{ number_format($pro->price) }} VNĐ</del></span>
                                            </div>
                                            <div class="product-btn">
                                                <a href="{{ route('product_detail',['slug'=>$pro->slug]) }}"><i class="ion-bag"></i>Thêm vào giỏ hàng</a>
                                            </div>
                                            <div class="hover-box text-center">
                                                <div class="ratings">
                                                    @foreach($avgs as $avg)
                                                    @if($pro->id == $avg['id'])
                                                    @for($i = 0;$i < $avg['avg'];$i++)
                                                    <span class="good"><i class="fa fa-star"></i></span>
                                                    @endfor
                                                    @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- product grid item end -->
                                    <!-- product list item start -->
                                    <div class="product-list-item mb-20">
                                        <div class="product-thumb">
                                            <a href="{{ route('product_detail',['slug'=>$pro->slug]) }}">
                                                <img src="{{ url('public/user') }}/img/product/{{ $pro->image }}" alt="product image">
                                            </a>
                                            <div class="box-label">
                                                @if($pro->created_at > $mytime)
                                                <div class="product-label new">
                                                    <span>new</span>
                                                </div>
                                                @endif
                                                @if($pro->priority > 5)
                                                <div class="product-label discount" style="background-color: red !important">
                                                    <span>hot</span>
                                                </div>
                                                @endif
                                                <div class="product-label discount">
                                                    <span>-{{ $pro->discount }}%</span>
                                                </div>
                                            </div>
                                            <div class="product-action-link">
                                                <a href="#" class="quick_view" id="{{$pro->id}}"> <span data-toggle="tooltip" data-placement="left" title="Quick view"><i class="ion-ios-eye-outline"></i></span> </a>
                                                <a href="#" data-toggle="tooltip" class="addCompare" id="{{ $pro->id }}" data-placement="left" title="Compare"><i class="ion-ios-loop"></i></a>
                                                @if(Session::has('customer'))
                                                    <input type="hidden" name="customerId" id="customerId" value="{{ Session::get('customer')->id }}">
                                                @else
                                                    <input type="hidden" name="customerId" id="customerId" value="">
                                                @endif
                                                    <a href="#" data-toggle="tooltip"  data-placement="left" class="addWishList" id="{{ $pro->id }}" title="Wishlist"><i class="ion-ios-shuffle"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-list-content">
                                            
                                            <h3><a href="">{{ $pro->name }}</a></h3>
                                            <div class="ratings">
                                                @foreach($avgs as $avg)
                                                @if($pro->id == $avg['id'])
                                                @for($i = 0;$i < $avg['avg'];$i++)
                                                <span class="good"><i class="fa fa-star"></i></span>
                                                @endfor
                                                @endif
                                                @endforeach
                                            </div>
                                            <div class="pricebox">
                                                <span class="regular-price">{{ number_format($pro->price-($pro->price*($pro->discount/100))) }} VNĐ</span>
                                                <span class="old-price"><del>{{ number_format($pro->price) }} VNĐ</del></span>
                                            </div>
                                            <p>${{ $pro->description }}</p>
                                            <div class="product-btn product-btn__color">
                                                <a href="{{ route('product_detail',['slug'=>$pro->slug]) }}"><i class="ion-bag"></i>Thêm vào giỏ hàng</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- product list item end -->
                                </div>
                                @endforeach
                                <!-- <div class="clearfix"></div>
                                {{$products->links()}}
                            </div> -->
                            <!-- product view mode wrapper start -->
                        </div>
                        <!-- start pagination area -->
                        <div class="paginatoin-area text-center mt-18">
                               {{$products->links()}}
                        </div>
                        <!-- end pagination area -->
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- page main wrapper end -->
    @stop()