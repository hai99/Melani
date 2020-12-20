@extends('admin.master')

@section('title','Thêm mới sản phẩm')

@section('main')
	
<section class="content">
  <div class="row">
    <form action="" id="form_add" method="POST">
      @csrf
      <div class="row">
        <div class="col-md-8">
            <div class="form-group">
              <label class="" for="name">Tên sản phẩm</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên sản phẩm...">
            </div>
            <div class="form-group">
              <label class="" for="slug">Tên thay thế</label>
              <input type="text" class="form-control" id="slug" name="slug" placeholder="Nhập tên thay thế...">
            </div>
            <div class="form-group">
              <label class="" for="content">Mô tả</label>
              <textarea name="description" id="content" class="form-control" placeholder="Nhập mô tả..."></textarea>
            </div>
            <div class="form-group">
              <label class="" for="slug">Thêm giá và các đặc tính khác</label>
              <div class="field_wrapper">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Màu</th>
                      <th>Kích cỡ</th>
                      <th>Số lượng nhập</th>
                      <th>Giá nhập</th>
                      <th>Giá xuất</th>
                      <th><a href="javascript:void(0);" class="add_button btn btn-success" title="Thêm"><i class="fa fa-plus"></i></a></th>
                    </tr>
                  </thead>
                  <tbody id="tbody">
                    <!-- <tr>
                      <td>
                        <select class="form-control colorId" name="colorId[]">
                          <option value="">---Chọn màu---</option>
                          <option value="'+null+'">Không</option>
                          @foreach($listColor as $color)
                          <option value="{{$color->id}}">{{$color->name}}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <select class="form-control sizeId" name="sizeId[]">
                          <option value="">---Chọn kích cỡ---</option>
                          @foreach($listSize as $size)
                          <option value="{{$size->id}}">{{$size->name}}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <input class="form-control" type="number" name="importNum[]" value=""/>
                      </td>
                      <td>
                        <input class="form-control" type="number" name="importPrice[]" value=""/>
                      </td>
                      <td>
                        <input class="form-control" type="number" name="exportPrice[]" value=""/>
                      </td>
                      <td></td>
                    </tr> -->
                  </tbody>
                </table>
              </div>
            </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
              <label class="" for="discount">Phần trăm giảm giá (%)</label>
              <input type="number" class="form-control" id="discount" name="discount" placeholder="Nhập phần trăm giảm giá...">
          </div>
          <div class="form-group">
              <label class="" for="discount">Độ ưu tiên</label>
              <input type="number" class="form-control" id="priority" name="priority" placeholder="Nhập phần trăm giảm giá...">
          </div>
          <div class="form-group">
              <label class="" for="discount">Lượt xem</label>
              <input type="number" class="form-control" id="proView" name="proView" placeholder="Nhập phần trăm giảm giá...">
          </div>
          <div class="form-group">
              <label class="" for="image">Ảnh</label>
             <div class="input-group">
                <input type="text" class="form-control" id="image" name="image" placeholder="Chọn ảnh sản phẩm...">
                <span class="input-group-btn">
                  <a href="#modal-file" data-toggle="modal" class="btn btn-default">Chọn</a>
                </span>
             </div>
             <img src="" id="show_image" alt="" width="100%">
          </div>

          <div class="form-group">
              <label class="" for="image_list">Các ảnh khác</label>
              <div class="input-group">
                <input type="text" class="form-control" id="image_list" name="image_list" placeholder="Chọn ảnh sản phẩm...">
                <span class="input-group-btn">
                  <a href="#modal-files" data-toggle="modal" class="btn btn-default">Chọn</a>
                </span>
             </div>
             <div class="row" id="show_image_list">
             </div>
          </div>
          <div class="form-group">
              <label class="" for="catalogId">Danh mục</label>
              <select class="form-control" id="catalogId" name="catalogId">
                <option value="">---Chọn danh mục---</option>
                <?php showCategoriesAdd($listCat) ?>
              </select>
          </div>
          <div class="form-group">
            <label for="" class="control-label">Trạng thái :</label>
            <input type="radio" value="1" name="status"> Hiển thị
            <input type="radio" value="0" name="status" checked> Ẩn
          </div>
        </div>
      </div>
      <div class="form-group col-md-12">
        <span id="form_add_pro_result"></span>
        <span id="error"></span>
      </div>
      <div class="form-group col-md-12">
        <button type="submit" class="btn btn-primary">Thêm mới</button>
      </div>
    </form>
</section>

<div class="modal fade" id="modal-file" role="dialog">
  <div class="modal-dialog" style="width: 85%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Quản lý file</h4>
      </div>
      <div class="modal-body">
        <iframe src="{{ url('file') }}/dialog.php?akey=8H4BxG48c6pyq9lwdUSfCn0kKD0BKkOctrNQZsn73Y&field_id=image" frameborder="0" style="width: 100%;height: 850px;border: 0;overflow-y: auto;"></iframe>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-files" role="dialog">
  <div class="modal-dialog" style="width: 85%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Quản lý files</h4>
      </div>
      <div class="modal-body">
        <iframe src="{{ url('file') }}/dialog.php?akey=8H4BxG48c6pyq9lwdUSfCn0kKD0BKkOctrNQZsn73Y&field_id=image_list" frameborder="0" style="width: 100%;height: 850px;border: 0;overflow-y: auto;"></iframe>
      </div>
    </div>
  </div>
