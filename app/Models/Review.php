<?php 
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;

	/**
	 * summary
	 */
	class Review extends Model
	{
	    protected $table = 'review';

	    protected $fillable = ['productId','customerId','rating','content','status'];

	    public function product(){
	    	return $this->hasOne(Product::class,'id','productId');
	    }

	    public function customer(){
	    	return $this->hasOne(Customer::class,'id','customerId');
	    }
	}
 ?>