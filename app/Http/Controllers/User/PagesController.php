<?php 
	
	namespace App\Http\Controllers\User;
	use Carbon\Carbon;
	

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\Category;
	use App\Models\WishList;
	use App\Models\Customer;
	use App\Models\Stocks;
	use App\Models\CatalogBlog;
	use App\Models\Blog;
	use App\Models\Comment;
	use App\Models\Review;
	use Illuminate\Support\Facades\DB;
	use App\Http\Controllers\Controller;
	use RealRashid\SweetAlert\Facades\Alert;
	use Illuminate\Support\Facades\Session;
	use Validator;
	use Mail;

	/**
	 * summary
	 */
	class PagesController extends Controller
	{
	    /**
	     * summary
	     */
	    public function getAllProducts(){
	    	$avgs = [];
			$products = Product::join('stocks','product.id','=','stocks.productId')->select('product.*','stocks.exportPrice as price')->where('product.status',1)->groupBy('product.id')->paginate(9);
			foreach ($products as $pro) {
				$avgRating = Review::where('productId',$pro->id)->avg('rating');
				$ceilAvg = ceil($avgRating);
	    		$avgs[] =  [
	    			'id' => $pro->id,
	    			'avg' => $ceilAvg
	    		];
			}
			$popularPros = Product::join('stocks','product.id','=','stocks.productId')->select('product.*','stocks.exportPrice as price')->where('product.status',1)->orderBy('product.priority','DESC')->groupBy('product.id')->limit(4)->get();
			return view('user/shop-grid-left-sidebar',compact('products','popularPros','avgs'));
		}

		public function loginPage(){
	        return view('user/login-register');
		}
		public function contactPage(){
	        return view('user/contact-us');
		}

		public function blogPage(){
			$blogs = Blog::where('status',1)->orderBy('created_at','DESC')->paginate(9);
			$recentBlogs = Blog::where('status',1)->orderBy('created_at','DESC')->limit(3)->get();
	        return view('user/all-blog',compact('blogs','recentBlogs'));
		}

		public function aboutPage(){
			$randPro = Product::join('stocks','product.id','=','stocks.productId')->select('product.*','stocks.exportPrice as price')->where('product.status',1)->groupBy('product.id')->get()->random(12);
			$mytime = Carbon::create(2020, 02, 01, 00, 00, 00);
			foreach ($randPro as $pro) {
				$avgRating = Review::where('productId',$pro->id)->avg('rating');
				$ceilAvg = ceil($avgRating);
	    		$avgs[] =  [
	    			'id' => $pro->id,
	    			'avg' => $ceilAvg
	    		];
			}
	        return view('user/about-us',compact('randPro','avgs','mytime'));
		}

		public function faq(){
			 return view('user/faq');
		}

		public function compare(){
			
			return view('user/compare');
		}

		public function sendContact(Request $request){
			Mail::send('email.contact',[
				'name' => $request->name,
				'phoneNumber' => $request->phoneNumber,
				'conSubject' => $request->conSubject,
				'conMessage' => $request->conMessage
			],function($mail) use($request){
				$mail->to('ngmhhai.x@gmail.com');
				$mail->from($request->email);
				$mail->subject('Test mail');
			});
		}
		
		public function addCompare(Request $request){
			$productId = $request->productId;
			$compare = session('compare') ? session('compare') : [];
			$listColor = [];
			$listSize = [];
			$product = Product::where('id',$productId)->first();
			$stocks = Stocks::where('productId',$productId)->get();
			foreach ($stocks as $stock) {
				if ($stock->colorId == null) {
					$color = 'Không có màu';
				}else{
					$listColor[] = $stock->color->name;
				}
				if ($stock->sizeId == null) {
					$sizes = 'Không có size';
				}else{
					$listSize[] = $stock->size->name;
				}
			}
			$data = [
				'id' => $product->id,
				'name' => $product->name,
				'category' => $product->cat->name,
				'discount' => $product->discount,
				'description' => $product->description,
				'image' => $product->image,
				'slug' => $product->slug,
				'status' => $product->status,
				'color' => $listColor,
				'size' => $listSize
			];
			if (isset($compare[$request->productId])) {
				return response()->json(['error' => 'Sản phẩm đã so sánh']);
			}
			if (count($compare) > 2) {
				return response()->json(['error1' => 'Chỉ so sánh được tối đa 3 sản phẩm']);
			}
			$compare[$request->productId] = $data;
			session(['compare'=>$compare]);
			return response()->json(['success'=> 'So sánh thành công']);
		}

		public function delCompare(Request $request){
	    	// dd($request->all());
	    	$sess = session('compare') ? session('compare') : [];
	    	unset($sess[$request->id]);
	    	session(['compare'=>$sess]);
	    	// return redirect()->back();
	    	return response()->json(['success'=>'Xóa thành công!']);
	    }

		// public function add_compare(Request $request){
  //           $items = session('pro') ? session('pro'):[];
  //           $listColor = [];
  //           $listSize = [];
  //           $pro = Product::where('id',$request->productId)->first();
  //           // $listReview = Review::where('productId',$request->productId)->get();
  //           // $t =0;
  //           // foreach ($listReview as $rev) {
  //           //     $t += $rev->rating;
  //           // }
  //           // if(count($listReview)==0){
  //           //     $total = 0;
  //           // }else{
  //           //     $total = (int)($t / count($listReview));
  //           // }
  //           $listStock = Stocks::where('productId',$request->productId)->get();
  //           foreach ($listStock as $stock) {
  //               if($stock->colorId ==null){
  //                   $color = 'Không';
  //               }else{
  //                   $listColor[]=$stock->color->name;
  //               }
  //               $listSize[] = $stock->size->name;
  //           }
  //           $data = [
  //               'id' => $pro->id,
  //               'name' => $pro->name,
  //               'category' => $pro->cat->name,
  //               'image' => $pro->image,
  //               'description' => $pro->description,
  //               'color' => $listColor,
  //               'size' => $listSize
  //               // 'review' => $total
  //           ];
  //           if(isset($items[$request->productId])){
  //               return response()->json(['error'=>'Sản phẩm đã có trong so sánh']);
  //           }
  //           if(count($items)>2){
  //               return response()->json(['error'=>'Danh sách so sánh đã đầy']);
  //           }
  //           $items[$request->productId] = $data;
  //           session(['pro'=>$items]);
  //           return response()->json(['success'=>'Thêm vào so sánh thành công']);
  //       }

		public function search(Request $request){
	   	if ($request->ajax()) {
	   		$output = '';
	   		$listPro = Product::where('name','like','%'.$request->search.'%')
	   							->orderBy('created_at','DESC')
	   							->get();
	   		if ($listPro) {
	   			$public = url('public');
	   			$img = $public.'/user/img/product/';
	   			foreach ($listPro as $pro) {
	   			$route = route('product_detail',['slug'=>$pro->slug]);
	   				$output .='<div class="media">
								<a class="pull-left" href="'.$route.'">
									<img class="media-object" width="100px"  src="'.$img.$pro->image.'" alt="Image">
								</a>
								<div class="media-body">
									<a href="'.$route.'"><p style="font-size: 20px;color: white">'.$pro->name.'</p></a>
								</div>
							</div>';
	   			}
	   		}
	   		return Response($output);
	   	}
	   }

	   public function search_blog(Request $request){
	   	if ($request->ajax()) {
	   		$output = '';
	   		$listBlog = Blog::where('title','like','%'.$request->search_blog.'%')
	   						->orWhere('notes','like','%'.$request->search_blog.'%')
	   						->orWhere('content','like','%'.$request->search_blog.'%')
	   							->orderBy('created_at','DESC')
	   							->get();
	   		if ($listBlog) {
	   			$public = url('public');
	   			$img = $public.'/user/img/blog/';
	   			foreach ($listBlog as $blog) {
	   			$route = route('blog_detail',['title'=>$blog->title,'id' => $blog->id]);
	   				$output .='<div class="media">
								<a class="pull-left" href="'.$route.'">
									<img class="media-object" width="100px"  src="'.$img.$blog->imageSrc.'" alt="Image">
								</a>
								<div class="media-body">
									<a href="'.$route.'"><p style="font-size: 20px;color: white">'.$blog->title.'</p></a>
								</div>
							</div>';
	   			}
	   		}
	   		return Response($output);
	   	}
	   }


	   public function search_result_blog(Request $request){
	   		if ($request->search_blog) {
		   			$listBlog = Blog::where('title','like','%'.$request->search_blog.'%')
	   						->orWhere('notes','like','%'.$request->search_blog.'%')
	   						->orWhere('content','like','%'.$request->search_blog.'%')->where('status',1)->paginate(9);
		   		return view('user/search-result-blog',compact('listBlog'));
	   		}
	   		else{
	   			return view('user/404');
	   		}
	   	}


	   	public function search_result(Request $request){
	   		if ($request->search) {
		   			$listPro = Product::join('stocks','product.id','=','stocks.productId')->select('product.*','stocks.exportPrice as price')->where('porduct.name','like','%'.$request->search.'%')->where('product.status',1)->orderBy('created_at','DESC')->groupBy('product.id')->paginate(9);
		   		$popularPros = Product::join('stocks','product.id','=','stocks.productId')->select('product.*','stocks.exportPrice as price')->where('product.status',1)->orderBy('product.priority','DESC')->groupBy('product.id')->paginate(9);
		   		return view('user/search-result',compact('listPro','popularPros'));
	   		}
	   		else{
	   			$popularPros = Product::limit(4)->where('status',1)->orderBy('priority','DESC')->get();
	   			return view('user/404',compact('popularPros'));
	   		}
	   	}

	   	public function wishList(Request $request){
	   		$wishList = WishList::join('product','product.id','=','wishlist.productId')->select('wishlist.*','product.name as proName','product.image as proImage','product.price as proPrice','product.discount as proDiscount','product.status as proStatus')->where('customerId',$request->customerId)->get();
	   		return view('user/wishlist',compact('wishList'));
	   		// dd($wishList);die;
	   	}

	   	public function addWishList(Request $request){
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

	   	public function blogDetail($title,$id){
	   		$blog = Blog::where('title','like',$title)->first();
	   		$comments = Comment::join('customer','customer.id','=','comment.customerId')->select('customer.name as name','customer.avatar as avatar','comment.*')->where('comment.blogId',$id)->where('comment.status',1)->get();
	   		$recentBlogs = Blog::where('status',1)->orderBy('created_at','DESC')->limit(3)->get();
	   		return view('user/blog-details',compact('blog','comments','recentBlogs'));
	   	}

	   	public function postComment(Request $request){
	   		$rules = [
	   			'content' => 'required|max:250',
	   		];
	   		$messages = [
	   			'content.required' => 'Bình luận không được để trống',
	   			'content.max' => 'Bình luận không được quá 250 kí tự',
	   		];
	   		$errors = Validator::make($request->all(),$rules,$messages);
	   		if ($errors->fails()) {
	   			return response()->json(['errors' => $errors->errors()->all()]);
	   		}
	   		else{
	   			$form_data = [
	   				'content' => $request->content,
	   				'customerId' => $request->customerId,
	   				'blogId' => $request->blogId,
	   				'parentId' => $request->parentId
	   			];
	   			Comment::create($form_data);
	   			return response()->json(['success' => 'Bình luận thành công!']);
	   		}
	   	}

	   	public function getBlogByCatalog($slug){
	    	$blogs = Blog::join('catalogBlog','catalogBlog.id','=','blog.catalogBlogId')->select('blog.id as id','blog.title as title','blog.notes as notes','blog.created_at as created_at','blog.imageSrc as imageSrc')->where('catalogBlog.slug','like',$slug)->where('blog.status',1)->paginate(9);
	    	$catalogBlogByName = CatalogBlog::where('slug','like',$slug)->first();
	    	$recentBlogs = Blog::where('status',1)->orderBy('created_at','DESC')->limit(3)->get();
	        return view('user/all-blog',compact('blogs','recentBlogs','catalogBlogByName'));

	    }

}

	
 ?>