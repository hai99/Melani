<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Quản trị | @yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{url('/public/admin')}}/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{url('/public/admin')}}/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{url('/public/admin')}}/css/AdminLTE.css">
  <link rel="stylesheet" href="{{url('/public/admin')}}/css/_all-skins.min.css">
  <link rel="stylesheet" href="{{url('/public/admin')}}/css/style.css" />
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
  @yield('css')
  <script type="text/javascript">
    var base_url = function(){
      return "{{url('')}}";
    }
    var akey = function(){
      return '8H4BxG48c6pyq9lwdUSfCn0kKD0BKkOctrNQZsn73Y';
    }
  </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="../../index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">{{count($contacts)}}</span>
            </a>
            <ul class="dropdown-menu">
              @if(count($contacts) > 0)
              <li class="header">Bạn có {{count($contacts)}} thư mới</li>
              @else
              <li class="header">Bạn chưa có thư mới nào</li>
              @endif
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  @foreach($contacts as $contact)
                  <li><!-- start message -->
                    <a href="#">
                      <h4>
                        {{$contact->name}}
                        <small><i class="fa fa-clock-o"></i><?php time_since1($today1-strtotime($contact->created_at)) ?> trước</small>
                      </h4>
                      <p>{{$contact->conSubject}}</p>
                    </a>
                  </li>
                  <!-- end message -->
                  @endforeach
                  <?php 
                    function time_since1($since) {
                        $chunks = array(
                            array(60 * 60 * 24 * 365 , 'năm'),
                            array(60 * 60 * 24 * 30 , 'tháng'),
                            array(60 * 60 * 24 * 7, 'tuần'),
                            array(60 * 60 * 24 , 'ngày'),
                            array(60 * 60 , 'giờ'),
                            array(60 , 'phút'),
                            array(1 , 'giây')
                        );

                        for ($i = 0, $j = count($chunks); $i < $j; $i++) {
                            $seconds = $chunks[$i][0];
                            $name = $chunks[$i][1];
                            if (($count = floor($since / $seconds)) != 0) {
                                break;
                            }
                        }

                        $print = ($count == 1) ? '1 '.$name : "$count {$name}";
                        echo $print;
                        return $print;
                    }
                 ?>
                </ul>
              </li>
              @if(count($contacts) > 0)
              <li class="footer"><a href="{{ route('contact.index') }}">Xem tất cả</a></li>
              @else
              <li class="footer"><a href="{{ route('contact.index') }}">Hòm thư</a></li>
              @endif
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Create a nice theme
                        <small class="pull-right">40%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">40% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Some task I need to do
                        <small class="pull-right">60%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Make beautiful transitions
                        <small class="pull-right">80%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">80% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs">Chào {{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-body">
                  <a href="#" class="btn btn-default btn-flat">Thông tin</a>
                  <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Đăng xuất</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
<style>
  .btn.btn-flat {
    margin-bottom: 5px !important;
}
</style>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <?php 
      $name = Auth::user()->getRoleNames();
      $id = \Spatie\Permission\Models\Role::whereIn('name',$name)->pluck('id');
      $rolePermission = \Spatie\Permission\Models\Permission::join('role_has_permissions','role_has_permissions.permission_id','=','permissions.id')->whereIn('role_has_permissions.role_id',$id)->pluck('name');
     ?>
    <section class="sidebar">
      <?php $menus = config('AdminMenu'); ?>
      <ul class="sidebar-menu tree" data-widget="tree">
        <li class="header">
          <a href="{{ route('admin') }}">
            <i class="fa fa-home"></i> <span>TRANG CHỦ</span>
          </a>
        </li>
      </ul>
      <ul class="sidebar-menu" data-widget="tree">
        @foreach($menus as $key => $mn)
        <?php $class = !empty($mn['items']) ? 'treeview' : ''; ?>
          @if($class == 'treeview')
            @if(!empty($mn['list']))
              @foreach($mn['list'] as $t)
                @if($rolePermission->contains($t))
                  <li class="{{$class}}">
                    <a href="#">
                      <i class="fa {{ $mn['icon'] }}"></i> <span>{{ $mn['name'] }}</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                      <ul class="treeview-menu">
                        @foreach($mn['items'] as $item)
                          @if(!empty($item['list']))
                            @foreach($item['list'] as $n)
                              @if($rolePermission->contains($n))
                                <li><a href="{{ $item['route'] }}"><i class="fa {{ $item['icon'] }}"></i>{{ $item['name'] }}</a></li>
                                @break
                              @endif
                            @endforeach
                          @endif
                        @endforeach
                      </ul>
                  </li>
                  @break
                @endif
              @endforeach
            @endif
          @else
            @if(!empty($mn['list']))
              @foreach($mn['list'] as $t)
                @if($rolePermission->contains($t))
                  <li class="{{$class}}">
                    <a href="#">
                      <i class="fa {{ $mn['icon'] }}"></i> <span>{{ $mn['name'] }}</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                  </li>
                  @break
                @endif
              @endforeach
            @endif
          @endif
        @endforeach
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      
      <!-- /.row -->

      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              @yield('search-add')
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              @yield('main')
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <div class="box-footer">
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Main row -->
     
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.13
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
    reserved.
  </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->



 <script src="{{ url('/public/admin') }}/js/jquery.min.js"></script>
<script src="{{url('/public/admin')}}/js/bootstrap.min.js"></script>
<script src="{{url('/public/admin')}}/js/adminlte.min.js"></script>
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
<script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<style>
  .swal2-popup {
  font-size: 1.6rem !important;
}
</style>
@include('sweetalert::alert')
@yield('js')
</body>
</html>
