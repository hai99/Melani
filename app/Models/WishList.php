<?php 
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;

	/**
	 * summary
	 */
	class WishList extends Model
	{
	    protected $table = 'wishlist';

	    protected $fillable = ['productId','customerId','status'];

	    public function customer(){
	    	return $this->hasOne(Customer::class,'id','customerId');
	    }

	    public function pro(){
	    	return $this->hasMany(Product::class,'id','productId');
	    }

	    
	}
 ?>