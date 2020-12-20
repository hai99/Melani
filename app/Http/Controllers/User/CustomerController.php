<?php 
	namespace App\Http\Controllers\User;

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\Category;
	use App\Models\Customer;
	use App\Models\Orders;
	use App\Models\Stocks;
	use App\Models\Sizes;
	use App\Models\Color;
	use App\Models\Orderdetail;
	use App\Http\Controllers\Controller;
	use Illuminate\Support\Facades\Session;
	use Validator;


	/**
	 * summary
	 */
	class CustomerController extends Controller
	{
	    public function login(Request $request){
	    	$rules = array(
	    		'name' => 'required',
	    		'pass' => 'required'
	    	);
	    	$messages = array(
	    		'name.required' => 'Tên đăng nhập không được để trống',
	    		'pass.required' => 'Mật khẩu không được để trống'
 	    	);
 	    	$errors = Validator::make($request->only('name','pass'),$rules,$messages);
 	    	if ($errors->fails()) {
 	    		return response()->json(['errors' => $errors->errors()->all()]);
 	    	}
 	    	$cus = Customer::where('name','like',$request->name)->where('pass','like',$request->pass)->first();
 	    	if (empty($cus)) {
 	    		return response()->json(['error' => 'Tài khoản không tồn tại']);
 	    	}else{
 	    		$request->session()->put('customer',$cus);
 	    		return response()->json(['success' => 'Đăng nhập thành công']);
 	    	}
	    }

	    public function logout(Request $request){
	    	$request->session()->forget('customer');
	    	return response()->json(['success'=>'Đăng xuất thành công']);
	    }

	    public function registerPage(){
	        return view('user/register');
		}
	    
	    public function register(Request $request){
	    	$file = $request->avatar;
	    	$rules = array(
	    		'name' => 'required|unique:customer,name',
	    		'email' => 'required|email|unique:customer,email',
	    		'phoneNumber' => 'required',
	    		'address' => 'required',
	    		'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
	    		'pass' => 'required',
	    		'confirm_pass' => 'required|same:pass'
	    	);
	    	$messages = array(
	    		'name.required' =>'Tên đăng nhập không được để trống',
	    		'name.unique' =>'Tên đăng nhập đã tồn tại',
	    		'email.required' =>'Email không được để trống',
	    		'email.unique' =>'Email đã tồn tại',
	    		'email.email' =>'Email không đúng định dạng',
	    		'phoneNumber.required' =>'Số điện thoại không được để trống',
	    		'address.required' =>'Địa chỉ không được để trống',
	    		'avatar.required' =>'Ảnh đại diện không được để trống',
	    		'avatar.image' =>'Ảnh đại diện không đúng định dạng',
	    		'avatar.mimes' =>'Ảnh đại diện phải là định dạng jpeg,jpg,png hoặc gif',
	    		'avatar.max' =>'Kích cỡ ảnh quá lớn. Vui lòng chọn ảnh đại diện khác',
	    		'pass.required' =>'Mật khẩu không được để trống',
	    		'confirm_pass.required' =>'Nhập lại mật khẩu',
	    		'confirm_pass.same' =>'Mật khẩu nhập lại không đúng',
	    	);
	    	$errors = Validator::make($request->all(),$rules,$messages); 
	    	if ($errors->fails()) {
	    		return response()->json(['errors' => $errors->errors()->all()]);
	    	}
	    	$file = $request->avatar;
	    	$avatar = $file->getClientOriginalName();
	    	$file->move('public/user/img/avatar',$avatar);
	    	$form_data = [
	    		'name' => $request->name,
	    		'pass' => $request->pass,
	    		'email' => $request->email,
	    		'phoneNumber' => $request->phoneNumber,
	    		'address' => $request->address,
	    		'avatar' => $avatar,
	    	];
	    	Customer::create($form_data);
	    	return response()->json(['success' => 'Đăng ký thành công']);
	    }

	    public function my_account(Request $request){
	    	if (!empty(Session::has('customer'))) {
		    	$cusId = $request->session()->get('customer');
		    	$customer = Customer::where('id',$cusId->id)->first();
		    	$orders = Orders::where('customerId',$cusId->id)->get();
		        return view('user/my-account',compact('orders','customer'));
	    	}else{
	    		return redirect()->route('home');
	    	}
		}

	    public function cusEdit(Request $request){
	    	$request->offsetUnset('_token');
	    	if ($request->action == 'Edit') {
	    		$rules = array(
	    		'name' => 'required|unique:customer,name,'.$request->customerId,
	    		'email' => 'required|email|unique:customer,email,'.$request->customerId,
	    		'phoneNumber' => 'required',
	    		'address' => 'required'
		    	);
		    	$messages = array(
		    		'name.required' =>'Tên đăng nhập không được để trống',
		    		'name.unique' =>'Tên đăng nhập đã tồn tại',
		    		'email.required' =>'Email không được để trống',
		    		'email.unique' =>'Email đã tồn tại',
		    		'email.email' =>'Email không đúng định dạng',
		    		'phoneNumber.required' =>'Số điện thoại không được để trống',
		    		'address.required' =>'Địa chỉ không được để trống'
		    	);
		    	$errors = Validator::make($request->all(),$rules,$messages); 
		    	if ($errors->fails()) {
		    		return response()->json(['errors' => $errors->errors()->all()]);
		    	}
		    	$cus = Customer::where('id',$request->customerId)->first();
		    	$form_data = [
		    		'name' => $request->name,
		    		'email' => $request->email,
		    		'phoneNumber' => $request->phoneNumber,
		    		'address' => $request->address,
		    		'pass' => $cus->pass,
		    		'status' => $cus->status
		    	];
		    	Customer::where('id',$cus->id)->update($form_data);
		    	return response()->json(['success' => 'Chỉnh sửa thành công']);
	    	}

	    	if ($request->action == 'Change') {
	    		$rules = array(
		    		'old_pass' => 'required',
		    		'new_pass' => 'required|between:5,15',
		    		'confirm_new_pass' => 'required|same:new_pass'
		    	);
		    	$messages = array(
		    		'old_pass.required' => 'Nhập mật khẩu cũ của bạn',
		    		'new_pass.required' => 'Mật khẩu mới không được để trống',
		    		'new_pass.between' => 'Mật khẩu mới chỉ được phép chứa từ 5 đến 15 ký tự',
		    		'confirm_new_pass.required' => 'Nhập lại mật khẩu mới',
		    		'confirm_new_pass.same' => 'Mật khẩu nhập lại không đúng'
		    	);
		    	$errors = Validator::make($request->all(),$rules,$messages); 
		    	if ($errors->fails()) {
		    		return response()->json(['errors' => $errors->errors()->all()]);
		    	}
		    	$cus = Customer::where('id',$request->customerId)->first();
		    	if ($cus['pass'] != $request->old_pass) {
		    		return response()->json(['errors1' =>'Mật khẩu cũ không khớp']);
		    	}
		    	$form_data = [
		    		'pass' => $request->new_pass
		    	];
		    	Customer::where('id',$cus->id)->update($form_data);
		    	return response()->json(['success' => 'Đổi mật khẩu thành công']);
	    	}
	    }

	    public function update(Request $request){
	    	// dd($request);
	    	// if (isset($request->name) && isset($request->email) && isset($request->phoneNumber) && isset($request->address)) {
	    	// 	return response()->json(['success'=> 'Lưu thành công']);
	    	// }
	    	// else{
		    	$rules = array(
		    		'cus_name' => 'required|unique:customer,name,'.$request->id,
		    		'cus_email' => 'required|email|unique:customer,email,'.$request->id,
		    		'cus_address' => 'required',
		    		'cus_phoneNumber' => 'required'
		    	);
		    	$messages = array(
		    		'cus_name.required' =>'Tên đăng nhập không được để trống',
		    		'cus_name.unique' =>'Tên đăng nhập đã tồn tại',
		    		'cus_email.required' =>'Email không được để trống',
		    		'cus_email.unique' =>'Email đã tồn tại',
		    		'cus_email.email' =>'Email không đúng định dạng',
		    		'cus_phoneNumber.required' =>'Số điện thoại không được để trống',
		    		'cus_address.required' =>'Địa chỉ không được để trống'
		    	);
		    	$error = Validator::make($request->all(),$rules,$messages);
		    	if ($error->fails()) {
		    		return response()->json(['errors' => $error->errors()->all()]);
		    	}
		    	$form_data = array(
		    		'cus_name' => $request->name,
		    		'cus_email' => $request->email,
		    		'cus_phoneNumber' => $request->phoneNumber,
		    		'cus_address' => $request->address
		    	);
		    	Customer::whereId($request->hidden_id)->update($form_data);
		    	return response()->json(['success'=> 'Chỉnh sửa thành công']);
		    // }
		}

		public function orderView(Request $request){
			$data = [];
			$ordetss = [];
			$ordet = Orderdetail::where('orderId',$request->orderId)->get();
			foreach ($ordet as $value) {
				$stock = Stocks::where('id',$value['stockId'])->first();
				if ($stock['colorId'] == null) {
					$ordets = Stocks::join('product','stocks.productId','=','product.id')->join('sizes','sizes.id','=','stocks.sizeId')->join('orderdetail','orderdetail.stockId','=','stocks.id')->select('product.name as name','stocks.exportPrice as price','orderdetail.price as totalAmount','orderdetail.quantity as quantity','sizes.name as size','colorId')->where('sizes.id',$stock['sizeId'])->where('product.id',$stock['productId'])->where('stocks.id',$value['stockId'])->whereNull('colorId')->get();
				}else if ($stock['sizeId'] == null) {
					$ordets = Stocks::join('product','stocks.productId','=','product.id')->join('color','color.id','=','stocks.colorId')->join('orderdetail','orderdetail.stockId','=','stocks.id')->select('product.name as name','stocks.exportPrice as price','orderdetail.price as totalAmount','orderdetail.quantity as quantity','color.name as color','sizeId')->where('color.id',$stock['colorId'])->whereNull('sizeId')->where('product.id',$stock['productId'])->where('stocks.id',$value['stockId'])->get();
				}else{
					$ordets = Stocks::join('product','stocks.productId','=','product.id')->join('color','color.id','=','stocks.colorId')->join('sizes','sizes.id','=','stocks.sizeId')->join('orderdetail','orderdetail.stockId','=','stocks.id')->select('product.name as name','stocks.exportPrice as price','orderdetail.price as totalAmount','orderdetail.quantity as quantity','color.name as color','sizes.name as size')->where('color.id',$stock['colorId'])->where('sizes.id',$stock['sizeId'])->where('product.id',$stock['productId'])->where('stocks.id',$value['stockId'])->get();
				}
				$ordetss[] = $ordets;
			}

				foreach ($ordetss as $key => $item) {
					foreach ($item as $value) {
						if ($value['colorId'] == null) {
							$values = [
								'name' => $value['name'],
								'price' => $value['price'],
								'quantity' => $value['quantity'],
								'size' => $value['size'] ? $value['size'] : 'Không',
								'color' => 'Không'
							];
						}
						else if ($value['sizeId'] == null) {
							$values = [
								'name' => $value['name'],
								'price' => $value['price'],
								'quantity' => $value['quantity'],
								'color' => $value['color'] ? $value['color'] : 'Không',
								'size' => 'Không'
							];
						}
						else{
							$values = [
								'name' => $value['name'],
								'price' => $value['price'],
								'quantity' => $value['quantity'],
								'color' => $value['color'] ? $value['color'] : 'Không',
								'size' => $value['size'] ? $value['size'] : 'Không'
							];
						}
						$data[] = $values;
					}
				}
			return response()->json(['data' => $data]);
		}

		public function postAvatar(Request $request){
			$rules= [
				'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
			];
			$messages = [
				'avatar.image' =>'Ảnh đại diện không đúng định dạng',
				'avatar.required' =>'Phải chọn tệp',
	    		'avatar.mimes' =>'Ảnh đại diện phải là định dạng jpeg,jpg,png hoặc gif',
	    		'avatar.max' =>'Kích cỡ ảnh quá lớn. Vui lòng chọn ảnh đại diện khác'
			];
			$errors = Validator::make($request->all(),$rules,$messages); 
	    	if ($errors->fails()) {
	    		return response()->json(['errors' => $errors->errors()->all()]);
	    	}
				$file = $request->avatar;
				$avatar = $file->getClientOriginalName();
		    	$file->move('public/user/img/avatar',$avatar);
	    		$form_data = [
	    			'avatar' => $avatar
	    		];
		    	Customer::whereId($request->customerId)->update($form_data);
		    	return response()->json(['success'=> 'Đổi ảnh đại diện thành công']);
		}

	}
 ?>