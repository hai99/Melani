<?php 
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;

	/**
	 * summary
	 */
	class Comment extends Model
	{
	    protected $table = 'comment';

	    protected $fillable = ['id','content','customerId','blogId','parentId','status'];

	    public function customer(){
	    	return $this->hasOne(Customer::class,'id','customerId');
	    }

	    public function childs(){
	    	return $this->hasMany(Comment::class,'parentId');
	    }

	}
 ?>