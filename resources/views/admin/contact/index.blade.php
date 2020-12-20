
@extends('admin.master')

@section('title','Hòm thư')
@section('css')
  <!-- Ionicons -->
  <link rel="stylesheet" href="http://localhost:88/project/public/admin/bower_components/Ionicons/css/ionicons.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="http://localhost:88/project/public/admin/plugins/iCheck/flat/blue.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
@stop()
@section('main')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Hòm thư
        <small>{{count($contacts)}} tin nhắn mới</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <a href="{{ route('contact.add') }}" class="btn btn-primary btn-block margin-bottom">Viết thư</a>

        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            @if(count($contacts) > 0)
            <div class="box-header with-border">
              <h3 class="box-title">Tất cả thư</h3>

              <div class="box-tools pull-right">
                <div class="has-feedback">
                  <input type="text" class="form-control input-sm" placeholder="Tìm kiếm...">
                  <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                    @foreach($contacts as $contact)
                  <tr>
                    <td><input type="checkbox" class="contact_checkbox" value="{{ $contact->id }}"></td>
                    <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                    <td class="mailbox-name"><a href="{{ route('contact.show',['contact' => $contact->id]) }}">{{ $contact->name }}</a></td>
                    <td class="mailbox-subject"><b>{{ $contact->conSubject }}</b>
                    </td>
                    <td class="mailbox-attachment"></td>
                    <td class="mailbox-date"><?php time_since($today-strtotime($contact->created_at)) ?> trước</td>
                    <td class="mailbox-date">
                      <a  class="btn btn-danger delete" id="{{ $contact->id }}"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle" ><i class="fa fa-square-o"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm clear" data-toggle="tooltip" data-original-title="xóa"><i class="fa fa-trash-o"></i></button>
                  <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-original-title="trả lời"><i class="fa fa-reply"></i></button>
                  <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-original-title="chuyển tiếp"><i class="fa fa-share"></i></button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm refresh" data-toggle="tooltip" data-original-title="làm mới"><i class="fa fa-refresh"></i></button>
                <div class="pull-right">
                  1-50/200
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                  </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.pull-right -->
              </div>
            </div>
            @else
            <h2>Bạn chưa có thư mới nào!</h2>
            @endif
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
@stop()

<?php 
  function time_since($since) {
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


<!-- ./wrapper -->
@section('js')
<!-- FastClick -->
<script src="http://localhost:88/project/public/admin/bower_components/fastclick/lib/fastclick.js"></script>
<!-- iCheck -->
<script src="http://localhost:88/project/public/admin/plugins/iCheck/icheck.min.js"></script>
<!-- Page Script -->
<script>
  $(document).on('click','.delete',function(event){
    event.preventDefault();
    var id = $(this).attr('id');
    var token = $("meta[name='csrf-token']").attr("content");
    swal({
      title: "Bạn có muốn xóa không?",
      text: "Bấm có để xóa dữ liệu",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Có",
      cancelButtonText: "Không",
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm){
    if (isConfirm) {
      $.ajax({
        url: "contact/"+id,
        type: "DELETE",
        data: {"id":id,"_token":token,},
        success:function(data){
          if (data.errors) {
            swal({
              title: data.errors,
              icon: "warning",
              buttons: "Done",
              dangerMode: true,
              })
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
    }else {
      swal("Đã hủy xóa!");
    }
    });
  });

  $('.clear').on('click',function(event){
    event.preventDefault();
    var id = [];
    var token = $("meta[name='csrf-token']").attr("content");
    swal({
      title: "Bạn có muốn xóa không?",
      text: "Bấm có để xóa dữ liệu",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Có",
      cancelButtonText: "Không",
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm){
    if (isConfirm) {
      $('.contact_checkbox:checked').each(function(){
                id.push($(this).val());
            });
            if(id.length > 0)
            {
                $.ajax({
                    url:"{{ route('contact.clear')}}",
                    method:"POST",
                    data:{'id':id,'_token':token,},
                    success:function(data)
                    {
                        if (data.errors) {
                          alert(data.errors);
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
            }
            else
            {
                swal("Bạn phải chọn ít nhất một bản ghi để xóa");
            }
    }else {
      swal("Đã hủy xóa!");
    }
    });
  });

  $('.refresh').on('click',function(event){
    event.preventDefault();
    location.reload();
  });
</script>
<script>
  $(function () {
    //Enable iCheck plugin for checkboxes
    //iCheck for checkbox and radio inputs
    $('.mailbox-messages input[type="checkbox"]').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });

    //Enable check and uncheck all functionality
    $(".checkbox-toggle").click(function () {
      var clicks = $(this).data('clicks');
      if (clicks) {
        //Uncheck all checkboxes
        $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
        $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
      } else {
        //Check all checkboxes
        $(".mailbox-messages input[type='checkbox']").iCheck("check");
        $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
      }
      $(this).data("clicks", !clicks);
    });

    //Handle starring for glyphicon and font awesome
    $(".mailbox-star").click(function (e) {
      e.preventDefault();
      //detect type
      var $this = $(this).find("a > i");
      var glyph = $this.hasClass("glyphicon");
      var fa = $this.hasClass("fa");

      //Switch states
      if (glyph) {
        $this.toggleClass("glyphicon-star");
        $this.toggleClass("glyphicon-star-empty");
      }

      if (fa) {
        $this.toggleClass("fa-star");
        $this.toggleClass("fa-star-o");
      }
    });
  });
</script>
<!-- AdminLTE for demo purposes -->
<script src="http://localhost:88/project/public/admin/dist/js/demo.js"></script>
@stop()
