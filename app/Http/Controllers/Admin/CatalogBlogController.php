<?php 
	namespace App\Http\Controllers\Admin;

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\Category;
	use App\Models\Color;
	use App\Models\CatalogBlog;
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
	class CatalogBlogController extends Controller
	{
	    /**
	     * summary
	     */
	    function __construct()
	    {
	         $this->middleware('permission:catalogBlog-list|catalogBlog-create|catalogBlog-edit|catalogBlog-delete', ['only' => ['index','store']]);
	         $this->middleware('permission:catalogBlog-create', ['only' => ['create','store']]);
	         $this->middleware('permission:catalogBlog-edit', ['only' => ['edit','update']]);
	         $this->middleware('permission:catalogBlog-delete', ['only' => ['destroy']]);
	    }
	    
	    public function index(){
	    	$listCatBlog = CatalogBlog::get();
	        return view('admin/catalogBlog/index',compact('listCatBlog'));
	    }

	    public function store(Request $request){
	    	$rules = [
	    		'name' => 'required|unique:catalogBlog,name',
	    		'slug' => 'required|unique:catalogBlog,slug',
	    		'status' => 'required'
	    	];
	    	$messages = [
	    		'name.required' => 'Tên danh mục không được để trống',
	    		'name.unique' => 'Danh mục đã tồn tại',
	    		'slug.required' => 'Tên thay thế không được để trống',
	    		'slug.unique' => 'Tên thay thế đã tồn tại',
	    		'status.required' => 'Trạng thái không được để trống'
	    	];
	    	$errors = Validator::make($request->all(),$rules,$messages);
	    	if ($errors->fails()) {
	    		return response()->json(['errors' => $errors->errors()->all()]);
	    	}
	    	$form_data = [
	    		'name' => $request->name,
	    		'slug' => $request->slug,
	    		'status' => $request->status
	    	];
	    	CatalogBlog::create($form_data);
	    	return response()->json(['success' => 'Thêm mới thành công!']);
	    }

	    public function destroy($id){
	    	$catalogBlog = CatalogBlog::find($id);
	    	$catalogBlog->delete();
	    	return response()->json(['success' => 'Xóa thành công!']);
	    }

	    public function update(Request $request,$id){
	    	$request->offsetUnset('_token');
            $request->offsetUnset('_method');
	    	$rules = [
	    		'name' => 'required|unique:catalogBlog,name,'.$id,
	    		'slug' => 'required|unique:catalogBlog,slug,'.$id,
	    		'status' => 'required'
	    	];
	    	$messages = [
	    		'name.required' => 'Tên danh mục không được để trống',
	    		'name.unique' => 'Danh mục đã tồn tại',
	    		'slug.required' => 'Tên thay thế không được để trống',
	    		'slug.unique' => 'Tên thay thế đã tồn tại',
	    		'status.required' => 'Trạng thái không được để trống'
	    	];
	    	$errors = Validator::make($request->all(),$rules,$messages);
	    	if ($errors->fails()) {
	    		return response()->json(['errors' => $errors->errors()->all()]);
	    	}
	    	$form_data = [
	    		'name' => $request->name,
	    		'slug' => $request->slug,
	    		'status' => $request->status
	    	];
	    	CatalogBlog::whereId($request->id)->update($form_data);
	    	return response()->json(['success' => 'Sửa thành công!']);
	    }

	    public function edit($id){
    		$model = CatalogBlog::find($id);
    		return response()->json(['data' => $model]);
	    }

	}
 ?>