<?php 
	
	namespace App\Http\Controllers\User;

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\Category;
	use App\Models\WishList;
	use App\Http\Controllers\Controller;
	use RealRashid\SweetAlert\Facades\Alert;

	/**
	 * summary
	 */
	class WishlistController extends Controller
	{
	    
	   	public function wishList(Request $request){
	   		$wishList = WishList::join('product','product.id','=','wishlist.productId')->join('stocks','product.id','=','stocks.productId')->select('wishlist.*','product.name as proName','product.image as proImage','product.status as proStatus','product.slug as slug','stocks.exportPrice as proPrice','product.discount as proDiscount')->where('wishlist.customerId',$request->customerId)->where('wishlist.status',1)->groupBy('product.id')->get();
	   		return view('user/wishlist',compact('wishList'));
	   		dd($wishList);die;
	   	}
	   	public function store(Request $request){
	   		if ($request->customerId == '') {
	   			return response()->json(['errors' => 'Bạn chưa đăng nhập!']);
	   		}
	   		else{
	   			$wish = WishList::where('customerId',$request->customerId)->where('productId',$request->productId)->first();
	   			if ($wish) {
	   				return response()->json(['error' => 'Sản phẩm đã có trong danh sách ưa thích']);
	   			}else{
	   				$data = [
	   					'productId' => $request->productId,
	   					'customerId' => $request->customerId
	   				];
	   				WishList::create($data);
	   				return response()->json(['success' => 'Đã thêm sản phẩm vào danh sách ưa thích!']);
	   			}
	   		}
	   	}

	   	public function destroy(Request $request){
	   		$wish = WishList::find($request->id);
	   		if ($wish) {
	   			$wish->delete();
	   			return response(['success' => 'Xóa thành công!']);
	   		}else{
	   			return response(['errors' => 'Không thể xóa. Vui lòng thử lại!']);
	   		}
	   	}

	   	

}

	
 ?>