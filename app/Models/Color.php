<?php 
	
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;

	/**
	 * summary
	 */
	class Color extends Model
	{
	    protected $table = 'color';

	    protected $fillable = ['name','status'];

	    public function stock(){
	    	return $this->hasMany(Stocks::class,'colorId','id');
	    }
	}
 
 ?>