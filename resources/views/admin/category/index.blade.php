@extends('admin.master')

@section('title','Quản lý danh mục')

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
<?php 
$name = Auth::user()->getRoleNames();
$id = \Spatie\Permission\Models\Role::whereIn('name',$name)->pluck('id');
$rolePermission = \Spatie\Permission\Models\Permission::join('role_has_permissions','role_has_permissions.permission_id','=','permissions.id')->whereIn('role_has_permissions.role_id',$id)->pluck('name');
?>

@if($rolePermission->contains('category-create'))
	@section('search-add')
		<div class="panel-body">
			<form action="" method="POST" id="form_add" class="form-inline" role="form">
				<a href=""   class="btn btn-success" id="cat_add"  name="cat_add">Thêm mới</a>
			</form>
		</div>
	@stop()
@endif


@section('main')
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
					  <h3 class="box-title">Quản lý danh mục</h3>
					</div>
				<!-- /.box-header -->
				<div class="box-body category_icheck">
					<table class="table" id="cat_table">
					<thead>
					<tr>
						<th>Tên danh mục</th>
						<th>ID danh mục cha</th>
						<th>Trạng thái</th>
						<th>Ngày tạo</th>
						<th>Hành động</th>
					</tr>
					</thead>
					<tbody>
						@if($rolePermission->contains('category-edit') && $rolePermission->contains('category-delete') && $rolePermission->contains('category-list'))
							<?php showCategories($listCat) ?>
						@elseif($rolePermission->contains('category-delete'))
							<?php showCategoriesCanDelete($listCat) ?>
						@elseif($rolePermission->contains('category-edit'))
							<?php showCategoriesCanEdit($listCat) ?>
						@elseif($rolePermission->contains('category-list'))
							<?php showCategoriesList($listCat) ?>
						@endif
					</tbody>
					<tfoot>
					    <tr>
					    	<th rowspan="1" colspan="1">Tên danh mục</th>
					    	<th rowspan="1" colspan="1">ID danh mục cha</th>
					    	<th rowspan="1" colspan="1">Trạng thái</th>
					    	<th rowspan="1" colspan="1">Ngày tạo</th>
					    	<th rowspan="1" colspan="1">Hành động</th>
					    </tr>
					</tfoot>
					<?php 
						function showCategories($categories, $parent_id = 0, $char = '')
						{
							foreach ($categories as $key => $item)
							{
								// Nếu là chuyên mục con thì hiển thị
								if ($item['parentId'] == $parent_id)
								{
									echo '<tr>';
									echo '<td>';
									echo $char.$item['name'];
									echo '</td>';
									echo '<td>';
									echo $item['parentId'];
									echo '</td>';
									echo '<td><span class="badge badge-success">';
									echo $item['status'] ? "Hiển thị" : "Ẩn";
									echo '</span></td>';
									echo '<td>';
									echo date('d-m-Y',strtotime($item->created_at));
									echo '</td>';
									echo '<td>';
									echo '<a href=""  class="btn btn-success edit" name="edit" id="'.$item['id'].'"><i class="fa fa-edit"></i></a>	';
									echo '<a  class="btn btn-danger delete" id="'.$item['id'].'"><i class="fa fa-remove"></i></a>';
									echo '</td>';
									echo '</tr>';

									// Xóa chuyên mục đã lặp
									unset($categories[$key]);

									// Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
									showCategories($categories, $item['id'],$char.'|---');
								}
							}
						}
					?>
					
					<?php 
						function showCategoriesList($categories, $parent_id = 0, $char = '')
						{
							foreach ($categories as $key => $item)
							{
								// Nếu là chuyên mục con thì hiển thị
								if ($item['parentId'] == $parent_id)
								{
									echo '<tr>';
									echo '<td>';
									echo $char.$item['name'];
									echo '</td>';
									echo '<td>';
									echo $item['parentId'];
									echo '</td>';
									echo '<td><span class="badge badge-success">';
									echo $item['status'] ? "Hiển thị" : "Ẩn";
									echo '</span></td>';
									echo '<td>';
									echo date('d-m-Y',strtotime($item->created_at));
									echo '</td>';
									echo '<td>';
									echo '</td>';
									echo '</tr>';

									// Xóa chuyên mục đã lặp
									unset($categories[$key]);

									// Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
									showCategoriesList($categories, $item['id'],$char.'|---');
								}
							}
						}
					?>

					<?php 
						function showCategoriesCanDelete($categories, $parent_id = 0, $char = '')
						{
							foreach ($categories as $key => $item)
							{
								// Nếu là chuyên mục con thì hiển thị
								if ($item['parentId'] == $parent_id)
								{
									echo '<tr>';
									echo '<td>';
									echo $char.$item['name'];
									echo '</td>';
									echo '<td>';
									echo $item['parentId'];
									echo '</td>';
									echo '<td><span class="badge badge-success">';
									echo $item['status'] ? "Hiển thị" : "Ẩn";
									echo '</span></td>';
									echo '<td>';
									echo date('d-m-Y',strtotime($item->created_at));
									echo '</td>';
									echo '<td>';
									echo '<a  class="btn btn-danger delete" id="'.$item['id'].'"><i class="fa fa-remove"></i></a>';
									echo '</td>';
									echo '</tr>';

									// Xóa chuyên mục đã lặp
									unset($categories[$key]);

									// Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
									showCategoriesCanDelete($categories, $item['id'],$char.'|---');
								}
							}
						}
					?>

					<?php 
						function showCategoriesCanEdit($categories, $parent_id = 0, $char = '')
						{
							foreach ($categories as $key => $item)
							{
								// Nếu là chuyên mục con thì hiển thị
								if ($item['parentId'] == $parent_id)
								{
									echo '<tr>';
									echo '<td>';
									echo $char.$item['name'];
									echo '</td>';
									echo '<td>';
									echo $item['parentId'];
									echo '</td>';
									echo '<td><span class="badge badge-success">';
									echo $item['status'] ? "Hiển thị" : "Ẩn";
									echo '</span></td>';
									echo '<td>';
									echo date('d-m-Y',strtotime($item->created_at));
									echo '</td>';
									echo '<td>';
									echo '<a href=""  class="btn btn-success edit" name="edit" id="'.$item['id'].'"><i class="fa fa-edit"></i></a>	';
									echo '</td>';
									echo '</tr>';

									// Xóa chuyên mục đã lặp
									unset($categories[$key]);

									// Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
									showCategoriesCanEdit($categories, $item['id'],$char.'|---');
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
<div class="modal" id="myModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" role="form" id="form_demo">
			@csrf
          <div class="form-group">
            <label for="" class="control-label">Tên danh mục</label>
			<input type="text" class="form-control" id="name" name="name">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Slug :</label>
			<input type="text" class="form-control" id="slug" name="slug">
		  </div>
		  <div class="form-group">
            <label for="" class="control-label">Danh mục cha :</label>
				<select name="parentId" class="form-control" id="parentId">
					<option value="0">Mặc định</option>
					<?php showCategoriesAdd($listCat1);?>
				</select>
		  </div>
		  <div class="form-group">
            <label for="" class="control-label">Trạng thái :</label>
			<input type="radio" value="1" name="status" class="status" id="status"> Hiển thị
			<input type="radio" value="0" name="status" class="status" id="status"> Ẩn
		  </div>
		  <div class="form-group">
		  	<span id="form_result"></span>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>
			<input type="hidden" name="hidden_id" id="hidden_id">
			<button type="submit" class="btn btn-success" value="" id="action"></button>
		  </div>
        </form>
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
@section('js')
<script src="{{url('/public')}}/admin/js/slug.js"></script>
<script>
	$('#cat_table').DataTable();
</script>
<script>
	$('#cat_add').on('click',function(event){
		event.preventDefault();
		$('.modal-title').text('Thêm mới danh mục');
		$('#form_demo').attr('id', 'form_add');
		$('#form_edit').attr('id', 'form_add');
		$('#name').val('');
		$('#slug').val('');
		$('#parentId').val('0');
		$('#status').attr('checked', true);
		$('#action').text('Thêm');
		$('#action').attr('value', 'Add');
		$('#myModal').modal('show');
	});

	$(document).on('click','.edit',function(){
		event.preventDefault();
		var id = $(this).attr('id');
		$.ajax({
			url: "category/"+id+"/edit",
			dataType: "json",
			success:function(html){
				$('.modal-title').text('Chỉnh sửa danh mục');
				$('#name').val(html.data.name);
				$('#slug').val(html.data.slug);
				$('#parentId').val(html.data.parentId);
				$('#hidden_id').val(html.data.id);
				$('#form_demo').attr('id', 'form_edit');
				$('#form_add').attr('id', 'form_edit');
				$('.form-group').find(':radio[name=status][value="'+html.data.status+'"]').prop('checked',true);
				$('#action').text('Sửa');
				$('#action').attr('value', 'Edit');
				$('#form_result').html('');
				$('#myModal').modal('show');
			}
		});
	});

	$('#form_demo').on('submit',function(event){
		event.preventDefault();
		if ($('#action').val() == 'Add') {
			$.ajax({
				url: "{{ route('category.store') }}",
				method: "POST",
				data: new FormData(this),
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success:function(data){
					var html = '';
					if(data.errors){
						html = '<div class="alert alert-danger">';
						for(var count = 0;count<data.errors.length;count++){
							html += '<p>'+data.errors[count]+'</p>';
						}
						html +='</div>';
					}
					if (data.success) {
						$('#form_add')[0].reset();
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
	                $('#form_result').html(html);
				}
			});
		}
		if ($('#action').val() == 'Edit') {
			var id = $('#hidden_id').val();
			var data = new FormData(this);
			data.append('_token',$("meta[name='csrf-token']").attr("content"));
			data.append('id',id);
			data.append('_method','PUT');
			$.ajax({
				url: "category/"+id,
				method: "POST",
				data: data,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success:function(data){
					var html = '';
					if(data.errors){
						html = '<div class="alert alert-danger">';
						for(var count = 0;count<data.errors.length;count++){
							html += '<p>'+data.errors[count]+'</p>';
						}
						html +='</div>';
					}
					if (data.success) {
						$('#form_edit')[0].reset();
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
					$('#form_result').html(html);
				}
			});
		}
	});

	$(document).on('click','.delete',function(event){
		event.preventDefault();
		var cat_id = $(this).attr('id');
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
				url: "category/"+cat_id,
				type: "DELETE",
				data: {"id":cat_id,"_token":token,},
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

</script>
@stop()