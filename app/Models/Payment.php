<?php 
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;

	/**
	 * summary
	 */
	class Payment extends Model
	{
	    protected $table = 'payment';

	    protected $fillable = ['name','status'];
	}
 ?>