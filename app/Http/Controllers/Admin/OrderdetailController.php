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

	/**
	 * summary
	 */
	class OrderdetailController extends Controller
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

	    public function destroy(Request $request){
	    	$ordet = Orderdetail::find($request->id);
	    	if ($ordet) {
		    	$ordet->delete();
		    	return response()->json(['success' => 'Xóa thành công!']);
	    	}else{
	    		return response()->json(['errors' => 'Không thể xóa!']);
	    	}
	    }

	    public function changeStatus(Request $request){
	    	$rules = [
	    		'status' => 'required'
	    	];
	    	$messages = [
	    		'status.required' => 'Trạng thái không được để trống'
	    	];
	    	$errors = Validator::make($request->all(),$rules,$messages);
	    	if ($errors->fails()) {
	    		return response()->json(['errors' => $errors->errors()->all()]);
	    	}
	    	$form_data = [
	    		'status' => $request->status
	    	];
	    	Orderdetail::whereId($request->id)->update($form_data);
	    	return response()->json(['success' => 'Sửa thành công!']);
	    }

	    public function update(Request $request){
	    	$request->offsetUnset('_token');
            $request->offsetUnset('_method');
            $oldQuantity = Orderdetail::select('orderdetail.quantity')->where('stockId',$request->stockId)->first();
	    	$rules = [
	    		'quantity' => 'required|numeric|min:0|not_in:0'
	    	];
	    	$messages = [
	    		'quantity.required' => 'Số lượng không được để trống',
	    		'quantity.numeric' => 'Số lượng phải là số',
	    		'quantity.not_in' => 'Số lượng phải lớn hơn 0'
	    	];
	    	$errors = Validator::make($request->all(),$rules,$messages);
	    	if ($errors->fails()) {
	    		return response()->json(['errors' => $errors->errors()->all()]);
	    	}
	    	$form_data = [
	    		'quantity' => $request->quantity,
	    	];
	    	if (isset($form_data)) {
		    	$quantity = $request->quantity;
		    	$price = $request->price;
dd($request->totalAmount);
		    	$totalAmount = $request->totalAmount+($quantity*$price);
		    	$form_data1 = [
		    		'totalAmount' => $quantity*$price
		    	];
		    	
		    	Orderdetail::whereId($request->id)->update($form_data);
		    	Orders::whereId($request->orderId)->update($form_data_1);
		    	return response()->json(['success' => 'Sửa thành công!']);
	    	}
	    }

	    public function edit(Request $request){
    		$model = Orderdetail::join('stocks','stocks.id','=','orderdetail.stockId')->join('product','product.id','=','stocks.productId')->select('product.name as name','orderdetail.*')->where('orderdetail.id',$request->id)->first();
    		return response()->json(['data' => $model]);
	    }

	}
 ?>