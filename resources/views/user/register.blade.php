@extends('user\master')
@section('title','Đăng ký')
@section('main')
    <style>
.md-avatar.size-4 {
  width: 110px;
  height: 110px;
}
</style>    
<!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Đăng ký</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

<div class="login-register-wrapper pt-100 pb-100 pt-sm-58 pb-sm-58">
    <div class="container">
        <div class="member-area-from-wrap">
            <div class="row">
                <!-- Register Content Start -->
                    <div class="col-lg-6" style="margin-left: 26%;">
                        <div class="login-reg-form-wrap mt-md-100 mt-sm-58" style="width: 100%">
                            <h2 style="text-align: center">Đăng ký tài khoản</h2>
                            <form action="" id="registerForm" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="single-input-item">
                                    <input type="text" name="name" placeholder="Nhập tên đăng nhập..."  />
                                </div>
                                <div class="single-input-item">
                                    <input type="text" name="email" placeholder="Nhập email..."  />
                                </div>
                                <div class="single-input-item">
                                    <input type="text" name="phoneNumber" placeholder="Nhập số điện thoại..."  />
                                </div>
                                <div class="single-input-item">
                                    <input type="text" name="address" placeholder="Nhập địa chỉ..."  />
                                </div>
                                <div class="single-input-item">
                                    <input type="file" name="avatar" id="avatar" placeholder="Input field">
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="single-input-item">
                                            <input type="password" name="pass" placeholder="Nhập mật khẩu..."  />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="single-input-item">
                                            <input type="password" name="confirm_pass" placeholder="Nhập lại mật khẩu..."  />
                                        </div>
                                    </div>
                                </div>
                                <div class="single-input-item">
                                    <span id="form_result2"></span>
                                </div>
                                <div class="single-input-item">
                                    <button type="submit" class="sqr-btn">Đăng ký</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <!-- Register Content End -->
            </div>
        </div>
    </div>
</div>

@stop
@section('js')
<script>
    $('#registerForm').on('submit',function(event){
        event.preventDefault();
        // var name = $('#name').val();
        // var email = $('#email').val();
        // var phoneNumber = $('#phoneNumber').val();
        // var address = $('#address').val();
        // var pass = $('#pass').val();
        var data = new FormData(this);
        data.append('avatar',$('#avatar').val());
        $.ajax({
            url: "{{ route('cus.reg') }}",
            method: "POST",
            data: data,
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
                    location.reload();
                }
                $('#form_result2').html(html);
            }
        });
    });
</script>
@include('sweetalert::alert')
@stop