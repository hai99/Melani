@extends('user\master')
@section('title','So sánh')
@section('main')
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('all-products') }}">sản phẩm</a></li>
                                <li class="breadcrumb-item active" aria-current="page">so sánh</li>
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
        <!-- compare main wrapper start -->
        <div class="compare-page-wrapper pt-100 pb-100 pt-sm-58 pb-sm-58">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Compare Page Content Start -->
                        <div class="compare-page-content-wrap">
                            <div class="compare-table table-responsive">
                                        @if(Session::has('compare') && count(Session::get('compare'))>0)
                                <table class="table table-bordered mb-0">
                                    <tbody>
                                    <tr>
                                        <td class="first-column">Sản phẩm</td>
                                        @foreach(Session::get('compare') as $item)

                                        <td class="product-image-title">
                                            <a href="{{ route('product_detail',['slug'=>$item['slug']]) }}" class="image">
                                                <img class="img-fluid" width="100px" src="{{ url('public') }}/user/img/product/{{ $item['image'] }}" alt="Compare Product">
                                            </a>
                                            <a href="{{ route('product_detail',['slug'=>$item['slug']]) }}" class="title">{{ $item['name']}}
                                            </a>
                                        </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="first-column">Màu</td>
                                        @foreach(Session::get('compare') as $item)
                                        @if(!empty($item['color']))
                                            <td class="pro-color">
                                            @foreach($item['color'] as $color)
                                            <?php echo $color.',' ?>
                                            @endforeach
                                            </td>
                                        @else
                                            <td class="pro-color">Không có màu</td>
                                        @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="first-column">Kích cỡ</td>
                                        @foreach(Session::get('compare') as $item)
                                        @if(!empty($item['size']))
                                            <td class="pro-color">
                                            @foreach($item['size'] as $size)
                                            <?php echo $size.',' ?>
                                            @endforeach
                                            </td>
                                        @else
                                            <td class="pro-color">Không có kích cỡ</td>
                                        @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="first-column">Mô tả</td>
                                        @foreach(Session::get('compare') as $item)
                                        <td>{{ $item['description'] }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="first-column">Mua hàng</td>
                                        @foreach(Session::get('compare') as $item)
                                        <td><a href="{{ route('product_detail',['slug'=>$item['slug']]) }}" class="sqr-btn">Thêm vào giỏ</a></td>
                                        @endforeach
                                    </tr>
                                    <?php 
                                        $compare = Session::get('compare');
                                        foreach ($compare as $comp) {
                                            $avgRating = Review::where('productId',$comp['id'])->avg('rating');
                                            $ceilAvg = ceil($avgRating);
                                            $avgs[] =  [
                                                'id' => $comp['id'],
                                                'avg' => $ceilAvg
                                            ];
                                        }
                                     ?>
                                    <tr>
                                        <td class="first-column">Đánh giá</td>
                                        @foreach(Session::get('compare') as $item)
                                        @if(count($avgs) > 0)
                                        @foreach($avgs as $avg)
                                        @if($avg['id'] == $item['id'])
                                        <td class="pro-ratting">
                                        @for($i = 0;$i < $avg['avg'];$i++)
                                            <i class="fa fa-star"></i>
                                        @endfor
                                        </td>
                                        @endif
                                        @endforeach
                                        @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="first-column">Xóa</td>
                                        @csrf
                                        @foreach(Session::get('compare') as $item)
                                        <td class="pro-remove">
                                            <button href="" class="delete" id="{{ $item['id'] }}"><i class="fa fa-trash-o"></i></button>
                                        </td>
                                        @endforeach
                                    </tr>
                                    </tbody>
                                @else
                                <h2>Không có sản phẩm so sánh nào</h2>
                                <a href="{{ route('home') }}">Quay lại</a>
                                @endif
                                </table>
                            </div>
                        </div>
                        <!-- Compare Page Content End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- compare main wrapper end -->
    </main>
    <!-- page main wrapper end -->
@stop

@section('js')
<script>
    $(document).on('click','.delete',function(event){
        event.preventDefault();
        var id = $(this).attr('id');
        var token = $("meta[name='csrf-token']").attr("content");
        var data = new FormData();
        data.append('id',id);
        data.append('_token',token);
        $.ajax({
            url: "{{route('del_compare')}}",
            method: "POST",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(data){
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


</script>
@stop