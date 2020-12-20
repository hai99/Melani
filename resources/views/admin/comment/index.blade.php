@extends('admin.master')

@section('title','Quản lý bình luận')

<?php 
$name = Auth::user()->getRoleNames();
$id = \Spatie\Permission\Models\Role::whereIn('name',$name)->pluck('id');
$rolePermission = \Spatie\Permission\Models\Permission::join('role_has_permissions','role_has_permissions.permission_id','=','permissions.id')->whereIn('role_has_permissions.role_id',$id)->pluck('name');
?>

@section('main')
	
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
					  <h3 class="box-title">Quản lý bình luận</h3>
					</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table class="table" id="comment_table">
					<thead>
					<tr>
						<th>Tên người dùng</th>
						<th>Nội dung</th>
						<th>Tên bài viết</th>
						<th>Trạng thái</th>
						<th>Ngày tạo</th>
						<th>Hành động</th>
					</tr>
					</thead>
					<tbody>
						@if($rolePermission->contains('comment-delete') && $rolePermission->contains('comment-list'))
							<?php showComments($listComment); ?>
						@elseif($rolePermission->contains('comment-list'))
							<?php showCommentsList($listComment); ?>
						@endif
					</tbody>
					<tfoot>
					    <tr>
					    	<th rowspan="1" colspan="1">Tên người dùng</th>
					    	<th rowspan="1" colspan="1">Nội dung</th>
					    	<th rowspan="1" colspan="1">Tên bài viết</th>
					    	<th rowspan="1" colspan="1">Trạng thái</th>
					    	<th rowspan="1" colspan="1">Ngày tạo</th>
					    	<th rowspan="1" colspan="1">Hành động</th>
					    </tr>
					</tfoot>
					<?php 
							function showComments($comments, $parent_id = 0, $char = '')
							{
							foreach ($comments as $key => $item)
							{
							// Nếu là chuyên mục con thì hiển thị
							if ($item['parentId'] == $parent_id)
							{
							echo '<tr>';
								echo '<td>';
								echo $char.$item['name'];
								echo '</td>';
								echo '<td>';
								echo $item['content'];
								echo '</td>';
								echo '<td>';
								echo $item['blogTitle'];
								echo '</td>';
								echo '<td>';
								echo '<input data-id="'.$item->id.'" class="toggle-class" type="checkbox" data-onstyle="primary" data-offstyle="default" data-toggle="toggle" data-on="Hiển thị" data-off="Ẩn" ';
								echo $item->status ? 'checked' : '';
								echo '/>';
								echo '</td>';
								echo '<td>';
								echo date('d-m-Y',strtotime($item->created_at));
								echo '</td>';
								echo '<td>';
								echo '<a  class="btn btn-danger delete" id="'.$item['id'].'"><i class="fa fa-remove"></i></a>';
								echo '</td>';
							echo '</tr>';

							// Xóa chuyên mục đã lặp
							unset($comments[$key]);

							// Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
							showComments($comments, $item['id'],$char.'|---');
							}
							}
							}
					 ?>

					 <?php 
							function showCommentsList($comments, $parent_id = 0, $char = '')
							{
							foreach ($comments as $key => $item)
							{
							// Nếu là chuyên mục con thì hiển thị
							if ($item['parentId'] == $parent_id)
							{
							echo '<tr>';
								echo '<td>';
								echo $char.$item['name'];
								echo '</td>';
								echo '<td>';
								echo $item['content'];
								echo '</td>';
								echo '<td>';
								echo $item['blogTitle'];
								echo '</td>';
								echo '<td>';
								echo '<input data-id="'.$item->id.'" class="toggle-class" type="checkbox" data-onstyle="primary" data-offstyle="default" data-toggle="toggle" data-on="Hiển thị" data-off="Ẩn" ';
								echo $item->status ? 'checked' : '';
								echo '/>';
								echo '</td>';
								echo '<td>';
								echo date('d-m-Y',strtotime($item->created_at));
								echo '</td>';
								echo '<td>';
								echo '</td>';
							echo '</tr>';

							// Xóa chuyên mục đã lặp
							unset($comments[$key]);

							// Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
							showCommentsList($comments, $item['id'],$char.'|---');
							}
							}
							}
					 ?>
					</table>
				</div>
				</div>
				<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
    </section>

@stop()
@section('js')
<script>
	$('#comment_table').DataTable();
</script>
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
				url: "comment/"+id,
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

	$(document).on('change','.toggle-class',function(event){
      event.preventDefault();
      var data = new FormData();
      data.append('status',$(this).prop('checked') == true ? 1 : 0);
      data.append('id',$(this).data('id'));
      data.append('_token',$("meta[name='csrf-token']").attr("content"));
      data.append('_method','PUT');
      // var status = $(this).prop('checked') == true ? 1 : 0;
      var id = $(this).data('id');
      // var token = $("meta[name='csrf-token']").attr("content");
      // var method = "PUT";
      $.ajax({
        url: "comment/"+id,
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(data){
          if(data.errors){
            alert(data.erros);
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

</script>


@stop()