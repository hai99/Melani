<?php 
	namespace App\Http\Controllers\Admin;

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\Category;
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
	class SizesController extends Controller
	{
	    /**
	     * summary
	     */
	    function __construct()
        {
             $this->middleware('permission:size-list|size-create|size-edit|size-delete', ['only' => ['index','store']]);
             $this->middleware('permission:size-create', ['only' => ['create','store']]);
             $this->middleware('permission:size-edit', ['only' => ['edit','update']]);
             $this->middleware('permission:size-delete', ['only' => ['destroy']]);
        }
	    
	    public function index(){
	    	$listSize = Sizes::get();
	        return view('admin/sizes/index',compact('listSize'));
	    }

	    public function store(Request $request){
	    	$rules = [
	    		'name' => 'required|unique:sizes,name',
	    		'status' => 'required'
	    	];
	    	$messages = [
	    		'name.required' => 'Tên kích cỡ không được để trống',
	    		'name.unique' => 'Kích cỡ đã tồn tại',
	    		'status.required' => 'Trạng thái không được để trống'
	    	];
	    	$errors = Validator::make($request->all(),$rules,$messages);
	    	if ($errors->fails()) {
	    		return response()->json(['errors' => $errors->errors()->all()]);
	    	}
	    	$form_data = [
	    		'name' => $request->name,
	    		'status' => $request->status
	    	];
	    	Sizes::create($form_data);
	    	return response()->json(['success' => 'Thêm mới thành công!']);
	    }

	    public function destroy($id){
	    	$size = Sizes::find($id);
	    	$size->delete();
	    	return response()->json(['success' => 'Xóa thành công!']);
	    }

	    public function update(Request $request,$id){
	    	$request->offsetUnset('_token');
            $request->offsetUnset('_method');
	    	$rules = [
	    		'name' => 'required|unique:sizes,name,'.$id,
	    		'status' => 'required'
	    	];
	    	$messages = [
	    		'name.required' => 'Tên kích cỡ không được để trống',
	    		'name.unique' => 'Kích cỡ đã tồn tại',
	    		'status.required' => 'Trạng thái không được để trống'
	    	];
	    	$errors = Validator::make($request->all(),$rules,$messages);
	    	if ($errors->fails()) {
	    		return response()->json(['errors' => $errors->errors()->all()]);
	    	}
	    	$form_data = [
	    		'name' => $request->name,
	    		'status' => $request->status
	    	];
	    	Sizes::whereId($request->id)->update($form_data);
	    	return response()->json(['success' => 'Sửa thành công!']);
	    }

	    public function edit($id){
    		$model = Sizes::find($id);
    		return response()->json(['data' => $model]);
	    }

	}
 ?>