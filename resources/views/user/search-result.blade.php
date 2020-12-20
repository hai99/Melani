@extends('user/master')
@section('title','Tìm kiếm sản phẩm')
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
                                <li class="breadcrumb-item active" aria-current="page">Tìm kiếm</li>
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
                                    <h3>shop</h3>
                                </div>
                                <div class="sidebar-body">
                                   <?php showCategories($categories); ?>
                                </div>
                            </div>
                            <!-- single sidebar end -->

                            <!-- single sidebar start -->
                            <div class="sidebar-single">
                                <div class="sidebar-title">
                                    <h3>category</h3>
                                </div>
                                <div class="sidebar-body">
                                    <ul class="price-container">
                                        <li class="active"> 
                                            <label class="checkbox-container">
                                                Health (10)
                                                <input type="checkbox" name="checkbox">
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                        <li> 
                                            <label class="checkbox-container">
                                                beauty (16)
                                                <input type="checkbox" name="checkbox">
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                        <li> 
                                            <label class="checkbox-container">
                                                makeup (10)
                                                <input type="checkbox" name="checkbox">
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                        <li> 
                                            <label class="checkbox-container">
                                                skincare (9)
                                                <input type="checkbox" name="checkbox">
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                    </ul>

                                    
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
                                                echo '<li>'.'<a href="">'.$itemc['name'].'</a>';
                                                 
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
                                    <h3>price</h3>
                                </div>
                                <div class="sidebar-body">
                                    <ul class="price-container">
                                        <li class="active">
                                            <a href="{{ route('get_by_price',['price1'=>50000,'price2'=>100000]) }}">
                                            <label class="radio-container">
                                                50.000 VNĐ - 100.000 VNĐ
                                                <input type="radio" name="radio">
                                                <span class="checkmark"></span>
                                            </label>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('get_by_price',['price1'=>100000,'price2'=>300000]) }}">
                                            <label class="radio-container">
                                                100.000 VNĐ - 300.000 VNĐ
                                                <input type="radio" name="radio">
                                                <span class="checkmark"></span>
                                            </label>
                                            </a>
                                        </li>
                                        <li> 
                                            <label class="radio-container">
                                                300.000 VNĐ - 500.000 VNĐ
                                                <input type="radio" name="radio">
                                            <a href="{{ route('get_by_price',['price1'=>300000,'price2'=>500000]) }}">
                                                <span class="checkmark"></span>
                                            </a>
                                            </label>
                                        </li>
                                        <li> 
                                            <a href="{{ route('get_by_price',['price1'=>500000,'price2'=>700000]) }}">
                                            <label class="radio-container">
                                                    500.000 VNĐ - 700.000 VNĐ
                                                <input type="radio" name="radio">
                                                <span class="checkmark"></span>
                                            </label>
                                            </a>
                                        </li>
                                        <li> 
                                            <a href="{{ route('get_by_price',['price1'=>700000,'price2'=>1000000]) }}">
                                            <label class="radio-container">
                                                    700.000 VNĐ - 1.000.000 VNĐ
                                                <input type="radio" name="radio">
                                                <span class="checkmark"></span>
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
                                    <h3>popular product</h3>
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
                                                    <span class="pop-price">${{ number_format($pp->price-($pp->price*(($pp->discount)/100))) }}</span>
                                                @else
                                                    <span class="pop-price">${{ number_format($pp->price) }}</span>
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
                                                <p>Showing 1–16 of 21 results</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-6">
                                        <div class="top-bar-right">
                                            <div class="product-short">
                                                <p>Sort By : </p>

                                                <select onchange="location=this.value" class="nice-select" name="sortby">
                                                    <option value="">Relevance</option>
                                                    <option  value="{{ route('sort_by',['field'=>'name','attr'=>'ASC']) }}">Name (A - Z)</option>
                                                    <option value="{{ route('sort_by',['field'=>'name','attr'=>'DESC']) }}">Name (Z - A)</option>
                                                    <option value="{{ route('sort_by',['field'=>'price','attr'=>'ASC']) }}">Price (Low &gt; High)</option>
                                                    <option value="{{ route('sort_by',['field'=>'price','attr'=>'DESC']) }}">Price (High &gt; Low)</option>
                                                    <option value="{{ route('sort_by',['field'=>'proView','attr'=>'DESC']) }}">Views</option>
                                                    <option value="{{ route('sort_by',['field'=>'priority','attr'=>'DESC']) }}">Buys</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- shop product top wrap start -->
                            <!-- product view mode wrapper start -->
                            <div class="shop-product-wrap grid row">
                                @foreach($listPro as $pro)
                                <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6">
                                    <!-- product grid item start -->
                                    <div class="product-item mb-20">
                                        <div class="product-thumb">
                                            <a href="{{ route('product_detail',['slug'=>$pro->slug]) }}">
                                                <img src="{{ url('public/user') }}/img/product/{{ $pro->image }}" alt="product image">
                                            </a>
                                            <div class="box-label">
                                                <div class="product-label new">
                                                    <span>new</span>
                                                </div>
                                                <div class="product-label discount">
                                                    <span>-{{ $pro->discount }}%</span>
                                                </div>
                                            </div>
                                            <div class="product-action-link">
                                                <a href="#" data-toggle="modal" data-target="#quick_view"> <span
                                                    data-toggle="tooltip" data-placement="left" title="Quick view"><i class="ion-ios-eye-outline"></i></span> </a>
                                                <a href="#" data-toggle="tooltip" data-placement="left" title="Compare"><i
                                                    class="ion-ios-loop"></i></a>
                                                <a href="#" data-toggle="tooltip" data-placement="left" title="Wishlist"><i
                                                    class="ion-ios-shuffle"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-description text-center">
                                            
                                            <div class="product-name">
                                                <h3><a href="{{ route('product_detail',['slug'=>$pro->slug]) }}">{{ $pro->name }}</a></h3>
                                            </div>
                                            <div class="price-box">
                                                <span class="regular-price">${{ number_format($pro->price-($pro->price*($pro->discount/100))) }}</span>
                                                <span class="old-price"><del>${{ number_format($pro->price) }}</del></span>
                                            </div>
                                            <div class="product-btn">
                                                <a href="#"><i class="ion-bag"></i>Add to cart</a>
                                            </div>
                                            <div class="hover-box text-center">
                                                <div class="ratings">
                                                    <span><i class="fa fa-star"></i></span>
                                                    <span><i class="fa fa-star"></i></span>
                                                    <span><i class="fa fa-star"></i></span>
                                                    <span><i class="fa fa-star"></i></span>
                                                    <span><i class="fa fa-star"></i></span>
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
                                                <div class="product-label new">
                                                    <span>new</span>
                                                </div>
                                                <div class="product-label discount">
                                                    <span>-{{ $pro->discount }}%</span>
                                                </div>
                                            </div>
                                            <div class="product-action-link">
                                                <a href="#" data-toggle="modal" data-target="#quick_view"> <span
                                                    data-toggle="tooltip" data-placement="left" title="Quick view"><i class="ion-ios-eye-outline"></i></span> </a>
                                                <a href="#" data-toggle="tooltip" data-placement="left" title="Compare"><i
                                                    class="ion-ios-loop"></i></a>
                                                <a href="#" data-toggle="tooltip" data-placement="left" title="Wishlist"><i
                                                    class="ion-ios-shuffle"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-list-content">
                                            
                                            <h3><a href="">{{ $pro->name }}s</a></h3>
                                            <div class="ratings">
                                                <span class="good"><i class="fa fa-star"></i></span>
                                                <span class="good"><i class="fa fa-star"></i></span>
                                                <span class="good"><i class="fa fa-star"></i></span>
                                                <span class="good"><i class="fa fa-star"></i></span>
                                                <span><i class="fa fa-star"></i></span>
                                            </div>
                                            <div class="pricebox">
                                                <span class="regular-price">${{ number_format($pro->price-($pro->price*($pro->discount/100))) }}</span>
                                                <span class="old-price"><del>${{ number_format($pro->price) }}</del></span>
                                            </div>
                                            <p>${{ $pro->description }}</p>
                                            <div class="product-btn product-btn__color">
                                                <a href="#"><i class="ion-bag"></i>Add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- product list item end -->
                                </div>
                                @endforeach
                            <!-- product view mode wrapper start -->
                        </div>
                        <!-- start pagination area -->
                        <div class="paginatoin-area text-center mt-18">
                               {{$listPro->links()}}
                        </div>
                        <!-- end pagination area -->
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- page main wrapper end -->


    @stop()