@extends('admin.master')

@section('title','Chỉnh sửa sản phẩm')


@section('main')
<?php $img_list = json_decode($model->image_list); ?>
<section class="content">
  <div class="container">
    <div class="row">
        <div class="media">
          <div class="col-md-5">
            <img class="media-object" width="400px" src="{{ url('public') }}/user/img/product/{{ $model->image }}" alt="Image">
            @if(is_array($img_list))
            <div class="row">
              @foreach($img_list as $item)
              <div class="col-md-3">
                <img src="{{$item}}" style="width: 100%" alt="">
              </div>
              @endforeach
            </div>
            @endif
          </div>
          <div class="col-md-7">
            <div class="media-body">
              <form action="" method="POST" role="form" id="form_demo">
                @csrf
                <div class="form-group">
                    <label class="" for="name">Tên sản phẩm</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $model->name }}" placeholder="Nhập tên sản phẩm...">
                </div>
                <input type="hidden" class="form-control" id="hidden_product_id" name="hidden_product_id" value="{{ $model->id }}">
                <div class="form-group">
                  <label class="" for="slug">Tên thay thế</label>
                  <input type="text" class="form-control" id="slug" name="slug" value="{{ $model->slug }}" placeholder="Nhập tên thay thế...">
                </div>
                <div class="form-group">
                    <label class="" for="catalogId">Danh mục</label>
                    <select class="form-control" id="catalogId" name="catalogId">
                      <?php showCategoriesAdd($listCat,$model->catalogId); ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="" for="discount">Độ ưu tiên</label>
                    <input type="number" class="form-control" id="priority" name="priority" value="{{ $model->priority }}" placeholder="Nhập độ ưu tiên...">
                </div>
                <div class="form-group">
                    <label class="" for="discount">Lượt xem</label>
                    <input type="number" class="form-control" id="proView" name="proView" value="{{ $model->proView }}" placeholder="Nhập lượt xem...">
                </div>
                <div class="form-group">
                    <label class="" for="image">Ảnh</label>
                   <div class="input-group">
                      <input type="text" class="form-control" id="image" name="image" placeholder="Chọn ảnh sản phẩm...">
                      <span class="input-group-btn">
                        <a href="#modal-file" data-toggle="modal" class="btn btn-default">Chọn</a>
                      </span>
                   </div>
                </div>
                <div class="form-group">
                    <label class="" for="image_list">Các ảnh khác</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="image_list" name="image_list" placeholder="Chọn ảnh sản phẩm...">
                      <span class="input-group-btn">
                        <a href="#modal-files" data-toggle="modal" class="btn btn-default">Chọn</a>
                      </span>
                   </div>
                </div>
                <div class="form-group">
                    <label class="" for="content">Mô tả</label>
                    <textarea name="description" id="content" class="form-control" placeholder="Nhập mô tả...">{{ $model->description }}</textarea>
                </div>
                <div class="form-group">
                    <label class="" for="discount">Phần trăm giảm giá (%)</label>
                    <input type="number" class="form-control" id="discount" name="discount" value="{{ $model->discount }}" placeholder="Nhập phần trăm giảm giá...">
                </div>
                <div class="form-group">
                  <label for="" class="control-label">Trạng thái :</label>
                  <input type="radio" value="1" name="status" {{ $model->status == 1 ? 'checked' : '' }}> Hiển thị
                  <input type="radio" value="0" name="status" {{ $model->status == 0 ? 'checked' : '' }}> Ẩn
                </div>
                <div class="form-group">
                  <span id="form_edit_pro_result"></span>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-success">Sửa</button>
                </div>
              </form>
            </div>
          </div>
        </div>
          <!-- /.col -->
    </div>
  </div>
      <!-- /.row -->
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
  function showCategoriesAdd($categories,$catalogId,$parent_id = 0, $char = ''){
      foreach ($categories as $key => $cat){
        $selected = $catalogId == $cat['id'] ? 'selected' : ''; 
        if ($cat['parentId'] == $parent_id){
          echo '<option value="'.$cat['id'].'"'.$selected.'>';
          echo $char.$cat['name'];
          echo '</option>';
          unset($categories[$key]);
          showCategoriesAdd($categories,$catalogId,$cat['id'], $char.'|---');
        }
      }
    }
?>

<table class="table table-hover">
<h3>
  <span class="label label-default" >Các sản phẩm còn lại trong kho:</span>
</h3>
  <thead>
    <tr>
      <th>Tên sản phẩm</th>
      <th>Màu</th>
      <th>Kích thước</th>
      <th>Ngày tạo</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listProSame as $proSame)
    <tr>
      <td>{{ $proSame->pro['name'] }}</td>
      <td>{{ $proSame->color['name'] }}</td>
      <td>{{ $proSame->size['name'] }}</td>
      <td>{{ date('d-m-Y',strtotime($proSame->created_at)) }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
@stop()
@section('js')
<script src="{{url('/public/admin')}}/js/slug.js"></script>
<script src="{{url('/public/admin')}}/tinymce/tinymce.min.js"></script>
<script src="{{url('/public/admin')}}/tinymce/config.js"></script>

<script>
  $('#form_demo').on('submit',function(event){
    event.preventDefault();
    var data = new FormData();
    var priority = $('#priority').val() ? $('#priority').val() : 0;
    var proView = $('#proView').val() ? $('#proView').val() : 0;
    var id = $('#hidden_product_id').val();
    data.append('name',$('#name').val());
    data.append('slug',$('#slug').val());
    data.append('slug',$('#slug').val());
    data.append('catalogId',$('#catalogId').val());
    data.append('priority',priority);
    data.append('proView',proView);
    data.append('image',$('#image').val());
    data.append('image_list',$('#image_list').val());
    data.append('description',tinyMCE.activeEditor.getContent());
    data.append('discount',$('#discount').val());
    data.append('status',$('input[name="status"]:checked').val());
    data.append('id',$('#hidden_product_id').val());
    data.append('_method','PUT');
    data.append('_token',$("meta[name='csrf-token']").attr("content"));
    for (var value of data.values()) {
         console.log(value); 
    }
    $.ajax({
      url: "{{ route('product.update',"+id+") }}",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataTypee: "json",
      success:function(data){
        var html = '';
        if (data.errors) {
           html = '<div class="alert alert-danger">';
            for (var i = 0; i < data.errors.length; i++) {
              html += '<p>'+data.errors[i]+'</p>';
            }
            html += '</div>';
            $('#form_edit_pro_result').html(html);
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
  });
</script>
@stop()

