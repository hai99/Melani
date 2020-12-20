<?php 
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;

	/**
	 * summary
	 */
	class Delivery extends Model
	{
	    protected $table = 'delivery';

	    protected $fillable = ['name','status'];
	}
 ?>