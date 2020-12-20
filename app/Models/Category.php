<?php 
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;

	/**
	 * summary
	 */
	class Category extends Model
	{
	    protected $table = 'category';

	    protected $fillable = ['id','name','parentId','status','slug'];

	    public function product(){
	    	return $this->hasMany(Product::class,'id','catalogId');
	    }

	    public function childs(){
	    	return $this->hasMany(Category::class,'parentId');
	    }
	}
 ?>