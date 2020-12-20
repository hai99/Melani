<?php 
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;

	/**
	 * summary
	 */
	class Product extends Model
	{
	    /**
	     * summary
	     */
	    protected $table = 'product';

	    protected $fillable = ['id','name','catalogId','slug','proView','image','description','discount','status'];

	    public function cat(){
	    	return $this->hasOne(Category::class,'id','catalogId');
	    }

	    public function stock(){
	    	return $this->hasMany(Stocks::class,'productId','id');
	    }

	    public function review(){
	    	return $this->hasMany(Review::class,'id','productId');
	    }

	    public function wishlist(){
	    	return $this->hasOne(WishList::class,'productId','id');
	    }

	    public function getChidrensCatById($id){
	    	$allcats = Category::select('id')->where('parentId',$id)->get()->toArray();
	    	$mang_cats = [];
	    	array_push($mang_cats, $id);
	    	foreach ($allcats as $key => $cat) {

	    		array_push($mang_cats, $cat['id']);
				$allcats1 = Category::select('id')->where('parentId',$cat['id'])->get()->toArray();			
	    		foreach ($allcats1 as $c1) {
	    			array_push($mang_cats, $c1['id']);
	    		}
	    	}
			return $mang_cats;
	    }

	  //   public function getChidrensCatById($allcats, $parentId = 0 ){	    
	  //   	$ids = '';
	  //   	foreach ($allcats as $key => $cat) {
	  //   		if ($cat['id'] = $parentId) {
			// 		$ids.= $cat['id'].',';
	  //   			unset($allcats[$key]);	
	  //   		}
		
	  //   	}

	  //   	dd($ids);
			// return $ids;
	  //   }

	  //    public function getCats($id){
	  //    	$allcats = Category::select('id','parentId')->get()->toArray();
	  //    	// dd($allcats);
	  //    	$resaults = $this->getChidrensCatById($allcats,$id);
	  //    }
	}
 ?>