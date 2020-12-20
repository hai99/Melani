<?php 
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;

	/**
	 * summary
	 */
	class Banner extends Model
	{
	    /**
	     * summary
	     */
	    protected $table = 'banner';

	    protected $fillable = ['id','image','title','content','type','status'];
	}
 ?>