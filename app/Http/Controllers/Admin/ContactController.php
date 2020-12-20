<?php 
	namespace App\Http\Controllers\Admin;

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\Category;
	use App\Models\Contact;
	use App\Models\Color;
	use App\Models\Sizes;
	use App\Models\Stocks;
	use Validator;
	use DataTables;
	use Carbon\Carbon;
	use App\Http\Controllers\Controller;
	use Illuminate\Support\Facades\Auth;
	use Mail;
	

	/**
	 * summary
	 */
	class ContactController extends Controller
	{
	    /**
	     * summary
	     */
	    
	    
	    public function index()
	    {
	    	$contacts = Contact::get();
	        return view('admin/contact/index',compact('contacts'));
	    }

	    public function show($id){
	    	$contact = Contact::find($id);
	    	return view('admin/contact/contact-detail',compact('contact'));
	    }

	    public function destroy($id){
	    	$contact = Contact::where('id',$id)->first();
	    	if (isset($contact)) {
	    		$contact->delete();
	    		return response()->json(['success' => 'Xóa thành công!']);
	    	}else{
	    		return response()->json(['errors' => 'Xóa thất bại!']);
	    	}
	    }

	    public function add(){
	    	return view('admin/contact/contact-add');
	    }

	    public function reply(Request $request,$email){
	    	return view('admin/contact/contact-add',compact('email'));
	    }

	    public function send(Request $request){
	    	$rules = [
	    		'email' => 'required|email',
	    		'subject' => 'required',
	    		'content' => 'required'
	    	];
	    	$messages = [
	    		'email.required' => 'Email không được để trống',
	    		'email.email' => 'Email không đúng định dạng',
	    		'subject.required' => 'Chủ đề không được để trống',
	    		'content.required' => 'Nội dung không được để trống'
	    	];
	    	$errors = Validator::make($request->all(),$rules,$messages);
	    	if ($errors->fails()) {
	    		return response()->json(['errors' => $errors->errors()->all()]);
	    	}
	    	Mail::send('email.send-contact',[
		        'email' => $request->email,
		        'subject' => $request->subject,
		        'content' => $request->content,
		        ],function($mail) use($request){
		            $mail->to($request->email);
		            $mail->from('melanibeautyshop@gmail.com');
		            $mail->subject($request->subject);
		        });
		    return response()->json(['success' => 'Gửi thành công!']);
	    }



	    public function clear(Request $request){
	        $contact_id_array = $request->id;
	        $contact = Contact::whereIn('id', $request->id);
	        if ($contact) {
	        	$contact->delete();
	        	return response()->json(['success' => 'Xóa thành công!']);
	        }else{
	        	return response()->json(['erros' => 'Xóa thất bại!']);
	        }
	    }
	    
	}
 ?>