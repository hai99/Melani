<?php 
	namespace App\Http\Controllers\Admin;

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\Category;
	use App\Models\Color;
	use App\Models\Payment;
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
	class PaymentController extends Controller
	{
	    /**
	     * summary
	     */
	    function __construct()
        {
             $this->middleware('permission:payment-list|payment-create|payment-edit|payment-delete', ['only' => ['index','store']]);
             $this->middleware('permission:payment-create', ['only' => ['create','store']]);
             $this->middleware('permission:payment-edit', ['only' => ['edit','update']]);
             $this->middleware('permission:payment-delete', ['only' => ['destroy']]);
        }
	    
	    public function index(){
	    	$listPay = Payment::get();
	        return view('admin/payment/index',compact('listPay'));
	    }

	    public function store(Request $request){
	    	$rules = [
	    		'name' => 'required|unique:payment,name',
	    		'status' => 'required'
	    	];
	    	$messages = [
	    		'name.required' => 'Tên không được để trống',
	    		'name.unique' => 'Tên đã tồn tại',
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
	    	Payment::create($form_data);
	    	return response()->json(['success' => 'Thêm mới thành công!']);
	    }

	    public function destroy($id){
	    	$payment = Payment::find($id);
	    	$payment->delete();
	    	return response()->json(['success' => 'Xóa thành công!']);
	    }

	    public function clear(Request $request){
	        $payment_id_array = $request->id;
	        $payment = Payment::whereIn('id', $request->id);
	        if ($payment) {
	        	$payment->delete();
	        	return response()->json(['success' => 'Xóa thành công!']);
	        }else{
	        	return response()->json(['erros' => 'Xóa thất bại!']);
	        }
	    }

	    public function update(Request $request,$id){
	    	$request->offsetUnset('_token');
            $request->offsetUnset('_method');
	    	$rules = [
	    		'name' => 'required|unique:payment,name,'.$id,
	    		'status' => 'required'
	    	];
	    	$messages = [
	    		'name.required' => 'Tên không được để trống',
	    		'name.unique' => 'Hình thức thanh toán đã tồn tại',
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
	    	Payment::whereId($request->id)->update($form_data);
	    	return response()->json(['success' => 'Sửa thành công!']);
	    }

	    public function edit($id){
    		$model = Payment::find($id);
    		return response()->json(['data' => $model]);
	    }

	}
 ?>