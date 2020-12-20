
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Trang quản trị | Đăng nhập</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
 <link rel="stylesheet" href="{{url('/public/admin')}}/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{url('/public/admin')}}/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{url('/public/admin')}}/css/AdminLTE.css">
  <link rel="stylesheet" href="{{url('/public/admin')}}/css/_all-skins.min.css">
  <link rel="stylesheet" href="{{url('/public/admin')}}/css/style.css" />
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href=""><b>Đăng nhập Admin</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">

    <form action="{{ route('login') }}" method="post">
      @csrf
      <div class="form-group has-feedback <?php if($errors->has('name')): ?> has-error <?php endif; ?>">
        <input type="text" class="form-control" name="name" placeholder="Tên đăng nhập...">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        @if($errors->has('name'))
          {{$errors->first('name')}}
        @endif
      </div>
      <div class="form-group has-feedback <?php if($errors->has('password')): ?> has-error <?php endif; ?>">
        <input type="password" class="form-control" name="password" placeholder="Mật khẩu...">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if($errors->has('password'))
          {{$errors->first('password')}}
        @endif
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="remember"> Nhớ mật khẩu
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Đăng nhập</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <div class="social-auth-links text-center">
      <p>- HOẶC -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Đăng nhập bằng
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Đăng nhập bằng
        Google+</a>
    </div>
    <!-- /.social-auth-links -->

    <a href="#">Quên mật khẩu</a><br>
    <a href="register.html" class="text-center">Register a new membership</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<script src="{{ url('/public/admin') }}/js/jquery.min.js"></script>
<script src="{{url('/public/admin')}}/js/bootstrap.min.js"></script>
<script src="{{url('/public/admin')}}/js/adminlte.min.js"></script>
</body>
</html>
