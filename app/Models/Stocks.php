<?php 
	
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;

	/**
	 * summary
	 */
	class Stocks extends Model
	{
	    protected $table = 'stocks';

	    protected $fillable = ['productId','sizeId','colorId','importNum','importPrice','exportPrice','status'];

	    public function pro(){
	    	return $this->hasOne(Product::class,'id','productId');
	    }

		public function color(){
	    	return $this->hasOne(Color::class,'id','colorId');
	    }

	    public function size(){
	    	return $this->hasOne(Sizes::class,'id','sizeId');
	    }

	    public function ordet(){
	    	return $this->hasMany(Orderdetail::class,'stockId','id');
	    }    
	}
 
 ?>