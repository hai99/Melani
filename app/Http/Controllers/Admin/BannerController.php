<?php 
	namespace App\Http\Controllers\Admin;

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\Category;
	use App\Models\Blog;
	use App\Models\CatalogBlog;
	use App\Models\Banner;
	use App\Models\Color;
	use App\Models\Sizes;
	use App\Models\Stocks;
	use App\Http\Controllers\Controller;
	use Validator;
	use DataTables;
	use App\Models\ModelHasRoles;
	use App\Models\RoleHasPermissions;
	use Illuminate\Support\Facades\Auth;
	use Spatie\Permission\Models\Role;
	use Spatie\Permission\Models\Permission;
	use Illuminate\Support\Collection;

	/**
	 * summary
	 */
	class BannerController extends Controller
	{
	    /**
	     * summary
	     */
	    function __construct()
	    {
	         $this->middleware('permission:banner-list|banner-create|banner-edit|banner-delete', ['only' => ['index','store']]);
	         $this->middleware('permission:banner-create', ['only' => ['create','store']]);
	         $this->middleware('permission:banner-edit', ['only' => ['edit','update']]);
	         $this->middleware('permission:banner-delete', ['only' => ['destroy']]);
	    }

	    public function index(){
	    	$listBanner = Banner::get();
	        return view('admin/banner/index',compact('listBanner'));
	    }

	    public function create(){
	    	$listCat = Category::get(); 
	    	return view('admin/category/add',compact('listCat'));
	    }

	    public function store(Request $request){
	    	if ($request->has('title')) {
		    	$rules = array(
		    		'image' => 'required',
		    		'title' => 'required|max:200',
		    		'content' => 'required|max:200',
		    		'type' => 'required',
		    		'status' => 'required'
		    	);
		    	$messages = array(
		    		'image.required' =>'Ảnh không được để trống',
		    		'title.required' =>'Tiêu đề không được để trống',
		    		'title.max' =>'Tiêu đề không được quá 20 ký tự',
		    		'content.required' =>'Nội dung không được để trống',
		    		'content.max' =>'Nội dung không được quá 40 ký tự',
		    		'type.required' =>'Loại không được để trống',
		    		'status.required' =>'Trạng thái không được để trống',
		    	);
		    	$errors = Validator::make($request->all(),$rules,$messages);
		    	if ($errors->fails()) {
		    		return response()->json(['errors' => $errors->errors()->all()]);
		    	}
		    	$image = str_replace(url('public/user/img/banner').'/', '', $request->image);
			   	$request->merge(['image' => $image]);
		    	$form_data = [
		    		'image' => $request->image,
		    		'type' => $request->type,
		    		'status' => $request->status,
		    		'title' => $request->title,
		    		'content' => $request->content,
		    	];
		    	Banner::create($form_data);
		    	return response()->json(['success' => 'Thêm mới thành công!']);
	    	}
	    	else{
	    		$rules = array(
		    		'image' => 'required',
		    		'type' => 'required',
		    		'status' => 'required'
		    	);
		    	$messages = array(
		    		'image.required' =>'Ảnh không được để trống',
		    		'type.required' =>'Loại không được để trống',
		    		'status.required' =>'Trạng thái không được để trống',
		    	);
		    	$errors = Validator::make($request->all(),$rules,$messages);
		    	if ($errors->fails()) {
		    		return response()->json(['errors' => $errors->errors()->all()]);
		    	}
		    	$image = str_replace(url('public/user/img/banner').'/', '', $request->image);
			   	$request->merge(['image' => $image]);
		    	$form_data = [
		    		'image' => $request->image,
		    		'type' => $request->type,
		    		'status' => $request->status,
		    		'title' => '',
		    		'content' => ''
		    	];
		    	Banner::create($form_data);
		    	return response()->json(['success' => 'Thêm mới thành công!']);
		    }
		}

	    public function destroy($id){
	    	$banner = Banner::find($id);
	    	if ($banner) {
		    	$banner->delete();
		    	return response()->json(['success' => 'Xóa thành công!']);	
	    	}else{
	    		return response()->json(['errors' => 'Không thể xóa!']);	
	    	}
	    }

	    public function update(Request $request,$id){
	    	$request->offsetUnset('_token');
            $request->offsetUnset('_method');
	    	if ($request->has('title')) {
		    	$rules = array(
		    		'title' => 'required|max:200',
		    		'content' => 'required|max:200',
		    		'type' => 'required',
		    		'status' => 'required'
		    	);
		    	$messages = array(
		    		'title.required' =>'Tiêu đề không được để trống',
		    		'title.max' =>'Tiêu đề không được quá 20 ký tự',
		    		'content.required' =>'Nội dung không được để trống',
		    		'content.max' =>'Nội dung không được quá 40 ký tự',
		    		'type.required' =>'Loại không được để trống',
		    		'status.required' =>'Trạng thái không được để trống',
		    	);
		    	$errors = Validator::make($request->all(),$rules,$messages);
		    	if ($errors->fails()) {
		    		return response()->json(['errors' => $errors->errors()->all()]);
		    	}
		    	if (!empty($request->image)) {
		    		$image = str_replace(url('public/user/img/banner').'/', '', $request->image);
				   	$request->merge(['image' => $image]);
			    	$form_data = [
			    		'image' => $request->image,
			    		'type' => $request->type,
			    		'status' => $request->status,
			    		'title' => $request->title,
			    		'content' => $request->content
			    	];
		    	}else{
		    		$form_data = [
			    		'type' => $request->type,
			    		'status' => $request->status,
			    		'title' => $request->title,
			    		'content' => $request->content
			    	];
		    	}
		    	Banner::whereId($id)->update($form_data);
		    	return response()->json(['success' => 'Sửa thành công!']);
	    	}
	    	else{
	    		$rules = array(
		    		'type' => 'required',
		    		'status' => 'required'
		    	);
		    	$messages = array(
		    		'type.required' =>'Loại không được để trống',
		    		'status.required' =>'Trạng thái không được để trống',
		    	);
		    	$errors = Validator::make($request->all(),$rules,$messages);
		    	if ($errors->fails()) {
		    		return response()->json(['errors' => $errors->errors()->all()]);
		    	}
		    	if (!empty($request->image)) {
		    		$image = str_replace(url('public/user/img/banner').'/', '', $request->image);
				   	$request->merge(['image' => $image]);
			    	$form_data = [
			    		'image' => $request->image,
			    		'type' => $request->type,
			    		'status' => $request->status,
			    		'title' => $request->title,
			    		'content' => $request->content
			    	];
		    	}else{
		    		$form_data = [
			    		'type' => $request->type,
			    		'status' => $request->status,
			    		'title' => $request->title,
			    		'content' => $request->content
			    	];
		    	}
		    	Banner::whereId($id)->update($form_data);
		    	return response()->json(['success' => 'Sửa thành công!']);
		    }
	    }

	    public function edit($id){
    		$model = Banner::find($id);
    		return response()->json(['data' => $model]);
	    }

	}
 ?>