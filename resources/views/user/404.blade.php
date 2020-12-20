@extends('user\master')
@section('title','Lỗi')
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
                                <li class="breadcrumb-item active" aria-current="page">Lỗi</li>
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
                            <!-- single sidebar end -->

                            <!-- single sidebar start -->
                            <!-- <div class="sidebar-single">
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
                            </div> -->

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
                                    <h3>sản phẩm thông dụng</h3>
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
                        <h1>Lỗi!</h1>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- page main wrapper end -->

@stop()