<?php 
	namespace App\Http\Controllers\Admin;

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\Customer;
	use App\Models\Category;
	use App\Models\Color;
	use App\Models\Review;
	use App\Models\Orders;
	use App\Models\Orderdetail;
	use App\Models\Payment;
	use App\Models\Delivery;
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
	use App\Mail\SendMail;
	use Mail;

	/**
	 * summary
	 */
	class OrderController extends Controller
	{
	    /**
	     * summary
	     */
	    function __construct()
        {
             $this->middleware('permission:order-list|order-create|order-edit|order-delete', ['only' => ['index','store']]);
             $this->middleware('permission:order-create', ['only' => ['create','store']]);
             $this->middleware('permission:order-edit', ['only' => ['edit','update']]);
             $this->middleware('permission:order-delete', ['only' => ['destroy']]);
        }
	    
	    public function index(){
	    	$listOrd = Orders::get();
	    	$listPay = Payment::get();
	    	$listDeli = Delivery::get();
	        return view('admin/order/index',compact('listOrd','listDeli','listPay'));
	    }


	    public function destroy($id){
	    	$ord = Orders::find($id);
	    	$data = Orderdetail::where('orderId',$ord->id)->get();
	    	if (count($data) > 0) {
	    		return response()->json(['errors' => 'Đơn hàng không thể xóa!']);
	    	}else{
	    	$ord->delete();
	    	return response()->json(['success' => 'Xóa thành công!']);
	    	}
	    }

	    public function show($id){
	    	$user = Auth::user();
	    	$modelHasRole = ModelHasRoles::where('model_id',$user->id)->first();
	    	$role = Role::where('id',$modelHasRole->role_id)->first();
	    	$roleHasPermission = RoleHasPermissions::where('role_id',$role->id)->get();
	    	$permissionName = [];
	    	foreach ($roleHasPermission as $value) {
	    		$permission = Permission::where('id',$value->permission_id)->first();
	    		$permissionName[] = $permission['name'];
	    	}
	    	$rolePermission = collect($permissionName);
	    	
	    	$listOrdet = Orderdetail::where('id',$id)->get();
	    	return view('admin/order/detail',compact('listOrdet','rolePermission'));
	    }

	    public function update(Request $request,$id){
	    	$request->offsetUnset('_token');
            $request->offsetUnset('_method');
	    	$rules = [
	    		'cusName' => 'required',
	    		'cusEmail' => 'required|email',
	    		'address' => 'required',
	    		'paymentId' => 'required',
	    		'deliveryId' => 'required',
	    		'totalAmount' => 'required|numeric|min:0|not_in:0',
	    		'status' => 'required'
	    	];
	    	$messages = [
	    		'cusName.required' => 'Tên người nhận không được để trống',
	    		'cusEmail.required' => 'Email người nhận không được để trống',
	    		'cusEmail.email' => 'Email người nhận không đúng định dạng',
	    		'paymentId.required' => 'Hình thức thanh toán không được để trống',
	    		'deliveryId.required' => 'Hình thức giao hàng không được để trống',
	    		'totalAmount.required' => 'Tổng tiền không được để trống',
	    		'totalAmount.numeric' => 'Tổng tiền phải là số',
	    		'totalAmount.not_in' => 'Tổng tiền phải lớn hơn 0',
	    		'status.required' => 'Trạng thái không được để trống'
	    	];
	    	$errors = Validator::make($request->all(),$rules,$messages);
	    	if ($errors->fails()) {
	    		return response()->json(['errors' => $errors->errors()->all()]);
	    	}
	    	$form_data = [
	    		'cusName' => $request->cusName,
	    		'cusEmail' => $request->cusEmail,
	    		'address' => $request->address,
	    		'paymentId' => $request->paymentId,
	    		'deliveryId' => $request->deliveryId,
	    		'totalAmount' => $request->totalAmount,
	    		'status' => $request->status
	    	];
	    	if ($form_data['status'] == '2') {
	    		Mail::send('email.check-order',[
		        'name' => $request->cusName,
		        'id' => $id,
		        'email' => $request->cusEmail,
		        ],function($mail) use($request){
		            $mail->to($request->cusEmail,$request->cusName);
		            $mail->from('melanibeautyshop@gmail.com');
		            $mail->subject('Thông báo đang giao hàng');
		        });
		        Orders::whereId($request->id)->update($form_data);
		        return response()->json(['success' => 'Sửa thành công!']);
	    	}else{
		    	Orders::whereId($request->id)->update($form_data);
		    	return response()->json(['success' => 'Sửa thành công!']);	
	    	}
	    }

	    public function edit($id){
    		$model = Orders::join('customer','customer.id','=','orders.customerId')->select('customer.name as name','orders.*')->where('orders.id',$id)->first();
    		$totalAmount = $model->totalAmount;
    		$fee = $model->delivery->fee;
    		$totalAmountWithoutDeli = $totalAmount-$fee;
    		return response()->json(['data' => $model,'data1' => $totalAmountWithoutDeli]);
	    }

	    public function fetchTotal(Request $request){
	    	$newTotalAmount = $request->oldTotalAmount;
	    	if($request->deliveryId==1){
	    		$newTotalAmount += $request->fee;
	    	}
	    	if ($request->deliveryId==2) {
	    		$newTotalAmount += $request->fee;
	    	}
	    	return response()->json(['data' => $newTotalAmount]);
        }

        public function filterOrder(Request $request){
        	$listOrd = Orders::where('status',$request->status)->get();
        	return response()->json(['data' => $listOrd]);
        }

	}
 ?>