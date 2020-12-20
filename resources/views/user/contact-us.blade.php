@extends('user\master')
@section('title','Liên hệ')
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
                                <li class="breadcrumb-item active" aria-current="page">Liên hệ</li>
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
        <!-- contact wrapper area start -->
    <div class="contact-top-area pt-100 pb-98 pt-sm-58 pb-sm-58">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center pb-44">
                        <p>liên hệ</p>
                        <h2>Liên hệ với chúng tôi</h2>
                    </div>
                </div>
            </div> <!-- section title end -->
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="contact-single-info mb-30 text-center">
                        <div class="contact-icon">
                            <i class="fa fa-map-marker"></i>
                        </div>
                        <h3>Địa chỉ</h3>
                        <p>Địa chỉ : No 40 Baria Sreet<br>NewYork City, United States.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="contact-single-info mb-30 text-center">
                        <div class="contact-icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <h3>Số điện thoại</h3>
                        <p>Số điện thoại 1: 0(1234) 567 89012<br>Số điện thoại 2: 0(987) 567 890</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="contact-single-info mb-30 text-center">
                        <div class="contact-icon">
                            <i class="fa fa-fax"></i>
                        </div>
                        <h3>Số fax</h3>
                        <p>Fax 1: 0(1234) 567 89012<br>Fax 2: 0(987) 567 890</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="contact-single-info mb-30 text-center">
                        <div class="contact-icon">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <h3>Địa chỉ email</h3>
                        <p>melanibeautyshop@gmail.com</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-10 col-lg-12 m-auto">
                    <div class="contact-message pt-60 pt-sm-20">
                        <form id="contact-form" method="post" action="" class="contact-form">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input id="conName" placeholder="Nhập tên *" type="text">    
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input id="phoneNumber" placeholder="Nhập số điện thoại *" type="text">   
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input id="email" placeholder="Nhập email *" type="text">    
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input id="conSubject" placeholder="Nhập tiêu đề *" type="text">   
                                </div>
                               <div class="col-12">
                                    <div class="contact2-textarea text-center">
                                        <textarea placeholder="Nhập nội dung *" id="conMessage"  class="form-control2"></textarea>     
                                    </div>   
                                    <span class="form-messege-result"></span>
                                    <div class="contact-btn text-center">
                                        <button class="check-btn sqr-btn" id="sendContact" type="submit">Gửi</button> 
                                    </div> 
                                </div> 
                                <div class="col-12 d-flex justify-content-center">
                                </div>
                            </div>
                        </form>
                    </div> 
               </div>
           </div>
        </div>
    </div>
    <!-- contact wrapper area end -->
    </main>
    <!-- page main wrapper end -->
@stop
@section('js')
<script>
    $('#contact-form').on('submit',function(event){
        event.preventDefault();
        var data = new FormData();
        data.append('_token',$("meta[name='csrf-token']").attr("content"));
        data.append('name',$('#conName').val());
        data.append('phoneNumber',$('#phoneNumber').val());
        data.append('email',$('#email').val());
        data.append('conSubject',$('#conSubject').val());
        data.append('conMessage',$('#conMessage').val());
        for (var value of data.values()) {
           console.log(value); 
        }
        $.ajax({
            url: "{{ route('contact.send') }}",
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
                        $('.form-messege-result').html(html);
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

