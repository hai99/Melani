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

	/**
	 * summary
	 */
	class ColorController extends Controller
	{
	    /**
	     * summary
	     */
	    function __construct()
        {
             $this->middleware('permission:color-list|color-create|color-edit|color-delete', ['only' => ['index','store']]);
             $this->middleware('permission:color-create', ['only' => ['create','store']]);
             $this->middleware('permission:color-edit', ['only' => ['edit','update']]);
             $this->middleware('permission:color-delete', ['only' => ['destroy']]);
        }
	    
	    public function index(){
	    	$listColor = Color::get();
	        return view('admin/color/index',compact('listColor'));
	    }

	    public function store(Request $request){
	    	$rules = [
	    		'name' => 'required|unique:color,name',
	    		'status' => 'required'
	    	];
	    	$messages = [
	    		'name.required' => 'Tên màu không được để trống',
	    		'name.unique' => 'Tên màu đã tồn tại',
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
	    	Color::create($form_data);
	    	return response()->json(['success' => 'Thêm mới thành công!']);
	    }

	    public function destroy($id){
	    	$color = Color::find($id);
	    	$color->delete();
	    	return response()->json(['success' => 'Xóa thành công!']);
	    }

	    public function clear(Request $request){
	        $color_id_array = $request->id;
	        $color = Color::whereIn('id', $request->id);
	        if ($color) {
	        	$color->delete();
	        	return response()->json(['success' => 'Xóa thành công!']);
	        }else{
	        	return response()->json(['erros' => 'Xóa thất bại!']);
	        }
	    }

	    public function update(Request $request,$id){
	    	$request->offsetUnset('_token');
            $request->offsetUnset('_method');
	    	$rules = [
	    		'name' => 'required|unique:color,name,'.$id,
	    		'status' => 'required'
	    	];
	    	$messages = [
	    		'name.required' => 'Tên màu không được để trống',
	    		'name.unique' => 'Màu đã tồn tại',
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
	    	Color::whereId($request->id)->update($form_data);
	    	return response()->json(['success' => 'Sửa thành công!']);
	    }

	    public function edit($id){
    		$model = Color::find($id);
    		return response()->json(['data' => $model]);
	    }

	}
 ?>