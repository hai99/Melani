<?php 
	namespace App\Http\Controllers\Admin;

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\Category;
	use App\Models\Blog;
	use App\Models\CatalogBlog;
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
	class BlogController extends Controller
	{
	    /**
	     * summary
	     */
	    function __construct()
	    {
	         $this->middleware('permission:blog-list|blog-create|blog-edit|blog-delete', ['only' => ['index','store']]);
	         $this->middleware('permission:blog-create', ['only' => ['create','store']]);
	         $this->middleware('permission:blog-edit', ['only' => ['edit','update']]);
	         $this->middleware('permission:blog-delete', ['only' => ['destroy']]);
	    }

	    public function index(){
	    	$listBlog = Blog::paginate(10);
	    	$catalogBlogs = CatalogBlog::get();
	        return view('admin/blog/index',compact('listBlog','catalogBlogs'));
	    }

	    public function create(){
	    	$listCat = Category::get(); 
	    	return view('admin/category/add',compact('listCat'));
	    }

	    public function store(Request $request){
	    	$rules = array(
	    		'title' => 'required|unique:blog,title',
	    		'notes' => 'required|max:100|unique:blog,notes',
	    		'content' => 'required',
	    		'imageSrc' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
	    		'catalogBlogId' => 'required',
	    		'status' => 'required'
	    	);
	    	$messages = array(
	    		'title.required' =>'Tiêu đề không được để trống',
	    		'title.unique' =>'Tiêu đề đã tồn tại',
	    		'notes.required' =>'Ghi chú không được để trống',
	    		'notes.unique' =>'Ghi chú đã tồn tại',
	    		'notes.max' =>'Ghi chú không được quá 100 ký tự',
	    		'content.required' =>'Nội dung không được để trống',
	    		'imageSrc.required' =>'Ảnh không được để trống',
	    		'imageSrc.image' =>'Ảnh không đúng định dạng',
	    		'imageSrc.mimes' =>'Ảnh phải là định dạng jpeg,jpg,png hoặc gif',
	    		'imageSrc.max' =>'Kích cỡ ảnh quá lớn. Vui lòng chọn ảnh khác',
	    		'catalogBlogId.required' =>'Danh mục tin tức không được để trống',
	    		'status.required' =>'Trạng thái không được để trống'
	    	);
	    	$errors = Validator::make($request->all(),$rules,$messages);
	    	if ($errors->fails()) {
	    		return response()->json(['errors' => $errors->errors()->all()]);
	    	}
	    	$file = $request->imageSrc;
	    	$imageSrc = $file->getClientOriginalName();
	    	$file->move('public/user/img/blog',$imageSrc);
	    	$form_data = [
	    		'title' => $request->title,
	    		'notes' => $request->notes,
	    		'content' => $request->content,
	    		'status' => $request->status,
	    		'catalogBlogId' => $request->catalogBlogId,
	    		'imageSrc' => $imageSrc,
	    	];
	    	Blog::create($form_data);
	    	return response()->json(['success' => 'Thêm mới thành công!']);
	    }

	    public function destroy($id){
	    	$blog = Blog::find($id);
	    	$blog->delete();
	    	return response()->json(['success' => 'Xóa thành công!']);
	    }

	    public function update(Request $request,$id){
	    	$request->offsetUnset('_token');
            $request->offsetUnset('_method');
	    	$rules = array(
	    		'title' => 'required|unique:blog,title,'.$id,
	    		'notes' => 'required|max:100|unique:blog,notes,'.$id,
	    		'content' => 'required',
	    		'imageSrc' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
	    		'catalogBlogId' => 'required',
	    		'status' => 'required'
	    	);
	    	$messages = array(
	    		'title.required' =>'Tiêu đề không được để trống',
	    		'title.unique' =>'Tiêu đề đã tồn tại',
	    		'notes.required' =>'Ghi chú không được để trống',
	    		'notes.unique' =>'Ghi chú đã tồn tại',
	    		'notes.max' =>'Ghi chú không được quá 100 ký tự',
	    		'content.required' =>'Nội dung không được để trống',
	    		'imageSrc.image' =>'Ảnh không đúng định dạng',
	    		'imageSrc.mimes' =>'Ảnh phải là định dạng jpeg,jpg,png hoặc gif',
	    		'imageSrc.max' =>'Kích cỡ ảnh quá lớn. Vui lòng chọn ảnh khác',
	    		'catalogBlogId.required' =>'Danh mục tin tức không được để trống',
	    		'status.required' =>'Trạng thái không được để trống'
	    	);
	    	$errors = Validator::make($request->all(),$rules,$messages);
	    	if ($errors->fails()) {
	    		return response()->json(['errors' => $errors->errors()->all()]);
	    	}
	    	if ($request->avatar == null) {
	    		$form_data = [
		    		'title' => $request->title,
		    		'notes' => $request->notes,
		    		'content' => $request->content,
		    		'status' => $request->status
		    	];
		    	Blog::whereId($request->id)->update($form_data);
		    	return response()->json(['success' => 'Sửa thành công!']);
	    	}else{
		    	$file = $request->imageSrc;
		    	$imageSrc = $file->getClientOriginalName();
		    	$file->move('public/user/img/blog',$imageSrc);
		    	$form_data = [
		    		'title' => $request->title,
		    		'notes' => $request->notes,
		    		'content' => $request->content,
		    		'imageSrc' => $imageSrc,
		    		'status' => $request->status
		    	];
		    	Blog::whereId($request->id)->update($form_data);
		    	return response()->json(['success' => 'Sửa thành công!']);
	    	}
	    }

	    public function edit($id){
    		$model = Blog::find($id);
    		return response()->json(['data' => $model]);
	    }

	}
 ?>