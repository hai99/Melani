<?php 
	
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;

	/**
	 * summary
	 */
	class Customer extends Model
	{
	    protected $table = 'customer';

	    protected $fillable = ['name','email','pass','phoneNumber','address','avatar','status'];

	    public function review(){
	    	return $this->hasMany(Review::class,'id','customerId');
	    }

	    public function comment(){
	    	return $this->hasMany(Comment::class,'id','customerId');
	    }

	    public function order(){
	    	return $this->hasMany(Orders::class,'id','customerId');
	    }
	}
 
 ?>