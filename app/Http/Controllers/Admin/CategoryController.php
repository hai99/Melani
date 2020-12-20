<?php 
	namespace App\Http\Controllers\Admin;

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\Category;
	use App\Models\Color;
	use App\Models\Sizes;
	use App\Models\Stocks;
	use App\User;
	use App\Http\Controllers\Controller;
	use Validator;
	use DataTables;
	use DB;
	use Hash;
    use Illuminate\Support\Arr;
	use App\Models\ModelHasRoles;
	use App\Models\RoleHasPermissions;
	use Illuminate\Support\Facades\Auth;
	use Spatie\Permission\Models\Role;
	use Spatie\Permission\Models\Permission;
	use Illuminate\Support\Collection;

	/**
	 * summary
	 */
	class CategoryController extends Controller
	{
	    /**
	     * summary
	     */
	    function __construct()
        {
             $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index','store']]);
             $this->middleware('permission:category-create', ['only' => ['create','store']]);
             $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
             $this->middleware('permission:category-delete', ['only' => ['destroy']]);
        }

	    public function index(){
	    	$listCat = Category::get();
	    	$listCat1 = Category::get();
	    	$listCat2 = Category::get();
	        return view('admin/category/index',compact('listCat','listCat1','listCat2'));
	    }

	    public function create(){
	    	$listCat = Category::get(); 
	    	return view('admin/category/add',compact('listCat'));
	    }

	    public function store(Request $request){
	    	$rules = [
	    		'name' => 'required|unique:category,name',
	    		'slug' => 'required|unique:category,slug',
	    		'status' => 'required'
	    	];
	    	$messages = [
	    		'name.required' => 'Tên danh mục không được để trống',
	    		'name.unique' => 'Tên danh mục đã tồn tại',
	    		'slug.required' => 'Tên thay thế không được để trống',
	    		'slug.unique' => 'Tên thay thế đã tồn tại',
	    		'status.required' => 'Trạng thái không được để trống'
	    	];
	    	$errors = Validator::make($request->all(),$rules,$messages);
	    	if ($errors->fails()) {
	    		return response()->json(['errors' => $errors->errors()->all()]);
	    	}
	    	Category::create($request->all());
	    	return response()->json(['success' => 'Thêm mới thành công!']);
	    }

	    public function destroy($id){
	    	$listPro = [];
	    	$cat = Category::where('id',$id)->first();
	    	$cat_child = Category::where('parentId',$cat['id'])->get();
	    	foreach ($cat_child as $value) {
	    		$products = Product::where('catalogId',$value['id'])->get();
	    		$listPro[] = $products;
	    	}
	    	if (count($listPro) > 0) {
	    		return response()->json(['errors' => 'Danh mục có sản phẩm. Không thể xóa!']);
	    	}else{
	    		$cat->delete();
	    		return response()->json(['success' => 'Xóa thành công!']);
	    	}
	    }

	    public function clear(Request $request){
	        $category_id_array = $request->id;
	        $category = Category::whereIn('id', $request->id);
	        if ($category) {
	        	$category->delete();
	        	return response()->json(['success' => 'Xóa thành công!']);
	        }else{
	        	return response()->json(['erros' => 'Xóa thất bại!']);
	        }
	    }

	    public function update(Request $request,$id){
	    	$rules = [
	    		'name' => 'required|unique:category,name,'.$id,
	    		'slug' => 'required|unique:category,slug,'.$id,
	    		'status' => 'required'
	    	];
	    	$messages = [
	    		'name.required' => 'Tên danh mục không được để trống',
	    		'name.unique' => 'Tên danh mục đã tồn tại',
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
	    		'parentId' => $request->parentId,
	    		'status' => $request->status
	    	];
	    	Category::whereId($request->id)->update($form_data);
	    	return response()->json(['success' => 'Sửa thành công!']);
	    }

	    public function edit($id){
    		$model = Category::find($id);
    		return response()->json(['data' => $model]);
	    }

	}
 ?>