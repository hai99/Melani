<?php 
	
	namespace App\Http\Controllers\User;

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\Category;
	use App\Models\WishList;
	use App\Models\Customer;
	use App\Models\Stocks;
	use App\Models\Payment;
	use App\Models\Delivery;
	use App\Models\Orders;
	use App\Models\Orderdetail;
	use App\Http\Controllers\Controller;
	use App\Helper\Cart;
	use RealRashid\SweetAlert\Facades\Alert;
	use Illuminate\Support\Facades\Session;
	use Validator;
	use Mail;

	/**
	 * summary
	 */
	class CartController extends Controller
	{
	    /**
	     * summary
	     */
	   
	    public function view(){
	    	return view('user/cart');
	    }

	    public function checkout(){
	    	$payments = Payment::where('status',1)->get();
	    	$deliveries = Delivery::where('status',1)->get();
	    	return view('user/checkout',compact('payments','deliveries'));
	    }

	    public function add(Request $request,Cart $cart){
	    	$quantity = $request->quantity > 0 ? $request->quantity : 1;
	    	if(is_null($request->price)){
	    		return response()->json(['error1' => 'Vui lòng chọn kích cỡ hoặc màu để xem giá']);
		    }else if($request->price == 0){
		    	return response()->json(['error1' => 'Sản phẩm đã hết hàng!']);
		    }
	    	if (is_null($request->colorId)) {
	    		$product = Stocks::where('productId',$request->productId)->whereNull('colorId')->where('sizeId',$request->sizeId)->first();
	    		$cart->add($product,$quantity);
	    	}
	    	else if (is_null($request->sizeId)) {
	    		$product = Stocks::where('productId',$request->productId)->whereNull('sizeId')->where('colorId',$request->colorId)->first();
	    		$cart->add($product,$quantity);
	    	}
	    	else{
	    		$product = Stocks::where('productId',$request->productId)->where('sizeId',$request->sizeId)->where('colorId',$request->colorId)->first();
	    		$cart->add($product,$quantity);
	    	}
    		if ($product) {
    			if ($product->importNum == 0) {
    				return response()->json(['errors' => 'Sản phẩm đã hết hàng!']);
    			}else if($quantity > 10){
    				$quantity = 10;
    			}else if($quantity > $product->importNum){
    				return response()->json(['error1' => 'Số lượng sản phẩm trong kho không đủ']);
    			}
    			$cart->add($product,$quantity);
    		}else{
    			return response()->json(['errors' => 'Sản phẩm đã hết hàng!']);
    		}
	    	return response()->json(['success' => 'Thêm vào giỏ hàng thành công!']);
	    }

	    public function update(Cart $cart,Request $request){
	    	$id = $request->cartId;
	    	$quantity = $request->quantity ? $request->quantity : 1;
	    	if ($quantity > 10) {
	    		$quantity = 10;
	    	}
	    	else if ($quantity == 0) {
	    		$quantity = 0;
	    	}
    		$cart->update($id,$quantity);
	    	return response()->json(['success' => 'Cập nhật thành công']);
	    }

	    public function remove(Cart $cart,Request $request){
	    	$id = $request->productId;
	    	$cart->remove($id);
	    	return response()->json(['success' => 'Xóa thành công!']);
	    }

	    public function clear(Cart $cart){
	    	$cart->clear();
	    	return response()->json(['success' => 'Xóa thành công!']);
	    }

	    public function fetchTotal(Request $request){
	    	$total_with_ship = $request->total_amount;
	    	if($request->deliveryId==1){
	    		$total_with_ship += $request->fee;
	    	}
	    	if ($request->deliveryId==2) {
	    		$total_with_ship += $request->fee;
	    	}
	    	return response()->json(['data' => $total_with_ship]);
        }

        public function addOrder(Request $request){
        	$customer = Customer::where('id',$request->customerId);
        	if ($customer) {
        		if ($request->deliveryId == null) {
        			return response()->json(['error1' => 'Phải chọn hình thức giao hàng']);
        		}else{
        			$rules = array(
        			'cusName' => 'required',
        			'cusEmail' => 'required|email',
        			'address' => 'required',
        			'phoneNumber' => 'required'
	        		);
	        		$messages = array(
	        			'cusName.required' => 'Tên người nhận không được để trống',
	        			'cusEmail.required' => 'Email không được để trống',
	        			'cusEmail.email' => 'Email không đúng định dạng',
	        			'address.required' => 'Địa chỉ người nhận không được để trống',
	        			'phoneNumber.required' => 'Số điện thoại người nhận không được để trống'
	        		);
	        		$errors = Validator::make($request->all(),$rules,$messages); 
			    	if ($errors->fails()) {
			    		return response()->json(['errors' => $errors->errors()->all()]);
			    	}else{
		        		$form_data = array(
		        			'customerId' => $request->customerId,
		        			'cusName' => $request->cusName,
		        			'cusEmail' => $request->cusEmail,
		        			'phoneNumber' => $request->phoneNumber,
		        			'address' => $request->address,
		        			'orderNote' => $request->orderNote,
		        			'paymentId' => $request->paymentId,
		        			'deliveryId' => $request->deliveryId,
		        			'totalAmount' => $request->totalAmount,
		        		);
		        		$order = Orders::create($form_data);
		        		$carts = Session::get('cart');
			        		if ($order) {
				        		foreach($carts as $cart){
				        			if ($cart['color'] == "") {
				        				$stock = Stocks::where('productId',$cart['id'])->whereNull('colorId')->where('sizeId',$cart['sizeId'])->first();
				        			}
				        			if ($cart['size'] == "") {
				        				$stock = Stocks::where('productId',$cart['id'])->whereNull('sizeId')->where('colorId',$cart['colorId'])->first();
				        			}
				        			else{
				        				$stock = Stocks::where('productId',$cart['id'])->where('sizeId',$cart['sizeId'])->where('colorId',$cart['colorId'])->first();
				        			}
				        			$form_data_ordet = array(
				        				'orderId' => $order->id,
				        				'stockId' => $stock['id'],
				        				'quantity' => $cart['quantity'],
				        				'price' => $cart['price']
				        			);
				        			$orderDetail = Orderdetail::create($form_data_ordet);

				        			$minusStock = [
				        				'importNum' => $stock['importNum']-$cart['quantity']
				        			];
					        		$stock->update($minusStock);
				        		}
			        			Mail::send('email.order',[
					            'order' => $order,
					            'carts' => $carts,
					            ],function($mail) use($order){
					                $mail->to($order->cusEmail,$order->cusName);
					                $mail->from('melanibeautyshop@gmail.com');
					                $mail->subject('Thông báo đặt hàng thành công!');
					            });
			        			$request->session()->forget('cart');
			        			return response()->json(['success' => 'Đặt hàng thành công!']);
				        	}
			        		else{
			        			return response()->json(['error' => 'Đã có lỗi xảy ra! Vui lòng thử lại.']);
			        		}

		        	}
        		}
        	}else{
				return response()->json(['error' => 'Đã có lỗi xảy ra! Vui lòng thử lại.']);
        	}
        }


}

	
 ?>