</div>

<?php 
      function showCategoriesAdd($categories, $parent_id = 0, $char = ''){
          foreach ($categories as $key => $cat){
            if ($cat['parentId'] == $parent_id){
              echo '<option value="'.$cat['id'].'">';
                echo $char.$cat['name'];
              echo '</option>';
              unset($categories[$key]);
              showCategoriesAdd($categories, $cat['id'], $char.'|---');
            }
          }
        }
    ?>
    <style>
      .thumbnail{
        position: relative;
      }
      .remove_image_list{
        position: absolute;
        right: 10%;
        top: 0;
      }
      .remove_image_list a{
        border-radius: 100%;
      }
    </style>
@stop()

@section('js')
<script src="{{url('/public/admin')}}/js/slug.js"></script>
<script src="{{url('/public/admin')}}/tinymce/tinymce.min.js"></script>
<script src="{{url('/public/admin')}}/tinymce/config.js"></script>

<script>
  $('#modal-file').on('hide.bs.modal',function(){
    var image = $('input#image').val();
    $('img#show_image').attr('src',image);
  });

  $('#modal-files').on('hide.bs.modal',function(){
    var images = $('input#image_list').val();
    var image_list = $.parseJSON(images);
    var html = '';
    for (var i = 0; i < image_list.length; i++) {
      html += '<div class="col-md-3" thumbnail>';
      html += '<img width="100%" src="'+image_list[i]+'" class="image_list_style" alt="">';
      html += '<div class="remove_image_list">';
      html += '<a class="btn btn-default"><i class="fa fa-remove"></i></a>';
      html += '</div>'
      html += '</div>';
    }
    $('#show_image_list').html(html);
  });
  
  $('#form_add').on('submit',function(event){
    event.preventDefault();
    var error = '';
    var proView = $('#proView').val() ? $('#proView').val() : 0;
    var priority = $('#priority').val() ? $('#priority').val() : 0;
    $('.colorId').each(function(){
     var count = 1;
     if($(this).val() == '')
     {
      error += "<p>Bạn phải chọn màu ở hàng số "+count+"</p>";
      return false;
     }
     count = count + 1;
    });
    $('.sizeId').each(function(){
     var count = 1;
     if($(this).val() == '')
     {
      error += "<p>Bạn phải chọn kích cỡ ở hàng số "+count+"</p>";
      return false;
     }
     count = count + 1;
    });
    if (error == '') {
      $('#error').html('');
      var data = new FormData(this);
      data.append('_token',$("meta[name='csrf-token']").attr("content"));
      data.append('name',$('#name').val());
      data.append('slug',$('#slug').val());
      data.append('description',tinyMCE.activeEditor.getContent());
      data.append('discount',$('#discount').val());
      data.append('proView',proView);
      data.append('priority',priority);
      data.append('image',$('#image').val());
      data.append('image_list',$('#image_list').val());
      data.append('catalogId',$('#catalogId').val());
      data.append('status',$('input[name="status"]:checked').val());
      for (var value of data.values()) {
         console.log(value); 
      }
        $.ajax({
          url: "{{ route('product.store') }}",
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
              $('#form_add_pro_result').html(html);
            }
            if (data.errors1) {
              html = '<div class="alert alert-danger">';
              html += '<p>'+data.errors1+'</p>';
              html += '</div>';
              $('#form_add_pro_result').html(html);
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
              window.location.href = "http://localhost:88/project/admin/product";
            }
          }
        });
    }
    else{
      $('#error').html('<div class="alert alert-danger">'+error+'</div>');
    }
  });

$(document).ready(function(){
    // var maxField = 100; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('#tbody'); //Input field wrapper
    var fieldHTML = '<tr><td><select class="form-control colorId" name="colorId[]"><option value="">---Chọn màu---</option>@foreach($listColor as $color)<option value="'+{{$color->id}}+'">{{$color->name}}</option>@endforeach</select></td><td><select class="form-control sizeId" name="sizeId[]"><option value="">---Chọn kích cỡ---</option>@foreach($listSize as $size)<option value="'+{{$size->id}}+'">{{$size->name}}</option>@endforeach</select></td><td><input class="form-control" type="number" name="importNum[]" value=""/></td><td><input class="form-control" type="number" name="importPrice[]" value=""/></td><td><input class="form-control" type="number" name="exportPrice[]" value=""/></td><td><a href="javascript:void(0);" class="remove_button btn btn-danger"><i class="fa fa-minus"></i></a></td></tr>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        // if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        // }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent().parent().remove();
    });



    // $('.thumbnail').on('click', '.remove_image_list', function(e){
    //     e.preventDefault();
    //     $(this).remove();
    // });
});
</script>
@stop
