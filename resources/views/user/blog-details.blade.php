@extends('user/master')
@section('title','Đọc tin tức')
@section('main')

    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $blog->title }}</li>
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
                            <div class="blog-item-single">
                                <article class="blog-post blog-details">
                                    <div class="blog-post-content">
                                        <div class="blog-top">
                                            <div class="post-date-time">
                                                <span>{{ date('d-m-Y', strtotime($blog['created_at'])) }}</span>
                                            </div>
                                        </div>
                                        <div class="blog-thumb">
                                            <div class="blog-gallery-slider slider-arrow-style slider-arrow-style__style-2">
                                                <div class="blog-single-slide">
                                                    <img src="{{url('public')}}/user/img/blog/{{ $blog['imageSrc'] }}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="blog-content blog-details">
                                        <h4>{{ $blog['title'] }}</h4>
                                        <p>{{ $blog['content'] }}</p>
                                    </div>
                                    <div class="tag-line">
                                        <h4>tag:</h4>
                                        <a href="#">dry food</a>,
                                        <a href="#">wet food</a>,
                                        <a href="#">reach food</a>,
                                    </div>
                                    <div class="blog-sharing text-center">
                                        <h4>share this post:</h4>
                                        <a href="#"><i class="fa fa-facebook"></i></a>
                                        <a href="#"><i class="fa fa-twitter"></i></a>
                                        <a href="#"><i class="fa fa-pinterest"></i></a>
                                        <a href="#"><i class="fa fa-google-plus"></i></a>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <!-- comment area start -->
                        <div class="comment-section">
                            <h3>{{count($comments)}} bình luận</h3>
                            <?php showComments($comments) ?>
                            <style>
                                .style_div{
                                    margin-bottom: 20px !important;
                                }
                                .style_ul{
                                    border: none !important;
                                }
                                .style_li{
                                    display: block !important;
                                }
                                .avatar_style{
                                    width: 50px;
                                      height: 50px;
                                      border-radius: 50%;
                                      margin-bottom: 15px;
                                }
                                .media:hover{
                                    background-color: white !important;
                                }
                            </style>
                            <?php 
                                function showComments($comments,$parentId = 0){
                                    $replies = array();
                                    foreach ($comments as $key => $item) {
                                        if ($item['parentId'] == $parentId) {
                                            $replies[] = $item;
                                            unset($comments[$key]);
                                        }
                                    }
                                    if ($replies) {
                                        echo '<ul class="style_ul">';
                                        foreach ($replies as $key => $itemc) {
                                            echo '<li class="style_li">';
                                            echo '<div class="style_div">';
                                            echo '<div class="media">';
                                            echo '<div class="author-avatar">'.'<img class="rounded-circle avatar_style" src="'.url('public').'/user/img/avatar/'.$itemc['avatar'].'" alt="">'.'</div>';
                                            echo '<div class="media-body">';
                                            echo '<div class="comment-body"><span class="reply-btn"><a onClick="postReply('.$itemc['id'].')">Trả lời</a></span>';
                                            echo '<h5 class="comment-author">'.$itemc['name'].'</h5>';
                                            echo '<div class="comment-post-date">Ngày đăng: '.$itemc['created_at']->format('d-m-Y').'</div>';
                                            echo '<p>'.$itemc['content'].'</p>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            showComments($comments,$itemc['id']);
                                            echo '</li>';
                                        }
                                        echo '</ul>';
                                    }
                                }
                             ?>
                        </div>
                        <!-- comment area end -->
                        <!-- start blog comment box -->
                        <div class="blog-comment-wrapper mb-sm-6">
                            <h3>Hãy để lại bình luận!</h3>
                            <form action="" method="POST" id="comment_post">
                                @csrf
                                <div class="comment-post-box">
                                    <div class="row">
                                        <div class="col-12">
                                            <label>bình luận</label>
                                            <textarea name="commnet" id="content" placeholder="Viết bình luận tại đây..."></textarea>
                                        </div>
                                        <div class="col-12">
                                            <div class="coment-btn mt-20">
                                            @if(Session::has('customer'))
                                            <span id="form_comment_result"></span>
                                            <input class="sqr-btn" type="submit" name="submit" value="Đăng">
                                            <input type="hidden" id="customerId" value="{{ Session::get('customer')->id }}" name="">
                                            <input type="hidden" id="blogId" value="{{ $blog['id'] }}" name="">
                                            <input type="hidden" id="parentId" value="0" name="">
                                            @else
                                            <input type="hidden" id="customerId" value="" name="">
                                            <input class="sqr-btn" type="submit" name="submit" value="Đăng">
                                            @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- start blog comment box -->
                    </div>
                </div>
            </div>
        </div>
        <!-- blog main wrapper end -->
    </main>
    <!-- page main wrapper end -->
@stop
@section('js')
<script>
    function postReply(commentId) {
        $('#parentId').val(commentId);
        $("#content").focus();
        console.log(commentId);
    }

    $('#comment_post').on('submit',function(event){
        event.preventDefault();
        if ($('#customerId').val() == '') {
            alert('Bạn chưa đăng nhập');
            $('#modalLogin').modal('show');
        }else{
            var data = new FormData();
            data.append('content',$('#content').val());
            data.append('customerId',$('#customerId').val());
            data.append('blogId',$('#blogId').val());
            data.append('parentId',$('#parentId').val());
            data.append('_token',$("meta[name='csrf-token']").attr("content"));
            for (var value of data.values()) {
               console.log(value); 
            }
            $.ajax({
                url: "{{ route('post_comment') }}",
                method: "POST",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success:function(data){
                    var html = '';
                    if (data.errors) {
                        html += '<div class="alert alert-danger">';
                        for (var count = 0; count < data.errors.length; count++) {
                            html += '<p>'+data.errors[count]+'</p>';
                        }
                        html += '</div>';
                        $('#form_comment_result').html(html);
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
        }
    });
    
</script>
@stop