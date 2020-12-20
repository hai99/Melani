<?php 
	
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;

	/**
	 * summary
	 */
	class Sizes extends Model
	{
	    protected $table = 'sizes';

	    protected $fillable = ['name','status'];

	    public function stock(){
	    	return $this->hasMany(Stocks::class,'sizeId','id');
	    }
	}
 
 ?>