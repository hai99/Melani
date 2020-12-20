<?php 
	
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;

	/**
	 * summary
	 */
	class Contact extends Model
	{
	    protected $table = 'contact';

	    protected $fillable = ['name','email','conSubject','phoneNumber','conMessage','status'];

	}
 
 ?>