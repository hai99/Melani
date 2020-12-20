<?php 
	namespace App\Http\Controllers\User;

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\Category;
	use App\Models\Stocks;
	use App\Models\Color;
	use App\Models\Sizes;
	use App\Models\Review;
	use Carbon\Carbon;
	use App\Http\Controllers\Controller;
	use Validator;

	/**
	 * summary
	 */
	class ProductController extends Controller
	{
	    /**
	     * summary
	     */

	   

	    public function sortBy(Request $request){
	    	$avgs_pp = [];
	    	$avgs = [];
	    	if (!empty($request)) {
	    		$field = !empty($request['field']) ? $request['field'] : '';
	    		$attr = !empty($request['attr']) ? $request['attr'] : '';
	    		$products = Product::join('stocks','product.id','=','stocks.productId')->select('product.*','stocks.exportPrice as price')->where('product.status',1)->orderBy($field,$attr)->groupBy('product.id')->paginate(9);
	    		foreach ($products as $pro) {
				$avgRating = Review::where('productId',$pro->id)->avg('rating');
				$ceilAvg = ceil($avgRating);
	    		$avgs[] =  [
	    			'id' => $pro->id,
	    			'avg' => $ceilAvg
	    		];
				}
	    		$categories = Category::where('status',1)->get();
	    		$popularPros = Product::join('stocks','product.id','=','stocks.productId')->select('product.*','stocks.exportPrice as price')->where('product.status',1)->orderBy('product.priority','DESC')->groupBy('product.id')->limit(4)->get();
	    		foreach ($popularPros as $pro) {
				$avgRating = Review::where('productId',$pro->id)->avg('rating');
				$ceilAvg = ceil($avgRating);
	    		$avgs_rp[] =  [
	    			'id' => $pro->id,
	    			'avg' => $ceilAvg
	    		];
				}
	    		return view('user/shop-grid-left-sidebar',compact('products','categories','popularPros','avgs_pp','avgs'));
	    	}else{
	    		$products = Product::join('stocks','product.id','=','stocks.productId')->select('product.*','stocks.exportPrice as price')->where('product.status',1)->groupBy('product.id')->paginate(9);
	    		foreach ($products as $pro) {
				$avgRating = Review::where('productId',$pro->id)->avg('rating');
				$ceilAvg = ceil($avgRating);
	    		$avgs[] =  [
	    			'id' => $pro->id,
	    			'avg' => $ceilAvg
	    		];
			}
	    		$categories = Category::where('status',1)->get();
	    		$popularPros = Product::join('stocks','product.id','=','stocks.productId')->select('product.*','stocks.exportPrice as price')->where('product.status',1)->orderBy('product.priority','DESC')->groupBy('product.id')->limit(4)->get();
	    		foreach ($popularPros as $pro) {
				$avgRating = Review::where('productId',$pro->id)->avg('rating');
				$ceilAvg = ceil($avgRating);
	    		$avgs_rp[] =  [
	    			'id' => $pro->id,
	    			'avg' => $ceilAvg
	    		];
				}
	    		return view('user/shop-grid-left-sidebar',compact('products','categories','popularPros','avgs_pp','avgs'));
	    	}
	    }

	    public function productDetail($slug){
	    	$avgs_fp = [];
	    	$avgs_rp = [];
	    	$featuredPros = Product::join('stocks','product.id','=','stocks.productId')->select('product.*','stocks.exportPrice as price')->where('product.status',1)->orderBy('product.proView','DESC')->orderBy('product.created_at','DESC')->groupBy('product.id')->limit(5)->get();
	    	foreach ($featuredPros as $pro) {
				$avgRating = Review::where('productId',$pro->id)->avg('rating');
				$ceilAvg = ceil($avgRating);
	    		$avgs_fp[] =  [
	    			'id' => $pro->id,
	    			'avg' => $ceilAvg
	    		];
			}

    		$relatedPros = Product::join('stocks','product.id','=','stocks.productId')->select('product.*','stocks.exportPrice as price')->where('product.status',1)->groupBy('product.id')->get()->random(12);
    		 foreach ($relatedPros as $pro) {
				$avgRating = Review::where('productId',$pro->id)->avg('rating');
				$ceilAvg = ceil($avgRating);
	    		$avgs_rp[] =  [
	    			'id' => $pro->id,
	    			'avg' => $ceilAvg
	    		];
			}

			$mytime = Carbon::create(2020, 02, 01, 00, 00, 00);

	    	$categories = Category::where('status',1)->get();
	    	$catParent = Category::where('parentId',0)
	    				 ->get();
	    	$pro = Product::join('stocks','product.id','=','stocks.productId')->select('product.*','stocks.exportPrice as price')->where('product.status',1)->where('slug',$slug)->groupBy('product.id')->first();
    		$reviews = Review::join('product','review.productId','=','product.id')->join('customer','review.customerId','=','customer.id')->select('review.content as content','review.created_at as created','review.rating as rating','customer.name as name')->where('review.status',1)->where('review.productId',$pro->id)->get();		
    		$avgRating = Review::where('productId',$pro->id)->avg('rating');
    		$floorRating = ceil($avgRating);
	    	$listSizes = [];
	    	$listColor = [];
	    	if (!empty($pro)) {
	    		$listStockSizes = Stocks::where('productId',$pro->id)->distinct('sizeId')->get('sizeId');
	    		$listStockColor = Stocks::where('productId',$pro->id)->distinct('colorId')->get('colorId');
	    		for ($i = 0; $i < $listStockSizes->count(); $i++) {
	    			$sizes = Sizes::where('id',$listStockSizes[$i]->sizeId)->first();
	    			$listSizes[] = $sizes; 
	    		}
	    		for ($i = 0; $i < $listStockColor->count() ; $i++) {
	    			$color = Color::where('id',$listStockColor[$i]->colorId)->first();
	    			$listColor[] = $color;
	    		}
	    		return view('user/product-details-variable',compact('pro','featuredPros','catParent','relatedPros','categories','listSizes','listColor','reviews','floorRating','avgs_fp','avgs_rp','mytime'));
	    	}else{
	    		return view('user/index');
	    	}
	    }

	    public function getProByPrice($price1,$price2){
	    	$avgs = [];
	    	if(isset($price1) && isset($price2)){
	    		// SELECT * FROM `product` WHERE price>=50000 and price<=100000 order BY price ASC
	    		$products = Product::join('stocks','product.id','=','stocks.productId')->select('product.*','stocks.exportPrice as price')->where('product.status',1)->where('stocks.exportPrice','>=',$price1)->where('stocks.exportPrice','<=',$price2)->groupBy('product.id')->paginate(9);
	    		foreach ($products as $pro) {
				$avgRating = Review::where('productId',$pro->id)->avg('rating');
				$ceilAvg = ceil($avgRating);
	    		$avgs[] =  [
	    			'id' => $pro->id,
	    			'avg' => $ceilAvg
	    		];
			}
	    		$categories = Category::where('status',1)->get();
	    		$popularPros = Product::join('stocks','product.id','=','stocks.productId')->select('product.*','stocks.exportPrice as price')->where('product.status',1)->orderBy('product.priority','DESC')->groupBy('product.id')->limit(4)->get();
	    		return view('user/shop-grid-left-sidebar',compact('products','categories','popularPros','avgs'));
	    	}else{
	    		$products = $products = Product::join('stocks','product.id','=','stocks.productId')->select('product.*','stocks.exportPrice as price')->where('product.status',1)->groupBy('product.id')->paginate(9);
	    		foreach ($products as $pro) {
				$avgRating = Review::where('productId',$pro->id)->avg('rating');
				$ceilAvg = ceil($avgRating);
	    		$avgs[] =  [
	    			'id' => $pro->id,
	    			'avg' => $ceilAvg
	    		];
			}
	    		$categories = Category::where('status',1)->get();
	    		$popularPros = Product::join('stocks','product.id','=','stocks.productId')->select('product.*','stocks.exportPrice as price')->where('product.status',1)->orderBy('product.priority','DESC')->groupBy('product.id')->limit(4)->get();
	    		return view('user/shop-grid-left-sidebar',compact('products','categories','popularPros','avgs'));
	    	}
	    }

	    public function getProByCategory($slug){
	    	$avgs_pp = [];
	    	$avgs = [];
	    	$pro = new Product;
	    	$catIds = [];
	    	$popularPros = Product::join('stocks','product.id','=','stocks.productId')->select('product.*','stocks.exportPrice as price')->where('product.status',1)->orderBy('product.priority','DESC')->groupBy('product.id')->limit(4)->get();
	    	foreach ($popularPros as $pro) {
				$avgRating = Review::where('productId',$pro->id)->avg('rating');
				$ceilAvg = ceil($avgRating);
	    		$avgs_rp[] =  [
	    			'id' => $pro->id,
	    			'avg' => $ceilAvg
	    		];
			}
	    	$cat = Category::where('slug',$slug)->first();

	    	$catIds = $pro->getChidrensCatById($cat->id);
	    	// $cats  =$pro->getCats($cat->id);
	    	// dd($cats);
	    	// $products = Product::whereIn('catalogId',$catIds)->paginate(9);
	    	$products = Product::join('stocks','product.id','=','stocks.productId')->select('product.*','stocks.exportPrice as price')->whereIn('product.catalogId',$catIds)->groupBy('product.id')->paginate(9);
	    	foreach ($products as $pro) {
				$avgRating = Review::where('productId',$pro->id)->avg('rating');
				$ceilAvg = ceil($avgRating);
	    		$avgs[] =  [
	    			'id' => $pro->id,
	    			'avg' => $ceilAvg
	    		];
			}
	    	// dd($products);
	    	return view('user/shop-grid-left-sidebar',compact('products','cat','popularPros','avgs_pp','avgs'));
	    }

	    


	    public function fetchStock(Request $request){
	    	$exportPrice = '';
	    	$discount = '';
	    	if ($request->colorId == null) {
	    		$stocks = Stocks::where('sizeId',$request->sizeId)->whereNull('colorId')->where('productId',$request->productId)->first();
	    		$dc = Product::select('discount')->where('id',$request->productId)->first();
	    		$exportPrice = $stocks->exportPrice;
	    		$discount = $dc->discount;
	    		$price = $stocks->exportPrice-($stocks->exportPrice*($discount/100));
	    	}else if ($request->sizeId == null){
	    		$stocks = Stocks::where('colorId',$request->colorId)->whereNull('sizeId')->where('productId',$request->productId)->first();
	    		$dc = Product::select('discount')->where('id',$request->productId)->first();
	    		$exportPrice = $stocks->exportPrice;
	    		$discount = $dc->discount;
	    		$price = $stocks->exportPrice-($stocks->exportPrice*($discount/100));
	    	}else{
	    		$stocks = Stocks::where('colorId',$request->colorId)->where('sizeId',$request->sizeId)->where('productId',$request->productId)->first();
	    		if ($stocks == null) {
	    			return response()->json(['error' => 'Hết hàng']);
	    		}else{
		    		$dc = Product::select('discount')->where('id',$request->productId)->first();
		    		$exportPrice = $stocks->exportPrice;
		    		$discount = $dc->discount;
		    		$price = $stocks->exportPrice-($stocks->exportPrice*($discount/100));
	    		}
	    	}
	    	if ($stocks->importNum > 0 ) {
	    		return response()->json(['data' => $stocks,'price' => $price]);
	    	}else{
	    		return response()->json(['error' => 'Hết hàng']);
	    	}
	    }


	    public function postReview(Request $request){
	    	$rules = [
	    		'content' => 'required|between:20,250',
	    		'rating' => 'required',
	    	];
	    	$messages = [
	    		'content.required' => 'Đánh giá không được để trống!',
	    		'content.max' => 'Nội dung đánh giá chỉ được phép chứa từ 20 đến 250 ký tự',
	    		'rating.required' => 'Bạn phải chọn xếp hạng'
	    	];
	    	$errors = Validator::make($request->all(),$rules,$messages);
	    	if ($errors->fails()) {
	    		return response(['errors' => $errors->errors()->all()]);
	    	}
	    	else{
		    	$form_data = [
		    		'productId' => $request->productId,
		    		'customerId' => $request->customerId,
		    		'rating' => $request->rating,
		    		'content' => $request->content
		    	];
		    	Review::create($form_data);
		    	return response(['success' => 'Đánh giá thành công']);

	    	}
	    }


	}
	
 ?>