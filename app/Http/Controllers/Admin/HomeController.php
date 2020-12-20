<?php 
	namespace App\Http\Controllers\Admin;

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\Category;
	use App\Models\Contact;
	use App\Models\Orders;
	use App\Models\Customer;
	use App\Models\Color;
	use App\Models\Sizes;
	use App\Models\Stocks;
	use Validator;
	use DataTables;
	use Carbon\Carbon;
	use App\Http\Controllers\Controller;
	use App\Models\ModelHasRoles;
	use App\Models\RoleHasPermissions;
	use Illuminate\Support\Facades\Auth;
	use Spatie\Permission\Models\Role;
	use Spatie\Permission\Models\Permission;
	use Illuminate\Support\Collection;
	

	/**
	 * summary
	 */
	class HomeController extends Controller
	{
	    /**
	     * summary
	     */
	    public function index()
	    {
	    	$listOrd = Orders::get();
	    	$listCus = Customer::get();
	    	$listPro = Product::get();
	    	$listCon = Contact::get();
	    	$currentMonthOrd = Orders::whereYear('created_at', Carbon::now()->year)
	    								->whereMonth('created_at', Carbon::now())->count();
	    	$oneMonthAgoOrd = Orders::whereYear('created_at', Carbon::now()->year)
	    								->whereMonth('created_at', Carbon::now()->subMonth(1)->month)->count();
	    	$twoMonthAgoOrd = Orders::whereYear('created_at', Carbon::now()->year)
	    								->whereMonth('created_at', Carbon::now()->subMonth(2)->month)->count();
	    	$threeMonthAgoOrd = Orders::whereYear('created_at', Carbon::now()->year)
	    								->whereMonth('created_at', Carbon::now()->subMonth(3)->month)->count();
	    	$fourMonthAgoOrd = Orders::whereYear('created_at', Carbon::now()->year)
	    								->whereMonth('created_at', Carbon::now()->subMonth(4)->month)->count();
	    	$fiveMonthAgoOrd = Orders::whereYear('created_at', Carbon::now()->year)
	    								->whereMonth('created_at', Carbon::now()->subMonth(5)->month)->count();
	    	$sixMonthAgoOrd = Orders::whereYear('created_at', Carbon::now()->year)
	    								->whereMonth('created_at', Carbon::now()->subMonth(6)->month)->count();
	    	$sevenMonthAgoOrd = Orders::whereYear('created_at', Carbon::now()->year)
	    								->whereMonth('created_at', Carbon::now()->subMonth(7)->month)->count();
	    	$eightMonthAgoOrd = Orders::whereYear('created_at', Carbon::now()->year)
	    								->whereMonth('created_at', Carbon::now()->subMonth(8)->month)->count();
	    	$nineMonthAgoOrd = Orders::whereYear('created_at', Carbon::now()->year)
	    								->whereMonth('created_at', Carbon::now()->subMonth(9)->month)->count();
	    	$tenMonthAgoOrd = Orders::whereYear('created_at', Carbon::now()->year)
	    								->whereMonth('created_at', Carbon::now()->subMonth(10)->month)->count();
	    	$elevenMonthAgoOrd = Orders::whereYear('created_at', Carbon::now()->year)
	    								->whereMonth('created_at', Carbon::now()->subMonth(11)->month)->count();
	    	$twelveMonthAgoOrd = Orders::whereYear('created_at', Carbon::now()->year)
	    								->whereMonth('created_at', Carbon::now()->subMonth(12)->month)->count();
	        return view('admin/index',compact('listOrd','listCus','listPro','listCon','currentMonthOrd','oneMonthAgoOrd','twoMonthAgoOrd','threeMonthAgoOrd','fourMonthAgoOrd','fiveMonthAgoOrd','sixMonthAgoOrd','sevenMonthAgoOrd','eightMonthAgoOrd','nineMonthAgoOrd','tenMonthAgoOrd','elevenMonthAgoOrd','twelveMonthAgoOrd'));
	    }

	    public function fileIndex(){
	    	return view('admin/file/index');
	    }

	    public function mailbox()
	    {
	        return view('admin/contact/index');
	    }

	    public function login(){
	    	return view('admin/login');
	    }

	    public function post_login(Request $request){
	    	$this->validate($request,[
	    		'name' => 'required',
	    		'password' => 'required'
	    	],[
	    		'name.required' => 'Tên đăng nhập không được để trống',
	    		'password.required' => 'Mật khẩu không được để trống'
	    	]);
	    	if(Auth::attempt($request->only('name','password'),$request->has('remember'))){
                return redirect()->route('admin');
            }else{
                return redirect()->back();
            }
	    }

	    public function logout(){
	    	Auth::logout();
	    	return redirect()->route('login');
	    }
	    
	}
 ?>