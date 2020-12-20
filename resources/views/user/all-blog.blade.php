@extends('user\master')
@section('title','Tin tức')
@section('main')
<!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ </a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    @if(isset($catalogBlogByName))
                                        {{$catalogBlogByName->name}}
                                    @else
                                        tin tức
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
                            <h4 class="title">Danh mục tin tức</h4>
                            <ul class="blog-archive">
                                @foreach($catalogBlogs as $catalogBlog)
                                <li><a href="{{route('get_by_catalog',['slug' => $catalogBlog->slug])}}">{{ $catalogBlog->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="blog-sidebar">
                            <h4 class="title">Tin tức mới nhất</h4>
                            <div class="popular-item-inner popular-item-inner__style-2">
                                @foreach($recentBlogs as $rb)
                                <div class="popular-item">
                                    <div class="pop-item-thumb">
                                        <a href="{{ route('blog_detail',['title'=>$rb->title,'id' => $rb->id]) }}">
                                            <img src="{{url('public')}}/user/img/blog/{{$rb->imageSrc}}" alt="">
                                        </a>
                                    </div>
                                    <div class="pop-item-des">
                                        <h4><a href="{{ route('blog_detail',['title'=>$rb->title,'id' => $rb->id]) }}">{{$rb->title}}</a></h4>
                                        <span class="pop-price">{{ date('d-m-Y', strtotime($rb->created_at)) }}</span>
                                    </div>
                                </div> <!-- end single popular item -->
                                @endforeach
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
                                    <img src="{{url('public')}}/user/img/banner/advertising.jpg" alt="">
                                </a>
                            </div>
                        </div> <!-- single sidebar end -->
                    </div>
                </div>
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="blog-wrapper">
                        <div class="row">
                            @foreach($blogs as $blog)
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="blog-item-single">
                                    <article class="blog-post">
                                        <div class="blog-post-content">
                                            <div class="blog-top">
                                                <div class="post-date-time">
                                                    <span>{{ date('d-m-Y', strtotime($blog->created_at)) }}</span>
                                                </div>
                                            </div>
                                            <div class="blog-thumb img-full">
                                                <a href="{{ route('blog_detail',['title'=>$blog->title,'id' => $blog->id]) }}">
                                                    <img src="{{url('public')}}/user/img/blog/{{ $blog->imageSrc }}" alt="">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="blog-content">
                                            <h4><a href="{{ route('blog_detail',['title'=>$blog->title,'id' => $blog->id]) }}">{{ $blog->title }}</a></h4>
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
                        {{$blogs->links()}}
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