<?php 
	namespace App\Http\Controllers\Admin;

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\Category;
	use App\Models\Delivery;
	use App\Models\Color;
	use App\Models\Sizes;
	use App\Models\Stocks;
	use App\Http\Controllers\Controller;
	use Validator;
	use DataTables;

	/**
	 * summary
	 */
	class DeliveryController extends Controller
	{
	    /**
	     * summary
	     */
	    function __construct()
        {
             $this->middleware('permission:delivery-list|delivery-create|delivery-edit|delivery-delete', ['only' => ['index','store']]);
             $this->middleware('permission:delivery-create', ['only' => ['create','store']]);
             $this->middleware('permission:delivery-edit', ['only' => ['edit','update']]);
             $this->middleware('permission:delivery-delete', ['only' => ['destroy']]);
        }
	    
	    public function index(){
	    	$listDeli = Delivery::get();
	        return view('admin/delivery/index',compact('listDeli'));
	    }

	    public function store(Request $request){
	    	$rules = [
	    		'name' => 'required|unique:delivery,name',
	    		'fee' => 'required|numeric|min:0|not_in:0',
	    		'status' => 'required'
	    	];
	    	$messages = [
	    		'name.required' => 'Tên không được để trống',
	    		'name.unique' => 'Hình thức giao hàng đã tồn tại',
	    		'fee.required' => 'Phí không được để trống',
	    		'fee.numeric' => 'Phí phải là số',
	    		'fee.not_in' => 'Phí phải lớn hơn 0',
	    		'status.required' => 'Trạng thái không được để trống'
	    	];
	    	$errors = Validator::make($request->all(),$rules,$messages);
	    	if ($errors->fails()) {
	    		return response()->json(['errors' => $errors->errors()->all()]);
	    	}
	    	$form_data = [
	    		'name' => $request->name,
	    		'fee' => $request->fee,
	    		'status' => $request->status
	    	];
	    	Delivery::create($form_data);
	    	return response()->json(['success' => 'Thêm mới thành công!']);
	    }

	    public function destroy($id){
	    	$delivery = Delivery::find($id);
	    	$delivery->delete();
	    	return response()->json(['success' => 'Xóa thành công!']);
	    }

	    public function clear(Request $request){
	        $delivey_id_array = $request->id;
	        $delivey = Delivery::whereIn('id', $request->id);
	        if ($delivey) {
	        	$delivey->delete();
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
	    		'fee' => 'required|numeric|min:0|not_in:0',
	    		'status' => 'required'
	    	];
	    	$messages = [
	    		'name.required' => 'Tên màu không được để trống',
	    		'name.unique' => 'Màu đã tồn tại',
	    		'fee.required' => 'Phí không được để trống',
	    		'fee.numeric' => 'Phí phải là số',
	    		'fee.not_in' => 'Phí phải lớn hơn 0',
	    		'status.required' => 'Trạng thái không được để trống'
	    	];
	    	$errors = Validator::make($request->all(),$rules,$messages);
	    	if ($errors->fails()) {
	    		return response()->json(['errors' => $errors->errors()->all()]);
	    	}
	    	$form_data = [
	    		'name' => $request->name,
	    		'fee' => $request->fee,
	    		'status' => $request->status
	    	];
	    	Delivery::whereId($request->id)->update($form_data);
	    	return response()->json(['success' => 'Sửa thành công!']);
	    }

	    public function edit($id){
    		$model = Delivery::find($id);
    		return response()->json(['data' => $model]);
	    }

	}
 ?>