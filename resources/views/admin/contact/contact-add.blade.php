
@extends('admin.master')

@section('title','Viết thư')
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
          <a href="{{ route('contact.index') }}" class="btn btn-primary btn-block margin-bottom">Quay lại</a>

        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Soạn thư mới</h3>
            </div>
            <!-- /.box-header -->
            <form action="" method="POST" id="sendEmail">
              @csrf
              <div class="box-body">
                <div class="form-group">
                  @if(isset($email))
                    <input class="form-control" name="email" id="email" placeholder="Đến:" value="{{ $email }}" >
                  @else
                    <input class="form-control" name="email" id="email" placeholder="Đến:" >
                  @endif
                </div>
                <div class="form-group">
                  <input class="form-control" name="subject" id="subject" placeholder="Chủ đề:">
                </div>
                <div class="form-group">
                  <textarea id="content" name="content" class="form-control" style="height: 300px;"></textarea>
                </div>
              </div>
              <div class="form-group">
                <span id="form_result"></span>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="pull-right">
                  <button type="button" class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button>
                  <button type="submit" class="btn btn-primary" id="send"><i class="fa fa-envelope-o"></i> Gửi</button>
                </div>
                <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
              </div>
            </form>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
@stop()



<!-- ./wrapper -->
@section('js')
<!-- FastClick -->
<script src="http://localhost:88/project/public/admin/bower_components/fastclick/lib/fastclick.js"></script>
<!-- iCheck -->
<script src="http://localhost:88/project/public/admin/plugins/iCheck/icheck.min.js"></script>
<script src="{{url('/public/admin')}}/tinymce/tinymce.min.js"></script>
<script src="{{url('/public/admin')}}/tinymce/config.js"></script>
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

  $('#sendEmail').on('submit',function(event){
    event.preventDefault();
    var data = new FormData(this);
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
           html = '<div class="alert alert-danger">';
            for (var i = 0; i < data.errors.length; i++) {
              html += '<p>'+data.errors[i]+'</p>';
            }
            html += '</div>';
            $('#form_result').html(html);
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
          window.location.href = "http://localhost:88/project/admin/contact";
        }
      }
    });
  });

</script>
<!-- AdminLTE for demo purposes -->
<script src="http://localhost:88/project/public/admin/dist/js/demo.js"></script>
@stop()
