@extends('user/master')
@section('title','Danh sách ưa thích')
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
                                <li class="breadcrumb-item active" aria-current="page">Danh sách ưa thích</li>
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
        <!-- wishlist main wrapper start -->
        <div class="wishlist-main-wrapper pt-100 pb-100 pt-sm-58 pb-sm-58">
            <div class="container">
                <!-- Wishlist Page Content Start -->
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Wishlist Table Area -->
                        @if(count($wishList) > 0)
                        <div class="cart-table table-responsive">
                            <table class="table table-bordered" id="wishTable">
                                <thead>
                                <tr>
                                    <th class="pro-thumbnail">Ảnh</th>
                                    <th class="pro-title">Sản phẩm</th>
                                    <th class="pro-subtotal">Mua</th>
                                    <th class="pro-remove">Xóa</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($wishList as $wl)
                                    <tr>
                                        <td class="pro-thumbnail"><a href="{{ route('product_detail',['slug' => $wl->slug]) }}"><img class="img-fluid" src="{{ url('public') }}/user/img/product/{{ $wl->proImage }}" alt="Product"/></a></td>
                                        <td class="pro-title"><a href="{{ route('product_detail',['slug' => $wl->slug]) }}">{{ $wl->proName }}</a></td>
                                        <td class="pro-subtotal"><a href="{{ route('product_detail',['slug' => $wl->slug]) }}" class="sqr-btn text-white">Mua</a></td>
                                        <td class="pro-remove"><a href="" class="delete" id="{{$wl->id}}"><i class="fa fa-trash-o"></i></a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                                        <input type="hidden" id="hidden_cusId" value="{{ Session::get('customer')->id }}">
                            </table>
                            <div class="modal" id="formModalDel">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title-del" id="myModalLabel">Xác nhận</h4>
                                  </div>
                                    <div class="modal-body">
                                        <p id="text-del">Bạn có chắc không?</p>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="submit"  class="btn btn-danger check_del" id="check_del" value="">Đồng ý</button>
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                    </div>
                                  <span id="form_del_result"></span>
                                </div>
                              </div>
                            </div>
                        </div>
                        @else
                        <h2>Bạn chưa có sản phẩm nào trong danh sách ưa thích</h2>
                        <a href="{{ route('home') }}">Quay lại</a>
                        @endif
                    </div>
                </div>
                <!-- Wishlist Page Content End -->
            </div>
        </div>
        <!-- wishlist main wrapper end -->
    </main>
    <!-- page main wrapper end -->

 @stop

 @section('js')
<script>
    $(document).on('click','.delete',function(event){
        event.preventDefault();
        data = new FormData();
        data.append('id',$(this).attr('id'));
        data.append('_token',$("meta[name='csrf-token']").attr("content"));
        $.ajax({
            url: "{{ route('wishlist.remove') }}",
            method: "POST",
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success:function(data){
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
    });

    // $(document).on('click','.delete',function(event){
    //     event.preventDefault();
    //     $('#formModalDel').modal('show');
    //     var customerId = $('#hidden_cusId').val();
    //     var id = $(this).attr('id');
    //     var token = $("meta[name='csrf-token']").attr("content");
    //     $('#check_del').click(function(){
    //         $.ajax({
    //             url: "route('wishlist',['customerId'=>customerId])",
    //             method: "POST",
    //             data: {"id":id,"_token":token,},
    //             beforeSend:function(){
    //                 $('#check_del').text('Đang xóa...');
    //             },
    //             success:function(data){
    //                 $('#formModalDel').modal('hide');
    //                 location.reload();
    //                 const Toast = Swal.mixin({
    //                 toast: true,
    //                 position: 'top-right',
    //                 showConfirmButton: false,
    //                 timer: 1000
    //                 });
    //                 Toast.fire({
    //                    type: 'success',
    //                    title: 'Xóa thành công!'
    //                 });
    //             }
    //         });

    //     });
    // });


    
</script>
 @stop