<?php 
	namespace App\Http\Controllers\Admin;

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\Category;
	use App\Models\Color;
	use App\Models\Sizes;
	use App\Models\Stocks;
	use App\Models\Customer;
	use App\Http\Controllers\Controller;
	use Validator;
	use DataTables;

	/**
	 * summary
	 */
	class CustomerController extends Controller
	{
	    /**
	     * summary
	     */
	    function __construct()
        {
             $this->middleware('permission:customer-list|customer-create|customer-edit|customer-delete', ['only' => ['index','store']]);
             $this->middleware('permission:customer-create', ['only' => ['create','store']]);
             $this->middleware('permission:customer-edit', ['only' => ['edit','update']]);
             $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
        }
	    
	    public function index(){
	    	$listCus = Customer::get();
	        return view('admin/customer/index',compact('listCus'));
	    }

	    public function store(Request $request){
	    	$rules = array(
	    		'name' => 'required|unique:customer,name',
	    		'email' => 'required|email|unique:customer,email',
	    		'phoneNumber' => 'required',
	    		'address' => 'required',
	    		'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
	    		'pass' => 'required'
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
	    		'pass.required' =>'Mật khẩu không được để trống'
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
	    		'status' => $request->status
	    	];
	    	Customer::create($form_data);
	    	return response()->json(['success' => 'Thêm mới thành công!']);
	    }

	    public function destroy($id){
	    	$customer = Customer::find($id);
	    	$customer->delete();
	    	return response()->json(['success' => 'Xóa thành công!']);
	    }

	    public function update(Request $request,$id){
	    	$request->offsetUnset('_token');
            $request->offsetUnset('_method');
	    	$rules = array(
	    		'name' => 'required|unique:customer,name,'.$id,
	    		'email' => 'required|email|unique:customer,email,'.$id,
	    		'phoneNumber' => 'required',
	    		'address' => 'required',
	    		'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048,'.$id,
	    		'pass' => 'required'
	    	);
	    	$messages = array(
	    		'name.required' =>'Tên đăng nhập không được để trống',
	    		'name.unique' =>'Tên đăng nhập đã tồn tại',
	    		'email.required' =>'Email không được để trống',
	    		'email.unique' =>'Email đã tồn tại',
	    		'email.email' =>'Email không đúng định dạng',
	    		'phoneNumber.required' =>'Số điện thoại không được để trống',
	    		'address.required' =>'Địa chỉ không được để trống',
	    		'avatar.image' =>'Ảnh đại diện không đúng định dạng',
	    		'avatar.mimes' =>'Ảnh đại diện phải là định dạng jpeg,jpg,png hoặc gif',
	    		'avatar.max' =>'Kích cỡ ảnh quá lớn. Vui lòng chọn ảnh đại diện khác',
	    		'pass.required' =>'Mật khẩu không được để trống'
	    	);
	    	$errors = Validator::make($request->all(),$rules,$messages);
	    	if ($errors->fails()) {
	    		return response()->json(['errors' => $errors->errors()->all()]);
	    	}
	    	if ($request->avatar == null) {
	    		$form_data = [
		    		'name' => $request->name,
		    		'pass' => $request->pass,
		    		'email' => $request->email,
		    		'phoneNumber' => $request->phoneNumber,
		    		'address' => $request->address,
		    		'status' => $request->status
		    	];
		    	Customer::whereId($request->id)->update($form_data);
		    	return response()->json(['success' => 'Sửa thành công!']);
	    	}else{
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
		    		'status' => $request->status
		    	];
		    	Customer::whereId($request->id)->update($form_data);
		    	return response()->json(['success' => 'Sửa thành công!']);
	    	}
	    }

	    public function edit($id){
    		$model = Customer::find($id);
    		return response()->json(['data' => $model]);
	    }

	}
 ?>