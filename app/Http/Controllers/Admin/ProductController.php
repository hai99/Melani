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
	class ProductController extends Controller
	{
	    /**
	     * summary
	     */
	    function __construct()
	    {
	         $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
	         $this->middleware('permission:product-create', ['only' => ['create','store']]);
	         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
	         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
	    }

	    public function index(){
	    	$listCat = Category::get();
		   	$listPro = Product::orderBy('created_at','DESC')->get();
		   	return view('admin/product/index',compact('listPro','listCat'));
	   }

	   public function show($id){
	   	$model = Product::find($id);
	   	$listProSame = Stocks::where('productId',$id)->get();
	   	return view('admin/product/detail',compact('model','listProSame'));
	   }

	   public function create(){
	   	$listCat = Category::get();
	   	$listColor = Color::get();
	   	$listSize = Sizes::get();
	   	return view('admin/product/add',compact('listCat','listColor','listSize'));
	   }

	   public function store(Request $request){
	   	$rules = [
	   		'name' => 'required|unique:product,name',
	   		'slug' => 'required|unique:product,slug',
	   		'description' => 'required|max:500',
	   		'sizeId.*' => 'required',
	   		'colorId.*' => 'required',
	   		'importNum.*' => 'required|numeric|min:0|not_in:0',
	   		'importPrice.*' => 'required|numeric|min:0|not_in:0',
	   		'exportPrice.*' => 'required|numeric|min:0|not_in:0',
	   		'discount' => 'numeric|min:0|not_in:0|lt:100',
	   		'priority' => 'numeric|min:0|lt:5',
	   		'proView' => 'numeric|min:0',
	   		'image' => 'required',
	   		'catalogId' => 'required',
	   		'status' => 'required',
	   	];
	   	$messages = [
	   		'name.required' => 'Tên sản phẩm không được để trống',
	   		'name.unique' => 'Tên sản phẩm đã tồn tại',
	   		'slug.required' => 'Tên thay thế không được để trống',
	   		'slug.unique' => 'Tên thay thế đã tồn tại',
	   		'description.required' => 'Mô tả không được để trống',
	   		'description.max' => 'Mô tả không được quá 500 ký tự',
	   		'sizeId.*.required' => 'Kích cỡ không được để trống',
	   		'colorId.*.required' => 'Màu không được để trống',
	   		'importNum.*.required' => 'Số lượng nhập không được để trống',
	   		'importNum.*.numeric' => 'Số lượng nhập phải là số',
	   		'importNum.*.not_in' => 'Số lượng nhập phải lớn hơn 0',
	   		'importPrice.*.required' => 'Giá nhập không được để trống',
	   		'importPrice.*.numeric' => 'Giá nhập phải là số',
	   		'importPrice.*.not_in' => 'Giá nhập phải lớn hơn 0',
	   		'exportPrice.*.required' => 'Giá xuất không được để trống',
	   		'exportPrice.*.numeric' => 'Giá xuất phải là số',
	   		'exportPrice.*.not_in' => 'Giá xuất phải lớn hơn 0',
	   		'discount.numeric' => 'Phần trăm giảm giá phải là số',
	   		'discount.not_in' => 'Phần trăm giảm giá phải lớn hơn 0',
	   		'discount.lt' => 'Phần trăm giảm giá phải nhỏ hơn 100',
	   		'priority.numeric' => 'Độ ưu tiên phải là số',
	   		'priority.min' => 'Độ ưu tiên không được nhỏ hơn 0',
	   		'priority.lt' => 'Độ ưu tiên phải nhỏ hơn 5',
	   		'proView.numeric' => 'Lượt xem phải là số',
	   		'proView.min' => 'Lượt xem không được nhỏ hơn 0',
	   		'image.required' => 'Ảnh không được để trống',
	   		'catalogId.required' => 'Danh mục không được để trống',
	   		'status.required' => 'Trạng thái không được để trống',
	   	];
	   	$errors = Validator::make($request->all(),$rules,$messages);
        if($errors->fails()){
            return response()->json(['errors'=>$errors->errors()->all()]);
        }
	   	$image = str_replace(url('public/user/img/product').'/', '', $request->image);
	   	$request->merge(['image' => $image]);
	   	if (is_null($request->sizeId)) {
	   		return response()->json(['errors1'=> 'Bạn phải thêm giá và các đặc tính khác']);
	   	}
	   	$form_data = [
	   		'name' => $request->name,
	   		'slug' => $request->slug,
	   		'catalogId' => $request->catalogId,
	   		'priority' => $request->priority,
	   		'proView' => $request->proView,
	   		'image' => $request->image,
	   		'image_list' => $request->image_list,
	   		'description' => $request->description,
	   		'discount' => $request->discount,
	   		'status' => $request->status,
	   	];
	   	$product = Product::create($form_data);
	   	$colorId = $request->colorId;
	   	$sizeId = $request->sizeId;
	   	$importNum = $request->importNum;
	   	$importPrice = $request->importPrice;
	   	$exportPrice = $request->exportPrice;
	   	for ($i = 0; $i < count($sizeId); $i++) {
	   		$form_data_1 = [
	   			'productId' => $product->id,
	   			'colorId' => $colorId[$i],
	   			'sizeId' => $sizeId[$i],
	   			'importNum' => $importNum[$i],
	   			'importPrice' => $importPrice[$i],
	   			'exportPrice' => $exportPrice[$i],
	   			'status' => 1
	   		];

	   		Stocks::create($form_data_1);
	   	}
	   	return response()->json(['success' => 'Thêm mới thành công!']);
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
	    	Product::whereId($request->id)->update($form_data);
	    	return response()->json(['success' => 'Sửa thành công!']);
	    }

	    public function edit($id){
	    	$listCat = Category::get();
    		$model = Product::where('id',$id)->first();
    		$listProSame = Stocks::where('productId',$id)->get();
    		return view('admin/product/edit',compact('listCat','model','listProSame'));
	    }

	    public function update(Request $request,$id){
	    	$request->offsetUnset('_method');
            $request->offsetUnset('_token');
            $product = Product::find($id);
	    	$rules = [
		   		'name' => 'required|unique:product,name,'.$request->id,
		   		'slug' => 'required|unique:product,slug,'.$request->id,
		   		'description' => 'required|max:500',
		   		'discount' => 'numeric|min:0|not_in:0|lt:100',
		   		'priority' => 'numeric|min:0|lt:5',
		   		'proView' => 'numeric|min:0',
		   		'catalogId' => 'required',
		   		'status' => 'required',
		   	];
		   	$messages = [
		   		'name.required' => 'Tên sản phẩm không được để trống',
		   		'name.unique' => 'Tên sản phẩm đã tồn tại',
		   		'slug.required' => 'Tên thay thế không được để trống',
		   		'slug.unique' => 'Tên thay thế đã tồn tại',
		   		'description.required' => 'Mô tả không được để trống',
		   		'description.max' => 'Mô tả không được quá 500 ký tự',
		   		'discount.numeric' => 'Phần trăm giảm giá phải là số',
		   		'discount.not_in' => 'Phần trăm giảm giá phải lớn hơn 0',
		   		'discount.lt' => 'Phần trăm giảm giá phải nhỏ hơn 100',
		   		'priority.numeric' => 'Độ ưu tiên phải là số',
		   		'priority.min' => 'Độ ưu tiên không được nhỏ hơn 0',
		   		'priority.lt' => 'Độ ưu tiên phải nhỏ hơn 5',
		   		'proView.numeric' => 'Lượt xem phải là số',
		   		'proView.min' => 'Lượt xem không được nhỏ hơn 0',
		   		'catalogId.required' => 'Danh mục không được để trống',
		   		'status.required' => 'Trạng thái không được để trống',
		   	];
		   	$errors = Validator::make($request->all(),$rules,$messages);
	        if($errors->fails()){
	            return response()->json(['errors'=>$errors->errors()->all()]);
	        }
        	$image = str_replace(url('public/user/img').'/', '', $request->image);
		   	$request->merge(['image' => $image]);
		   	if (!empty($request->image)) {
			   	$form_data = [
			   		'name' => $request->name,
			   		'slug' => $request->slug,
			   		'catalogId' => $request->catalogId,
			   		'priority' => $request->priority,
			   		'proView' => $request->proView,
			   		'image' => $request->image,
			   		'image_list' => $request->image_list,
			   		'description' => $request->description,
			   		'discount' => $request->discount,
			   		'status' => $request->status,
			   	];
		   	}else{
		   		$form_data = [
			   		'name' => $request->name,
			   		'slug' => $request->slug,
			   		'catalogId' => $request->catalogId,
			   		'priority' => $request->priority,
			   		'proView' => $request->proView,
			   		'image_list' => $request->image_list,
			   		'description' => $request->description,
			   		'discount' => $request->discount,
			   		'status' => $request->status,
			   	];
		   	}
		   	Product::whereId($id)->update($form_data);
		   	return response()->json(['success' => 'Chỉnh sửa thành công!']);
		}

		public function destroy($id){
	    	$pro = Product::where('id',$id)->first();
	    	if ($pro){
	    		$pro->delete();
	    		return response()->json(['success' => 'Xóa thành công!']);
	    	}else{
	    		return response()->json(['errors' => 'Không thể xóa!']);
	    	}
	    }

	}
 ?>