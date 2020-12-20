<?php 
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;

	/**
	 * summary
	 */
	class CatalogBlog extends Model
	{
	    protected $table = 'catalogblog';

	    protected $fillable = ['id','name','slug','status'];

	    public function blog(){
	    	return $this->hasMany(Blog::class,'id','catalogBlogId');
	    }

	}
 ?>