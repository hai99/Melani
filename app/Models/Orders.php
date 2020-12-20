<?php 
	
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;

	/**
	 * summary
	 */
	class Orders extends Model
	{
	    protected $table = 'orders';

	    protected $fillable = ['customerId','cusName','cusEmail','phoneNumber','address','orderNote','paymentId','deliveryId','totalAmount','status'];

	    public function ordet(){
	    	return $this->hasMany(Orderdetail::class,'orderId','id');
	    }

		public function payment(){
	    	return $this->hasOne(Payment::class,'id','paymentId');
	    }

	    public function delivery(){
	    	return $this->hasOne(Delivery::class,'id','deliveryId');
	    }

	    public function cus(){
	    	return $this->hasOne(Customer::class,'id','customerId');
	    }
	}
 
 ?>