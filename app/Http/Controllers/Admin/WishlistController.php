<?php 
	namespace App\Http\Controllers\Admin;

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\Customer;
	use App\Models\Category;
	use App\Models\Color;
	use App\Models\Review;
	use App\Models\WishList;
	use App\Models\Sizes;
	use App\Models\Stocks;
	use App\Http\Controllers\Controller;
	use Validator;
	use DataTables;

	/**
	 * summary
	 */
	class WishlistController extends Controller
	{
	    /**
	     * summary
	     */
	    function __construct()
        {
             $this->middleware('permission:wishlist-list|wishlist-create|wishlist-edit|wishlist-delete', ['only' => ['index','store']]);
             $this->middleware('permission:wishlist-create', ['only' => ['create','store']]);
             $this->middleware('permission:wishlist-edit', ['only' => ['edit','update']]);
             $this->middleware('permission:wishlist-delete', ['only' => ['destroy']]);
        }
	    
	    public function index(){
	    	$listWish = WishList::join('product','product.id','=','wishlist.productId')->join('customer','customer.id','=','wishlist.customerId')->select('product.name as proName','product.id as proId','customer.name as cusName','wishlist.*')->get();
	        return view('admin/wishlist/index',compact('listWish'));
	    }


	    public function destroy($id){
	    	$wish = WishList::find($id);
	    	$wish->delete();
	    	return response()->json(['success' => 'Xóa thành công!']);
	    }


	    public function update(Request $request,$id){
	    	$request->offsetUnset('_token');
            $request->offsetUnset('_method');
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
	    	WishList::whereId($request->id)->update($form_data);
	    	return response()->json(['success' => 'Sửa thành công!']);
	    }

	    public function edit($id){
    		$model = Review::join('product','product.id','=','review.productId')->join('customer','customer.id','=','review.customerId')->select('product.name as proName','product.id as proId','customer.name as cusName','review.*')->where('review.id',$id)->first();
    		return response()->json(['data' => $model]);
	    }

	}
 ?>