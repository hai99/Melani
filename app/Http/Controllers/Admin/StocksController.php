<?php 
	namespace App\Http\Controllers\Admin;

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\Category;
	use App\Models\Color;
	use App\Models\Sizes;
	use App\Models\Stocks;
	use Validator;
	use DataTables;
	use App\Http\Controllers\Controller;
	use App\Models\ModelHasRoles;
	use App\Models\RoleHasPermissions;
	use Illuminate\Support\Facades\Auth;
	use Spatie\Permission\Models\Role;
	use Spatie\Permission\Models\Permission;
	use Illuminate\Support\Collection;

	/**
	 * summary
	 */
	/**
	 * summary
	 */
	class StocksController extends Controller
	{
	    /**
	     * summary
	     */
	    function __construct()
        {
             $this->middleware('permission:stocks-list|stocks-create|stocks-edit|stocks-delete', ['only' => ['index','store']]);
             $this->middleware('permission:stocks-create', ['only' => ['create','store']]);
             $this->middleware('permission:stocks-edit', ['only' => ['edit','update']]);
             $this->middleware('permission:stocks-delete', ['only' => ['destroy']]);
        }
	    
	   public function index(){
	   	$listStocks = Stocks::get();
	   	$listColor = Color::get();
	   	$listSize = Sizes::get();
	   	return view('admin/stocks/index',compact('listStocks','listColor','listSize'));
	   }

	    public function update(Request $request,$id){
	    	$request->offsetUnset('_token');
	        $request->offsetUnset('_method');
	    	$rules = [
	    		'colorId' => 'required',
	    		'sizeId' => 'required',
		   		'importNum' => 'required|numeric|min:0|not_in:0',
		   		'importPrice' => 'required|numeric|min:0|not_in:0',
		   		'exportPrice' => 'required|numeric|min:0|not_in:0',
	    		'status' => 'required'
	    	];
	    	$messages = [
	    		'colorId.required' => 'Màu không được để trống', 
	    		'sizeId.required' => 'Kích cỡ không được để trống', 
	    		'importNum.required' => 'Số lượng nhập không được để trống',
		   		'importNum.numeric' => 'Số lượng nhập phải là số',
		   		'importNum.not_in' => 'Số lượng nhập phải lớn hơn 0',
		   		'importPrice.required' => 'Giá nhập không được để trống',
		   		'importPrice.numeric' => 'Giá nhập phải là số',
		   		'importPrice.not_in' => 'Giá nhập phải lớn hơn 0',
		   		'exportPrice.required' => 'Giá xuất không được để trống',
		   		'exportPrice.numeric' => 'Giá xuất phải là số',
		   		'exportPrice.not_in' => 'Giá xuất phải lớn hơn 0',
	    		'status.required' => 'Trạng thái không được để trống'
	    	];
	    	$errors = Validator::make($request->all(),$rules,$messages);
	    	if ($errors->fails()) {
	    		return response()->json(['errors' => $errors->errors()->all()]);
	    	}
	    	$form_data = [
	   			'colorId' => $request->colorId,
	   			'sizeId' => $request->sizeId,
	   			'importNum' => $request->importNum,
	   			'importPrice' => $request->importPrice,
	   			'exportPrice' => $request->exportPrice,
	    		'status' => $request->status
	    	];
	    	Stocks::whereId($request->id)->update($form_data);
	    	return response()->json(['success' => 'Sửa thành công!']);
	    }

	    public function edit($id){
			$model = Stocks::join('product','product.id','=','stocks.productId')->select('product.name as name','stocks.*')->where('stocks.id',$id)->first();
			return response()->json(['data' => $model]);
	    }

	    public function destroy($id){
	    	$stock = Stocks::where('id',$id)->first();
	    	if ($stock){
	    		$stock->delete();
	    		return response()->json(['success' => 'Xóa thành công!']);
	    	}else{
	    		return response()->json(['errors' => 'Không thể xóa!']);
	    	}
	    }

	}
 ?>