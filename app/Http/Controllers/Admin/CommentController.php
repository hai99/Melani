<?php 
	namespace App\Http\Controllers\Admin;

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\Category;
	use App\Models\Comment;
	use App\Models\Blog;
	use App\Models\Customer;
	use App\Models\Color;
	use App\Models\Sizes;
	use App\Models\Stocks;
	use App\Http\Controllers\Controller;
	use Validator;
	use DataTables;

	/**
	 * summary
	 */
	class CommentController extends Controller
	{
	    /**
	     * summary
	     */
	    function __construct()
        {
             $this->middleware('permission:comment-list|comment-create|comment-edit|comment-delete', ['only' => ['index','store']]);
             $this->middleware('permission:comment-create', ['only' => ['create','store']]);
             $this->middleware('permission:comment-edit', ['only' => ['edit','update']]);
             $this->middleware('permission:comment-delete', ['only' => ['destroy']]);
        }
	    
	    public function index(){
	    	$listComment = Comment::join('customer','customer.id','=','comment.customerId')->join('blog','blog.id','=','comment.blogId')->select('customer.name as name','blog.title as blogTitle','comment.*')->get();
	        return view('admin/comment/index',compact('listComment'));
	    }

	    public function create(){
	    	$listCat = Category::get(); 
	    	return view('admin/category/add',compact('listCat'));
	    }

	    
	    public function destroy($id){
	    	$comm = Comment::where('id',$id)->first();
	    	$comm_child = Comment::where('parentId',$comm['id'])->get();
	    	if (count($comm_child) > 0) {
	    		return response()->json(['errors' => 'Không thể xóa!']);
	    	}else{
	    		$comm->delete();
	    		return response()->json(['success' => 'Xóa thành công!']);
	    	}
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
	    	Comment::whereId($request->id)->update($form_data);
	    	return response()->json(['success' => 'Sửa thành công!']);
	    }

	    public function edit($id){
    		$model = Comment::join('customer','customer.id','=','comment.customerId')->join('blog','blog.id','=','comment.blogId')->select('customer.name as name','blog.title as blogTitle','comment.*')->where('comment.id',$id)->first();
    		return response()->json(['data' => $model]);
	    }

	}
 ?>