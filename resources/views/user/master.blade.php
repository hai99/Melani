<?php session_start(); ?>
<!DOCTYPE blade.php>
<blade.php class="no-js" lang="en">
    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="meta description">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Site title -->
    <title>Melani Beauty Shop | @yield('title')</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ url('public') }}/user/favicon.ico" type="image/x-icon" />
    <!-- Bootstrap CSS -->
    <link href="{{ url('public') }}/user/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font-Awesome CSS -->
    <link href="{{ url('public') }}/user/css/font-awesome.min.css" rel="stylesheet">
    <!-- IonIcon CSS -->
    <link href="{{ url('public') }}/user/css/ionicons.min.css" rel="stylesheet">
    <!-- helper class css -->
    <link href="{{ url('public') }}/user/css/helper.min.css" rel="stylesheet">
    <!-- Plugins CSS -->
    <link href="{{ url('public') }}/user/css/plugins.css" rel="stylesheet">
    <!-- Main Style CSS -->
    <link href="{{ url('public') }}/user/css/style.css" rel="stylesheet">
    <style>
        .media:hover{
            background-color: grey;
            cursor: pointer;
        }   
    </style>   
</head>

<body>
    <!-- header area start -->
    <header>
        <!-- main menu area start -->
        <div class="header-main sticky">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-6 col-6">
                        <div class="logo">
                            <a href="{{ route('home') }}">
                                <img src="{{ url('public') }}/user/img/logo/logo.png" alt="Brand logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 d-none d-lg-block">
                        <div class="main-header-inner">
                            <div class="main-menu">
                                <nav id="mobile-menu">
                                    <ul>
                                        <li class="active"><a href="{{ route('home') }}">Trang chủ</a></li>
                                        <li> <a href="{{ route('all-products') }}">Sản phẩm<i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown">
                                                <?php showCategories2($categories) ?>
                                            </ul>
                                         </li>
                                            
                                        

                                        <?php 
                                            function showCategories2($categories ,$parentId = 0, $ul_class = 'dropdown',$i_class = 'fa fa-angle-right')
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
                                                            if ($itemc['parentId'] == $key['id']) {
                                                                echo '<li>'.'<a href="';
                                                                echo route('get_by_category',['slug'=>$itemc->slug]);
                                                                echo '" class="catId" id="'.$itemc['id'].'">'.$itemc['name'].'<i class="'.$i_class.'">'.'</i>'.'</a>';
                                                                showCategories2($categories, $itemc['id'],'dropdown','fa fa-angle-right');
                                                                echo '</li>';
                                                            }else{
                                                                echo '<li>'.'<a href="';
                                                                echo route('get_by_category',['slug'=>$itemc->slug]);
                                                                echo '" class="catId" id="'.$itemc['id'].'">'.$itemc['name'].'<i class="'.$i_class.'">'.'</i>'.'</a>';
                                                                showCategories2($categories, $itemc['id'],'dropdown','');
                                                                echo '</li>';
                                                            }
                                                        }
                                                        echo '</ul>';
                                                    }

                                                }
                                         ?>

                                        <li><a href="{{ route('blog') }}">Tin tức <i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown">
                                                @foreach($catalogBlogs as $catalogBlog)
                                                <li><a href="{{route('get_by_catalog',['slug' => $catalogBlog->slug])}}">{{ $catalogBlog->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        <li><a href="{{ route('about') }}">Giới thiệu</a></li>
                                        <li><a href="{{ route('contact') }}">Liên hệ</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-6 ml-auto">
                        <div class="header-setting-option">
                            <div class="header-mini-cart">
                                <div class="mini-cart-btn">
                                    <i class="ion-bag"></i>
                                    @if(count($cart->items) > 0)
                                    <span class="cart-notification">{{ count($cart->items) }}</span>
                                    @endif
                                </div>
                                <ul class="cart-list">
                                    @if(count($cart->items) > 0)
                                    @foreach(Session::get('cart') as $item)
                                        <li>
                                            <div class="cart-img">
                                                <a href="{{ route('product_detail',['slug'=>$item['slug']]) }}"><img src="{{ url('public') }}/user/img/product/{{$item['image']}}"
                                                        alt=""></a>
                                            </div>
                                            <div class="cart-info">
                                                <h4><a href="{{ route('product_detail',['slug'=>$item['slug']]) }}">{{$item['name']}}</a></h4>
                                                <span>{{number_format($item['price'])}} VNĐ</span>
                                            </div>
                                            <div class="del-icon">
                                                <i class="fa fa-times"></i>
                                            </div>
                                        </li>
                                    @endforeach
                                    @endif
                                    <li class="mini-cart-price">
                                        <span class="subtotal">tổng tiền : </span>
                                        <span class="subtotal-price ml-auto">{{ number_format($cart->total_amount) }} VNĐ</span>
                                    </li>
                                    <li class="checkout-btn">
                                        <a href="{{route('cart.view')}}">Xem giỏ hàng</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="settings-top">
                                <div class="settings-btn">
                                    <i class="ion-android-settings"></i>
                                </div>
                                <ul class="settings-list">
                                    @if(Session::has('customer'))
                                    <li>
                                        chào {{Session::get('customer')->name}}
                                        <ul>
                                             <form action="" id="logout" method="POST">
                                                @csrf
                                            <li><button type="submit">Đăng xuất</button></li>
                                            </form>
                                        </ul>
                                        <ul>
                                            <li><a href="{{ route('wishlist',['customerId'=>Session::get('customer')->id]) }}">Danh sách ưa thích</a></li>
                                        </ul>
                                        <ul>
                                            <li><a href="{{ route('my_account') }}">Tài khoản</a></li>
                                        </ul>
                                    </li>
                                    @else
                                    <li>
                                        <ul>
                                            <li><a href="" type="button"  id="login" name="login">Đăng nhập</a></li>
                                            <li><a type="button"  href="{{ route('register') }}">Đăng ký</a></li>
                                        </ul>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-block d-lg-none">
                        <div class="mobile-menu"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main menu area end -->

        <!-- login form start -->
        <div class="modal fade" id="modalLogin"  role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"  id="exampleModalLabel" style="margin-top: 10px;text-align: center">Đăng nhập</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="" id="login_form" method="POST">
                    @csrf
                    <div class="single-input-item">
                        <input type="text" id="name" name="name" placeholder="Nhập tên đăng nhập..."  />
                    </div>
                    <div class="single-input-item">
                        <input type="password" id="pass" name="pass" placeholder="Nhập mật khẩu..."  />
                    </div>
                    <div class="single-input-item">
                        <div class="login-reg-form-meta d-flex align-items-center justify-content-between">
                            <a href="" id="forget_password" class="forget-pwd">Quên mật khẩu?</a>
                        </div>
                    </div>
                    <span id="form_result"></span>
                    <div class="modal-footer">
                        <div class="single-input-item">
                            <button type="button" class="sqr-btn" style="background-color: #6c757d;" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="sqr-btn" id="login_button" name="login_button">Đăng nhập</button>
                        </div>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- login form end -->

        <!-- forget password form start -->
        <div class="modal fade" id="modalForgetPassword"  role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"  id="exampleModalLabel" style="margin-top: 10px;text-align: center">Quên mật khẩu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="" id="forget_password_form" method="POST">
                    @csrf
                    <div class="single-input-item">
                        <input type="text" id="email" name="email" placeholder="Nhập email..."  />
                    </div>
                    <div class="single-input-item">
                        <span id="form_foget_password_result"></span>
                    </div>
                    <div class="modal-footer">
                        <div class="single-input-item">
                            <button type="button" class="sqr-btn" style="background-color: #6c757d;" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="sqr-btn" id="forget_password_button" name="forget_password_button">Gửi</button>
                        </div>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- forget password form end -->

       
        </div>

        <form action="{{ route('search_rs') }}" method="POST" style="text-align: center" class="form-inline">
            @csrf
            <div class="form-group">
                <input type="text" style="margin-left: 15%;width: 1000px" class="form-control" name="search" id="search" placeholder="Tìm kiếm sản phẩm...">
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-search" style="font-size: 24px"></i>
            </button>
        </form>
            <div id="search_result" style="position: absolute;z-index: 2;background-color: rgba(2, 10, 0, 0.6);margin-left: 148px;color: white;width: 500px"></div>

    </header>
    <!-- header area end -->


    @yield('main')

    <!-- footer area start -->
    <footer>

        <!-- newsletter area start -->
        <div class="newsletter-area bg-gray pt-64 pb-64 pt-sm-56 pb-sm-58">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="newsletter-inner">
                            <div class="newsletter-title">
                                <h3>newsletter signup</h3>
                            </div>
                            <div class="newsletter-box">
                                <form id="mc-form">
                                    <input type="email" id="mc-email" autocomplete="off" placeholder="Your Email address">
                                    <button class="newsletter-btn" id="mc-submit"><i class="ion-android-send"></i></button>
                                </form>
                            </div>
                        </div>
                        <!-- mailchimp-alerts Start -->
                        <div class="mailchimp-alerts">
                            <div class="mailchimp-submitting"></div><!-- mailchimp-submitting end -->
                            <div class="mailchimp-success"></div><!-- mailchimp-success end -->
                            <div class="mailchimp-error"></div><!-- mailchimp-error end -->
                        </div>
                        <!-- mailchimp-alerts end -->
                    </div>
                    <div class="col-lg-6 col-md-6 ml-auto">
                        <div class="social-share-area">
                            <h3> follow us</h3>
                            <div class="social-icon">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-rss"></i></a>
                                <a href="#"><i class="fa fa-youtube"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- newsletter area end -->

        <!-- footer widget area start -->
        <div class="footer-widget-area pt-62 pb-56 pb-md-26 pt-sm-56 pb-sm-20">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <div class="footer-widget">
                            <div class="footer-widget-title">
                                <h3>Giới thiệu</h3>
                            </div>
                            <div class="footer-widget-body">
                                <ul class="useful-link">
                                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                                    <li><a href="{{ route('about') }}">Giới thiệu</a></li>
                                    <li><a href="{{route('all-products')}}">Sản phẩm</a></li>
                                    <li><a href="{{route('blog')}}">Tin tức</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <div class="footer-widget">
                            <div class="footer-widget-title">
                                <h3>Chính sách</h3>
                            </div>
                            <div class="footer-widget-body">
                                <ul class="useful-link">
                                    <li><a href="{{route('faq')}}">Faq</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <div class="footer-widget">
                            <div class="footer-widget-title">
                                <h3>Hỗ trợ khách hàng</h3>
                            </div>
                            <div class="footer-widget-body">
                                <ul class="useful-link">
                                    <li><a href="" type="button" id="login" name="login">Đăng nhập</a></li>
                                    <li><a href="{{ route('register') }}" >Đăng ký</a></li>
                                    <li><a href="{{route('cart.view')}}">Giỏ hàng</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="footer-widget">
                            <div class="footer-widget-title">
                                <div class="footer-logo">
                                    <a href="index.blade.php">
                                        <img src="{{ url('public') }}/user/img/logo/logo.png" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="footer-widget-body">
                                <ul class="address-box">
                                    <li>
                                        <span>ADDRESS:</span>
                                        <p>Melani - Responsive Prestashop Theme<br>
                                        169-C, Technohub, Dubai Silicon</p>
                                    </li>
                                    <li>
                                        <span>call us now:</span>
                                        <p>+880123456789</p>
                                    </li>
                                    <li>
                                        <span>email:</span>
                                        <p>demo@yourdomain.com</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer widget area end -->

        <!-- footer botton area start -->
        <div class="footer-bottom-area">
            <div class="container">
                <div class="bdr-top pt-18 pb-18">
                    <div class="row align-items-center">
                        <div class="col-md-6 order-2 order-md-1">
                            <div class="copyright-text">
                                <p>copyright <a href="#">HasTech</a>. All Rights Reserved</p>
                            </div>
                        </div>
                        <div class="col-md-6 ml-auto order-1 order-md-2">
                            <div class="footer-payment">
                                <img src="{{ url('public') }}/user/img/payment.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer botton area end -->

    </footer>
    <!-- footer area end -->

    <!-- Quick view modal start -->
    <div class="modal quick_view_modal" id="quick_view">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <!-- product details inner end -->
                    <div class="product-details-inner">
                        <div class="row">
                            <div class="col-lg-5 col-md-5">
                                <div class="product-large-slider mb-20 slider-arrow-style slider-arrow-style__style-2">
                                    <div class="pro-large-img">
                                        <img src="{{ url('public') }}/user/img/product/" id="quick_image" alt="" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7">
                                <div class="product-details-des pt-sm-30">
                                    <h3 id="quick_name"></h3>
                                    <p id="quick_description"></p>
                                    <div class="share-icon">
                                        <h5>chia sẻ:</h5>
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
                </div>
            </div>
        </div>
    </div>
    <!-- Quick view modal end -->

    <!-- Popup Subscribe Box Start -->
    
    <!-- Popup Subscribe Box End -->

    <!-- Scroll to top start -->
    <div class="scroll-top not-visible">
        <i class="fa fa-angle-up"></i>
    </div>
    <!-- Scroll to Top End -->



    <!--All jQuery, Third Party Plugins & Activation (main.js) Files-->
    <script src="{{ url('public') }}/user/js/vendor/modernizr-3.6.0.min.js"></script>
    <!-- Jquery Min Js -->
    <script src="{{ url('public') }}/user/js/vendor/jquery-3.3.1.min.js"></script>
    <!-- Popper Min Js -->
    <script src="{{ url('public') }}/user/js/vendor/popper.min.js"></script>
    <!-- Bootstrap Min Js -->
    <script src="{{ url('public') }}/user/js/vendor/bootstrap.min.js"></script>
    <!-- Plugins Js-->
    <script src="{{ url('public') }}/user/js/plugins.js"></script>
    <!-- Ajax Mail Js -->
    <script src="{{ url('public') }}/user/js/ajax-mail.js"></script>
    <!-- Active Js -->
    <script src="{{ url('public') }}/user/js/main.js"></script>
    <script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
    <script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
    <script>
        $('#forget_password').on('click',function(event){
            event.preventDefault();
            $('#modalForgetPassword').modal('show');
            $('#modalLogin').modal('hide');
            $('#form_foget_password_result').html('');
        });

        $('#forget_password_form').on('submit',function(event){
            event.preventDefault();
            var data = new FormData(this);
            for (var value of data.values()) {
                console.log(value);
            }
            $.ajax({
                url: "{{ route('forget_password') }}",
                method: "POST",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success:function(data){
                    var html = '';
                    if (data.errors) {
                        html = '<div class="alert alert-danger">';
                        for (var count = 0; count < data.errors.length; count++) {
                            html+='<p>'+data.errors[count]+'</p>';
                        }
                        html+='</div>';
                        $('#form_foget_password_result').html(html);
                    }
                    if (data.error) {
                        html = '<div class="alert alert-danger">';
                        html+='<p>'+data.error+'</p>';
                        html+='</div>';
                        $('#form_foget_password_result').html(html);
                    }
                    if (data.success) {
                        $('#email').val('');
                        html = '<div class="alert alert-success">';
                        html+='<p>'+data.success+'</p>';
                        html+='</div>';
                        $('#form_foget_password_result').html(html);
                    }
                }
            });
        });

        $(document).on('click','#login',function(event){
            event.preventDefault();
            $('#modalLogin').modal('show');
            $('#modalForgetPassword').modal('hide');
        });
        $('#login_form').on('submit',function(event){
            event.preventDefault();
            $.ajax({
            url: "{{ route('cus.login') }}",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success:function(data){
                var html = '';
               if (data.errors) {
                    html = '<div class="alert alert-danger">';
                    for (var count = 0; count < data.errors.length; count++) {
                        html+='<p>'+data.errors[count]+'</p>';
                    }
                    html+='</div>';
               }
               if (data.error) {
                html='<div class="alert alert-danger">'+data.error+'</div>';
               }
               if (data.success) {
                // html='<div class="alert alert-success">'+data.success+'</div>';
                // swal("",data.success,"success");
                 const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1000
                    });
                Toast.fire({
                           type: 'success',
                           title: data.success
                });
                location.reload();
                $('#modalLogin').modal('hide');
               }
               $('#form_result').html(html);
            }
            });
        });
        $('#logout').on('submit',function(event){
            event.preventDefault();
            $.ajax({
                url: "{{ route('cus.logout') }}",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
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
                        window.location.href = "http://localhost:88/project/";
                    }
                }
            });
        });
            
        $('#search').on('keyup',function(){
            $value = $(this).val();
            if ($value!='') {
                $.ajax({
                    type: 'get',
                    url: '{{ URL::to('search') }}',
                    data: {
                        'search': $value
                    },
                    success:function(data){
                        $('#search_result').fadeIn();
                        $('#search_result').html(data);
                    }
                });
            }
            else{
                $('#search_result').fadeOut();
            }
        });
        $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });

        // $(document).ready(function() {
        //     $('.catId').on('click',function(){
        //         var cat = $(this).attr('id');
        //        console.log(cat);
        //         $.ajax({
        //               type: 'get',
        //               dataType: 'html',
        //               url: '{{url('/productsCat')}}',
        //               data: 'cat_id=' + cat,
        //               success:function(response){
        //                 console.log(response);
        //                 $("#productData").html(response);
        //               }
        //             });
        //     });
        // });

    $(document).on('click','.addCompare',function(event){
        event.preventDefault();
        var data = new FormData();
        data.append('productId',$(this).attr('id'));
        data.append('_token',$("meta[name='csrf-token']").attr("content"));
        $.ajax({
            url: "{{ route('addCompare') }}",
            method: "POST",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(data){
                if (data.error) {
                    alert(data.error);
                }
                if (data.error1) {
                    alert(data.error1);
                }
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

    $(document).on('click','.addWishList',function(event){
        event.preventDefault();
        var data = new FormData();
        data.append('productId',$(this).attr('id'));
        data.append('customerId',$('input[name="customerId"]').val());
        data.append('_token',$("meta[name='csrf-token']").attr("content"));
        $.ajax({
            url: "{{ route('add.wishlist') }}",
            method: "POST",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(data){
                if(data.errors){
                    alert(data.errors);
                    $('#modalLogin').modal('show');
                }
                if(data.error){
                    alert(data.error);
                }
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

    $(document).on('click','.quick_view',function(event){
        event.preventDefault();
        var data = new FormData();
        data.append('id',$(this).attr('id'));
        data.append('_token',$("meta[name='csrf-token']").attr("content"));
        for (var value of data.values()) {
           console.log(value); 
        }
        $.ajax({
            url: "{{ route('quick_view') }}",
            method: "POST",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(html){
                $('#quick_image').attr('src','{{ url('public') }}/user/img/product/'+html.data.image);
                $('#quick_name').text(html.data.name);
                $('#quick_description').text(html.data.description);
            }
        });
        $('#quick_view').modal('show');
    });

    </script>

    @yield('js')
</body>
@include('sweetalert::alert')

</blade.php>