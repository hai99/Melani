@extends('user\master')
@section('title','Trang chủ')
@section('main')
    

    <!-- slider area start -->
    <div class="hero-area">
        <div class="hero-slider-active slider-arrow-style slick-dot-style hero-dot">
            <div class="hero-single-slide hero-1 d-flex align-items-center" style="background-image: url({{ url('public') }}/user/img/slider/slide-1.jpg);">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="slider-content">
                                <h1>products that glow <br>as much <span>as you do</span></h1>
                                <h3>Super creamy under eye concealers</h3>
                                <a href="shop-grid-left-sidebar.html" class="slider-btn">view collection</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-single-slide hero-1 d-flex align-items-center" style="background-image: url({{ url('public') }}/user/img/slider/slide-2.jpg);">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="slider-content">
                                <h1>free shipping beauty</h1>
                                <h4>Shop Top Quality Haircare, Makeup, Skincare, Nailcare & Much More.</h4>
                                <a href="shop-grid-left-sidebar.html" class="slider-btn">view collection</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider area end -->

    <!-- banner statistics 01 start -->
    <div class="banner-statistic-one bg-gray pt-100 pb-100 pt-sm-58 pb-sm-58">
        <div class="container">
            <div class="row">
                <div class="col1 col-sm-6">
                    <div class="img-container img-full fix">
                        <a href="#">
                            <img src="{{ url('public') }}/user/img/banner/banner-1.jpg" alt="banner image">
                        </a>
                    </div>
                </div>
                <div class="col2 col-sm-6">
                    <div class="img-container img-full fix">
                        <a href="#">
                            <img src="{{ url('public') }}/user/img/banner/banner-2.jpg" alt="banner image">
                        </a>
                    </div>
                </div>
                <div class="col3 col">
                    <div class="img-container img-full fix mb-30">
                        <a href="#">
                            <img src="{{ url('public') }}/user/img/banner/banner-3.jpg" alt="banner image">
                        </a>
                    </div>
                    <div class="img-container img-full fix">
                        <a href="#">
                            <img src="{{ url('public') }}/user/img/banner/banner-4.jpg" alt="banner image">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- banner statistics 01 end -->

    <!-- featured product area start -->
    <div class="page-section pt-100 pb-14 pt-sm-60 pb-sm-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center pb-44">
                        <p>Các sản phẩm nổi bật mới nhất</p>
                        <h2>Sản phẩm nổi bật</h2>
                    </div>
                </div>
            </div>
            <div class="row product-carousel-one spt slick-arrow-style" data-row="2">
                @foreach($featuredPros as $fp)
                <div class="col">
                    <div class="product-item mb-20">
                        <div class="product-thumb">
                            <a href="{{ route('product_detail',['slug'=>$fp->slug]) }}">
                                <img src="{{ url('public') }}/user/img/product/{{ $fp->image }}"  alt="product image">
                            </a>
                            <div class="box-label">
                                @if($fp->created_at > $mytime)
                                <div class="product-label new">
                                    <span>new</span>
                                </div>
                                @endif
                                @if($fp->priority > 5)
                                <div class="product-label discount">
                                    <span>hot</span>
                                </div>
                                @endif
                                <div class="product-label discount">
                                    <span>-{{ $fp->discount }}%</span>
                                </div>
                            </div>
                            <div class="product-action-link">
                                <a href="" class="quick_view" id="{{$fp->id}}"> <span data-toggle="tooltip" data-placement="left" title="Quick view"><i class="ion-ios-eye-outline"></i></span> </a>
                                <a href="#" data-toggle="tooltip" class="addCompare" id="{{ $fp->id }}" data-placement="left" title="Compare"><i class="ion-ios-loop"></i></a>
                                @if(Session::has('customer'))
                                <input type="hidden" name="customerId" id="customerId" value="{{ Session::get('customer')->id }}">
                                @else
                                <input type="hidden" name="customerId" id="customerId" value="">
                                @endif
                                <a href="#" data-toggle="tooltip"  data-placement="left" class="addWishList" id="{{ $fp->id }}" title="Wishlist"><i class="ion-ios-shuffle"></i></a>
                            </div>
                        </div>
                        <div class="product-description text-center">
                            <div class="manufacturer">
                                <p><a href="{{ route('product_detail',['slug'=>$fp->slug]) }}">{{ $fp->cat->name }}</a></p>
                            </div>
                            <div class="product-name">
                                <h3><a href="{{ route('product_detail',['slug'=>$fp->slug]) }}">{{ $fp->name }}</a></h3>
                            </div>
                            <div class="price-box">
                                <span class="regular-price">{{ number_format($fp->price-($fp->price*(($fp->discount)/100))) }} VNĐ</span>
                                <span class="old-price"><del>{{ number_format($fp->price) }} VNĐ</del></span>
                            </div>
                            <div class="product-btn">
                                <a href="{{ route('product_detail',['slug'=>$fp->slug]) }}"><i class="ion-bag"></i>Mua hàng</a>
                            </div>
                            <div class="hover-box text-center">
                                <div class="ratings">
                                    @foreach($avgs_fp as $avg)
                                    @if($fp->id == $avg['id'])
                                    @for($i = 0;$i < $avg['avg'];$i++)
                                    <span class="good"><i class="fa fa-star"></i></span>
                                    @endfor
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                
            </div>
        </div>
    </div>
    <!-- featured product area end -->

    <!-- block container start -->
    <div class="page-section  bg-gray-light">
        <div class="container-fluid p-0">
            <div class="row no-gutters align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="block-container-banner img-full fix">
                        <a href="#">
                            <img src="{{ url('public') }}/user/img/banner/block-container.jpg" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="bloc-container-inner text-center pt-sm-54 pb-sm-60">
                        <h2>New Fragrances</h2>
                        <p>Diverse variety of perfumes from top brands at the discount prices</p>
                        <a href="shop-grid-left-sidebar.html">SHOP PERFUMES</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- block container end -->

    <!-- banner feature start -->
    <div class="banner-feature-area bg-navy-blue pt-62 pb-60 pt-sm-56 pb-sm-20">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="banner-single-feature text-center mb-sm-30">
                        <i class="ion-paper-airplane"></i>
                        <h4>GIAO HÀNG MIỄN PHÍ VÀ GIAO HÀNG</h4>
                        <p>Chúng tôi là một trong những nhà bán lẻ mỹ phẩm cung cấp dịch vụ giao hàng miễn phí</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="banner-single-feature text-center mb-sm-30">
                        <i class="ion-ios-time-outline"></i>
                        <h4>7 NGÀY THỬ</h4>
                        <p>Chính sách hoàn trả độc đáo của chúng tôi sẽ cho phép bạn trả lại hàng trong vòng một tuần</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="banner-single-feature text-center mb-sm-30">
                        <i class="ion-trophy"></i>
                        <h4>SẢN PHẨM CHÍNH HÃNG</h4>
                        <p>Chúng tôi cam đoan các sản phẩm của chúng tôi chính hãng 100%!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- banner feature end -->

    <!-- feature category area start -->
    <div class="feature-category-area pt-96 pb-14 pt-md-114 pt-sm-54 pb-sm-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tab-menu-one mb-58">
                        <ul class="nav justify-content-center">
                            <li>
                                <a class="active" data-toggle="tab" href="#tab_one">đang giảm giá</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab_two">bán chạy</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab_three">nổi bật</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content text-center">
                        <div class="tab-pane fade show active" id="tab_one">
                            <div class="row feature-category-carousel slick-arrow-style spt">
                                @foreach($salePros as $sp)
                                <div class="col">
                                    <div class="product-item mb-20">
                                        <div class="product-thumb">
                                            <a href="product-details.html">
                                                <img src="{{ url('public') }}/user/img/product/{{ $sp->image }}" alt="product image">
                                            </a>
                                            <div class="box-label">
                                                @if($sp->created_at > $mytime)
                                                <div class="product-label new">
                                                    <span>new</span>
                                                </div>
                                                @endif
                                                @if($sp->priority > 5)
                                                <div class="product-label discount">
                                                    <span>hot</span>
                                                </div>
                                                @endif
                                                <div class="product-label discount">
                                                    <span>-{{ $sp->discount }}%</span>
                                                </div>
                                            </div>
                                            <div class="product-action-link">
                                                <a href="#" class="quick_view" id="{{$sp->id}}"><span data-toggle="tooltip" data-placement="left" title="Quick view"><i class="ion-ios-eye-outline"></i></span> </a>
                                                <a href="#" data-toggle="tooltip" class="addCompare" id="{{ $sp->id }}" data-placement="left" title="Compare"><i
                                                    class="ion-ios-loop"></i></a>
                                                    @if(Session::has('customer'))
                                                        <input type="hidden" name="customerId" id="customerId" value="{{ Session::get('customer')->id }}">
                                                    @else
                                                        <input type="hidden" name="customerId" id="customerId" value="">
                                                    @endif
                                                        <a href="#" data-toggle="tooltip"  data-placement="left" class="addWishList" id="{{ $sp->id }}" title="Wishlist"><i class="ion-ios-shuffle"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-description text-center">
                                            <div class="manufacturer">
                                                <p><a href="{{ route('product_detail',['slug'=>$sp->slug]) }}">{{ $sp->cat->name }}</a></p>
                                            </div>
                                            <div class="product-name">
                                                <h3><a href="{{ route('product_detail',['slug'=>$sp->slug]) }}">{{ $sp->name }}</a></h3>
                                            </div>
                                            <div class="price-box">
                                                <span class="regular-price">{{ number_format($sp->price-($sp->price*($sp->discount/100))) }} VNĐ</span>
                                                <span class="old-price"><del>{{ number_format($sp->price) }} VNĐ</del></span>
                                            </div>
                                            <div class="product-btn">
                                                <a href="{{ route('product_detail',['slug'=>$sp->slug]) }}"><i class="ion-bag"></i>Mua hàng</a>
                                            </div>
                                            <div class="hover-box text-center">
                                                <div class="ratings">
                                                    @foreach($avgs_sp as $avg)
                                                    @if($sp->id == $avg['id'])
                                                    @for($i = 0;$i < $avg['avg'];$i++)
                                                    <span class="good"><i class="fa fa-star"></i></span>
                                                    @endfor
                                                    @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab_two">
                            <div class="row feature-category-carousel slick-arrow-style spt">
                                @foreach($bestSellerPros as $bsp)
                                <div class="col">
                                    <div class="product-item mb-20">
                                        <div class="product-thumb">
                                            <a href="product-details.html">
                                                <img src="{{ url('public') }}/user/img/product/{{ $bsp->image }}" alt="product image">
                                            </a>
                                            <div class="box-label">
                                                @if($bsp->created_at > $mytime)
                                                <div class="product-label new">
                                                    <span>new</span>
                                                </div>
                                                @endif
                                                @if($bsp->priority > 5)
                                                <div class="product-label discount">
                                                    <span>hot</span>
                                                </div>
                                                @endif
                                                <div class="product-label discount">
                                                    <span>-{{ $bsp->discount }}%</span>
                                                </div>
                                            </div>
                                            <div class="product-action-link">
                                                <div class="product-action-link">
                                                    <a href="#" class="quick_view" id="{{$bsp->id}}"> <span data-toggle="tooltip" data-placement="left" title="Quick view"><i class="ion-ios-eye-outline"></i></span> </a>
                                                    <a href="#" data-toggle="tooltip" class="addCompare" id="{{ $bsp->id }}" data-placement="left" title="Compare"><i class="ion-ios-loop"></i></a>
                                                        @if(Session::has('customer'))
                                                            <input type="hidden" name="customerId" id="customerId" value="{{ Session::get('customer')->id }}">
                                                        @else
                                                            <input type="hidden" name="customerId" id="customerId" value="">
                                                        @endif
                                                            <a href="#" data-toggle="tooltip"  data-placement="left" class="addWishList" id="{{ $bsp->id }}" title="Wishlist"><i class="ion-ios-shuffle"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-description text-center">
                                            <div class="manufacturer">
                                                <p><a href="{{ route('product_detail',['slug'=>$bsp->slug]) }}">{{ $bsp->cat->name }}</a></p>
                                            </div>
                                            <div class="product-name">
                                                <h3><a href="{{ route('product_detail',['slug'=>$bsp->slug]) }}">{{ $bsp->name }}</a></h3>
                                            </div>
                                            <div class="price-box">
                                                <span class="regular-price">${{ number_format($bsp->price-($bsp->price*(($bsp->discount)/100))) }}</span>
                                                <span class="old-price"><del>${{ number_format($bsp->price) }}</del></span>
                                            </div>
                                            <div class="product-btn">
                                                <a href="{{ route('product_detail',['slug'=>$bsp->slug]) }}"><i class="ion-bag"></i>Mua hàng</a>
                                            </div>
                                            <div class="hover-box text-center">
                                                <div class="ratings">
                                                    @foreach($avgs_bsp as $avg)
                                                    @if($bsp->id == $avg['id'])
                                                    @for($i = 0;$i < $avg['avg'];$i++)
                                                    <span class="good"><i class="fa fa-star"></i></span>
                                                    @endfor
                                                    @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab_three">
                            <div class="row feature-category-carousel slick-arrow-style spt">
                                @foreach($featuredPros as $fp)
                                <div class="col">
                                    <div class="product-item mb-20">
                                        <div class="product-thumb">
                                            <a href="{{ route('product_detail',['slug'=>$fp->slug]) }}">
                                                <img src="{{ url('public') }}/user/img/product/{{ $fp->image }}" width="200px" alt="product image">
                                            </a>
                                            <div class="box-label">
                                                @if($fp->created_at > $mytime)
                                                <div class="product-label new">
                                                    <span>new</span>
                                                </div>
                                                @endif
                                                @if($fp->priority > 5)
                                                <div class="product-label discount">
                                                    <span>hot</span>
                                                </div>
                                                @endif
                                                <div class="product-label discount">
                                                    <span>-{{ $fp->discount }}%</span>
                                                </div>
                                            </div>
                                            <div class="product-action-link">
                                                <a href="#" class="quick_view" id="{{$fp->id}}"> <span data-toggle="tooltip" data-placement="left" title="Quick view"><i class="ion-ios-eye-outline"></i></span></a>
                                                <a href="#" data-toggle="tooltip" class="addCompare" id="{{ $fp->id }}" data-placement="left" title="Compare"><i class="ion-ios-loop"></i></a>
                                                    @if(Session::has('customer'))
                                                        <input type="hidden" name="customerId" id="customerId" value="{{ Session::get('customer')->id }}">
                                                    @else
                                                        <input type="hidden" name="customerId" id="customerId" value="">
                                                    @endif
                                                        <a href="#" data-toggle="tooltip"  data-placement="left" class="addWishList" id="{{ $fp->id }}" title="Wishlist"><i class="ion-ios-shuffle"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-description text-center">
                                            <div class="manufacturer">
                                                <p><a href="product-details.html">{{ $fp->cat->name }}</a></p>
                                            </div>
                                            <div class="product-name">
                                                <h3><a href="{{ route('product_detail',['slug'=>$fp->slug]) }}">{{ $fp->name }}</a></h3>
                                            </div>
                                            <div class="price-box">
                                                <span class="regular-price">{{ number_format($fp->price-($fp->price*(($fp->discount)/100))) }} VNĐ</span>
                                                <span class="old-price"><del>{{ number_format($fp->price) }} VNĐ</del></span>
                                            </div>
                                            <div class="product-btn">
                                                <a href="{{ route('product_detail',['slug'=>$fp->slug]) }}"><i class="ion-bag"></i>Mua hàng</a>
                                            </div>
                                            <div class="hover-box text-center">
                                                <div class="ratings">
                                                    @foreach($avgs_fp as $avg)
                                                    @if($fp->id == $avg['id'])
                                                    @for($i = 0;$i < $avg['avg'];$i++)
                                                    <span class="good"><i class="fa fa-star"></i></span>
                                                    @endfor
                                                    @endif
                                                    @endforeach
                                                </div>
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
        </div>
    </div>
    <!-- feature category area end -->

    

    

    <!-- latest blog area start -->
    <div class="latest-blog-area pt-100 pb-90 pt-sm-58 pb-sm-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center pb-44">
                        <p>Các tin tức mới của chúng tôi</p>
                        <h2>từ các blog</h2>
                    </div>
                </div>
            </div>
            <div class="blog-carousel-active row slick-arrow-style">
                @foreach($blogs as $blog)
                <div class="col">
                    <div class="blog-item">
                        <article class="blog-post">
                            <div class="blog-post-content">
                                <div class="blog-top">
                                    <div class="post-date-time">
                                        <span>{{ date('d-m-Y', strtotime($blog->created_at)) }}</span>
                                    </div>
                                </div>
                                <div class="blog-thumb img-full">
                                    <a href="{{ route('blog_detail',['title'=>$blog->title,'id' => $blog->id]) }}">
                                        <img src="{{ url('public') }}/user/img/blog/{{ $blog->imageSrc }}" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="blog-content">
                                <h4><a href="{{ route('blog_detail',['title'=>$blog->title,'id' => $blog->id]) }}">{{ $blog->title }}</a></h4>
                                <p>
                                    {{ $blog->notes }}
                                </p>
                            </div>
                        </article>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- latest blog area end -->

@stop()
