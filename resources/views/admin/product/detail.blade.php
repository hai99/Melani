@extends('admin.master')

@section('title','Chi tiết sản phẩm')


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
              <h2 class="media-heading">Tên sản phẩm: {{ $model->name }}</h2>
              <p><b>Tên danh mục:</b> {{ $model->cat->name }}</p>
              <p><b>Độ ưu tiên:</b> {{ $model->priority }}</p>
              <p><b>Lượt xem:</b> {{ $model->proView }}</p>
              <p><b>Mô tả:</b> {{ $model->description }}</p>
              <p><b>Giảm giá:</b> {{ $model->discount }}%</p>
              <p><b>Trạng thái:</b> {{ $model->status ? "Hiển thị" : "Ẩn" }}</p>
              <p><b>Ngày tạo:</b> {{ date('d-m-Y',strtotime($model->created_at)) }}</p>
            </div>
          </div>
        </div>
          <!-- /.col -->
    </div>
  </div>
      <!-- /.row -->
</section>
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

