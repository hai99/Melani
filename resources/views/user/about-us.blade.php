@extends('user\master')
@section('title','Giới thiệu')
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
                                <li class="breadcrumb-item active" aria-current="page">Giới thiệu</li>
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
        <!-- about wrapper start -->
        <div class="about-us-wrapper pt-98 pb-100 pt-sm-58 pb-sm-58">
            <div class="container">
                <div class="row">
                    <!-- About Text Start -->
                    <div class="col-xl-6 col-lg-6">
                        <div class="about-text-wrap">
                            <h2><span>Provide Best</span>Product For You</h2>
                            <p>We provide the best Beard oile all over the world. We are the worldd best store in indi for Beard Oil. You can buy our product without any hegitation because they truste us and buy our product without any hagitation because they belive and always happy buy our product.</p>
                            <p>Some of our customer say’s that they trust us and buy our product without any hagitation because they belive us and always happy to buy our product.</p>
                            <p>We provide the beshat they trusted us and buy our product without any hagitation because they belive us and always happy to buy.</p>
                        </div>
                    </div>
                    <!-- About Text End -->
                    <!-- About Image Start -->
                    <div class="col-xl-5 col-lg-6 ml-auto">
                        <div class="about-image-wrap">
                            <img src="{{ url('public') }}/user/img/about/about.jpg" alt="About" />
                        </div>
                    </div>
                    <!-- About Image End -->
                </div>
            </div>
        </div>
        <!-- about wrapper end -->

        <!-- team area start -->
        <div class="team-area bg-gray pt-100 pb-58 pt-sm-56 pb-sm-16">
            <div class="container">
                <div class="page-section pt-100 pt-sm-58">
                    <div class="section-title text-center pb-44">
                        <p>các sản phẩm có thể bạn thích</p>
                        <h2>sản phẩm</h2>
                    </div>
                    <div class="releted-product spt slick-padding slick-arrow-style">
                        @foreach($randPro as $rp)
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
                                    <a href="#" data-toggle="modal" data-target="#quick_view"> <span
                                        data-toggle="tooltip" data-placement="left" title="Quick view"><i class="ion-ios-eye-outline"></i></span> </a>
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
                                    <span class="regular-price">{{ number_format($rp->price-($rp->price*(($rp->discount)/100))) }} VNĐ</span>
                                    <span class="old-price"><del>{{ number_format($rp->price) }} VNĐ</del></span>
                                </div>
                                <div class="product-btn">
                                    <a href="{{ route('product_detail',['slug'=>$rp->slug]) }}"><i class="ion-bag"></i>Mua hàng</a>
                                </div>
                                <div class="hover-box text-center">
                                    <div class="ratings">
                                        @foreach($avgs as $avg)
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
                </div>
            </div>
        </div>

        <!-- choosing area start -->
        <div class="choosing-area pt-100 pb-92 pb-md-62 pt-sm-58 pb-sm-20" style="padding-top: 3px!important;">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center pb-44">
                            <p>our core service</p>
                            <h2>why choose us</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="single-choose-item text-center mb-md-30 mb-sm-30">
                            <i class="fa fa-globe"></i>
                            <h4>free shipping</h4>
                            <p>Amadea Shop is a very slick and clean e-commerce template with endless possibilities.</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-choose-item text-center mb-md-30 mb-sm-30">
                            <i class="fa fa-plane"></i>
                            <h4>fast delivery</h4>
                            <p>Amadea Shop is a very slick and clean e-commerce template with endless possibilities.</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-choose-item text-center mb-md-30 mb-sm-30">
                            <i class="fa fa-comments"></i>
                            <h4>customers support</h4>
                            <p>Amadea Shop is a very slick and clean e-commerce template with endless possibilities.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- choosing area end -->
    </main>
    <!-- page main wrapper end -->
@stop