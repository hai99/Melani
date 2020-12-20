<?php 
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;

	/**
	 * summary
	 */
	class Blog extends Model
	{
	    /**
	     * summary
	     */
	    protected $table = 'blog';

	    protected $fillable = ['id','catalogBlogId','title','notes','content','imageSrc','status'];

	    public function catalogBlog(){
	    	return $this->hasOne(CatalogBlog::class,'id','catalogBlogId');
	    }
	}
 ?>