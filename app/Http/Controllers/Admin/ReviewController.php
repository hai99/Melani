<?php 
	namespace App\Http\Controllers\Admin;

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\Customer;
	use App\Models\Category;
	use App\Models\Color;
	use App\Models\Review;
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
	class ReviewController extends Controller
	{
	    /**
	     * summary
	     */
	    function __construct()
        {
             $this->middleware('permission:review-list|review-create|review-edit|review-delete', ['only' => ['index','store']]);
             $this->middleware('permission:review-create', ['only' => ['create','store']]);
             $this->middleware('permission:review-edit', ['only' => ['edit','update']]);
             $this->middleware('permission:review-delete', ['only' => ['destroy']]);
        }
	    
	    public function index(){
	    	$listRev = Review::join('product','product.id','=','review.productId')->join('customer','customer.id','=','review.customerId')->select('product.name as proName','product.id as proId','customer.name as cusName','review.*')->get();
	        return view('admin/review/index',compact('listRev'));
	    }


	    public function destroy($id){
	    	$rev = Review::find($id);
	    	$rev->delete();
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
	    	Review::whereId($request->id)->update($form_data);
	    	return response()->json(['success' => 'Sửa thành công!']);
	    }

	    public function edit($id){
    		$model = Review::join('product','product.id','=','review.productId')->join('customer','customer.id','=','review.customerId')->select('product.name as proName','product.id as proId','customer.name as cusName','review.*')->where('review.id',$id)->first();
    		return response()->json(['data' => $model]);
	    }

	}
 ?>