@extends('user\master')
@section('title','Tìm kiếm tin tức')
@section('main')
<!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Trang chủ </a></li>
                                <li class="breadcrumb-item active" aria-current="page">Tìm kiếm tin tức</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->
<main>
    <!-- blog main wrapper start -->
    <div class="blog-main-wrapper pt-100 pb-100 pt-sm-58 pb-sm-58">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 order-2 order-lg-1">
                    <div class="blog-sidebar-wrapper mt-md-100 mt-sm-58">
                        <div class="blog-sidebar">
                            <div class="sidebar-serch-form">
                                <form action="{{ route('search_rs_blog') }}" method="POST">
                                    @csrf
                                    <input type="text" name="search_blog" id="search_blog" class="search-field" placeholder="Tìm kiếm tin tức...">
                                    <button type="submit" class="search-btn"><i class="fa fa-search"></i></button>
                                </form>
                                <div id="search_result_blog" style="position: absolute;z-index: 2;background-color: rgba(2, 10, 0, 0.6);color: white;width: 500px"></div>
                            </div>
                        </div> <!-- single sidebar end -->
                        <div class="blog-sidebar">
                            <h4 class="title">categories</h4>
                            <ul class="blog-archive">
                                <li><a href="#">Health & beauty (10)</a></li>
                                <li><a href="#">Makeup (08)</a></li>
                                <li><a href="#">Skincare (07)</a></li>
                                <li><a href="#">Jewelry (14)</a></li>
                                <li><a href="#">fashion (10)</a></li>
                            </ul>
                        </div> <!-- single sidebar end -->
                        <div class="blog-sidebar">
                            <h4 class="title">Blog Archives</h4>
                            <ul class="blog-archive">
                                <li><a href="#">January (10)</a></li>
                                <li><a href="#">February (08)</a></li>
                                <li><a href="#">March (07)</a></li>
                                <li><a href="#">April (14)</a></li>
                                <li><a href="#">May (10)</a></li>
                            </ul>
                        </div> <!-- single sidebar end -->
                        <div class="blog-sidebar">
                            <h4 class="title">recent post</h4>
                            <div class="popular-item-inner popular-item-inner__style-2">
                                <div class="popular-item">
                                    <div class="pop-item-thumb">
                                        <a href="blog-details.html">
                                            <img src="{{'public'}}/user/img/product/product-6.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="pop-item-des">
                                        <h4><a href="blog-details.html">Arbor Swoon Camber</a></h4>
                                        <span class="pop-price">$50.00</span>
                                    </div>
                                </div> <!-- end single popular item -->
                                <div class="popular-item">
                                    <div class="pop-item-thumb">
                                        <a href="blog-details.html">
                                            <img src="{{'public'}}/user/img/product/product-7.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="pop-item-des">
                                        <h4><a href="blog-details.html">Arbor Swoon Camber</a></h4>
                                        <span class="pop-price">$50.00</span>
                                    </div>
                                </div> <!-- end single popular item -->
                                <div class="popular-item">
                                    <div class="pop-item-thumb">
                                        <a href="blog-details.html">
                                            <img src="{{'public'}}/user/img/product/product-8.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="pop-item-des">
                                        <h4><a href="blog-details.html">Arbor Swoon Camber</a></h4>
                                        <span class="pop-price">$50.00</span>
                                    </div>
                                </div> <!-- end single popular item -->
                            </div>
                        </div> <!-- single sidebar end -->
                        <div class="blog-sidebar">
                            <h4 class="title">Tags</h4>
                            <ul class="blog-tags">
                                <li><a href="#">camera</a></li>
                                <li><a href="#">computer</a></li>
                                <li><a href="#">watch</a></li>
                                <li><a href="#">smartphone</a></li>
                                <li><a href="#">bag</a></li>
                                <li><a href="#">shoes</a></li>
                            </ul>
                        </div> <!-- single sidebar end -->
                        <div class="blog-sidebar">
                            <h4 class="title">image</h4>
                            <div class="advertising-thumb img-full fix">
                                <a href="#">
                                    <img src="{{'public'}}/user/img/banner/advertising.jpg" alt="">
                                </a>
                            </div>
                        </div> <!-- single sidebar end -->
                    </div>
                </div>
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="blog-wrapper">
                        <div class="row">
                            @foreach($listBlog as $blog)
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="blog-item-single">
                                    <article class="blog-post">
                                        <div class="blog-post-content">
                                            <div class="blog-top">
                                                <div class="post-date-time">
                                                    <span>{{ date('d-m-Y', strtotime($blog->created_at)) }}</span>
                                                </div><!-- 
                                                <div class="post-blog-meta">
                                                    <p>post by <a href="#">HasTech</a></p>
                                                </div> -->
                                            </div>
                                            <div class="blog-thumb img-full">
                                                <a href="{{ route('blog_detail',['title'=>$blog->title,'id' => $blog->id]) }}">
                                                    <img src="{{url('public')}}/user/img/blog/{{ $blog->imageSrc }}" alt="">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="blog-content">
                                            <h4><a href="blog-details.html">{{ $blog->title }}</a></h4>
                                            <p>
                                                {{ $blog->notes }}
                                            </p>
                                            <a href="{{ route('blog_detail',['title'=>$blog->title,'id' => $blog->id]) }}" class="read-more">Đọc thêm...</a>
                                        </div>
                                    </article>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- start pagination area -->
                    <div class="paginatoin-area text-center mt-18">
                        {{$listBlog->links()}}
                    </div>
                    <!-- end pagination area -->
                </div>
            </div>
        </div>
    </div>
    <!-- blog main wrapper end -->
</main>

@stop
@section('js')
<script>
    $('#search_blog').on('keyup',function(){
            $value = $(this).val();
            if ($value!='') {
                $.ajax({
                    type: 'get',
                    url: '{{ URL::to('search_blog') }}',
                    data: {
                        'search_blog': $value
                    },
                    success:function(data){
                        $('#search_result_blog').fadeIn();
                        $('#search_result_blog').html(data);
                    }
                });
            }
            else{
                $('#search_result_blog').fadeOut();
            }
        });
        $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>
@stop