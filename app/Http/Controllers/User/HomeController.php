<?php 
	namespace App\Http\Controllers\User;

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\Category;
	use App\Models\CatalogBlog;
	use App\Models\Blog;
	use App\Models\Review;
	use App\Models\Customer;
	use Carbon\Carbon;
	use App\Http\Controllers\Controller;
	use Validator;
	use Illuminate\Support\Collection;
	use Mail;


	/**
	 * summary
	 */
	class HomeController extends Controller
	{
	    /**
	     * summary
	     */

	    public function index()
	    {
	    	$avgs_fp = [];
	    	$avgs_sp = [];
	    	$avgs_bsp = [];
			$featuredPros = Product::join('stocks','product.id','=','stocks.productId')->select('product.*','stocks.exportPrice as price')->where('product.status',1)->orderBy('product.proView','DESC')->orderBy('product.created_at','DESC')->groupBy('product.id')->limit(12)->get();
			foreach ($featuredPros as $pro) {
				$avgRating = Review::where('productId',$pro->id)->avg('rating');
				$ceilAvg = ceil($avgRating);
	    		$avgs_fp[] =  [
	    			'id' => $pro->id,
	    			'avg' => $ceilAvg
	    		];
			}
	    	$salePros = Product::join('stocks','product.id','=','stocks.productId')->select('product.*','stocks.exportPrice as price')->where('product.status',1)->orderBy('product.discount','DESC')->groupBy('product.id')->limit(6)->get();
	    	foreach ($salePros as $pro) {
				$avgRating = Review::where('productId',$pro->id)->avg('rating');
				$ceilAvg = ceil($avgRating);
	    		$avgs_sp[] =  [
	    			'id' => $pro->id,
	    			'avg' => $ceilAvg
	    		];
			}
			$bestSellerPros = Product::join('stocks','product.id','=','stocks.productId')->select('product.*','stocks.exportPrice as price')->where('product.status',1)->orderBy('product.priority','DESC')->groupBy('product.id')->limit(6)->get();
			foreach ($bestSellerPros as $pro) {
				$avgRating = Review::where('productId',$pro->id)->avg('rating');
				$ceilAvg = ceil($avgRating);
	    		$avgs_bsp[] =  [
	    			'id' => $pro->id,
	    			'avg' => $ceilAvg
	    		];
			}
			$categories = Category::where('status',1)->get();
			$catalogBlogs = CatalogBlog::where('status',1)->get();
			$mytime = Carbon::create(2020, 02, 01, 00, 00, 00);
			$blogs = Blog::where('status',1)->orderBy('created_at','DESC')->limit(6)->get();
	        return view('user/index',compact('featuredPros','salePros','bestSellerPros','categories','catalogBlogs','mytime','avgs_fp','avgs_sp','avgs_bsp','blogs'));
		}

		public function quick_view(Request $request){
			if ($request->ajax()) {
				$data = Product::where('id',$request->id)->first();
				return response()->json(['data' => $data]);
			}
		}
		
		public function forget_password(Request $request){
			$emails = collect(Customer::pluck('email'));
			$rules = array(
	    		'email' => 'required|email'
	    	);
	    	$messages = array(
	    		'email.required' => 'Email không được để trống.',
	    		'email.email' => 'Email không đúng định dạng.'
 	    	);
 	    	$errors = Validator::make($request->all(),$rules,$messages);
 	    	if ($errors->fails()) {
 	    		return response()->json(['errors' => $errors->errors()->all()]);
 	    	}
 	    	if ($emails->contains($request->email)) {
 	    		$cus = Customer::where('email','like',$request->email)->first();
 	    		Mail::send('email.forget-password',[
		        'email' => $request->email,
		        'name' => $cus->name,
		        'password' => $cus->pass,
		        ],function($mail) use($request){
		            $mail->to($request->email);
		            $mail->from('melanibeautyshop@gmail.com');
		            $mail->subject('Lấy lại mật khẩu');
		        });
		        return response()->json(['success' => '1 thư đã được gửi vào email của bạn.Vui lòng kiểm tra.']);
 	    	}else{
 	    		return response()->json(['error' => 'Email chưa đăng ký!']);
 	    	}
		}

		
	}
 ?>