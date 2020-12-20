<?php 
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;

	/**
	 * summary
	 */
	class Orderdetail extends Model
	{
	    protected $table = 'orderdetail';

	    protected $fillable = ['orderId','stockId','quantity','price','status'];

	    public function order(){
	    	return $this->hasOne(Orders::class,'id','orderId');
	    }

	    public function stock(){
	    	return $this->hasOne(Stocks::class,'id','stockId');
	    }
	}
 ?>